<?php

namespace Manage\Model;
use Think\Model;


class UserModel extends Model {

    protected $_validate = array(
        array('username', '1,16', '用户名长度为1-16个字符', self::EXISTS_VALIDATE, 'length'),
        array('username', '', '用户名被占用', self::EXISTS_VALIDATE, 'unique'), //用户名被占用
    );

    public function lists($status = 1, $order = 'uid DESC', $field = true,$limit = '20'){
        $map = array('status' => $status);
        return $this->field($field)->where($map)->order($order)->limit($limit)->select();
    }


    public function login($username, $password) {
        if(strpos($username, '@')) {
            $filer['email'] = $username;
        } else {
            $filer['username'] = $username;
        }
        $filer['password'] = gen_password($password);

        $user = $this->where($filer)->find();

        if(!$user || 1 != $user['status']) {
            $this->error = '用户不存在或已被禁用！';
            return false;
        }

        action_log('user_login', 'member', $user['id'], $user['id']);

        /* 登录用户 */
        $this->autoLogin($user);
        return $user;
    }


    public function logout(){
        session('user_auth', null);
        session('user_auth_sign', null);
    }

    /**
     * 自动登录用户
     * @param  integer $user 用户信息数组
     */
    private function autoLogin($user){
        $data = array(
            'id'             => $user['id'],
            'login'           => array('exp', '`login`+1'),
            'last_login_time' => NOW_TIME,
            'last_login_ip'   => get_client_ip(),
        );        
        $this->save($data);

        /* 记录登录SESSION和COOKIES */
        $auth = array(
            'uid'             => $user['id'],
            'username'        => $user['username'],
        );

        session('user_auth', $auth);
        session('user_auth_sign', data_auth_sign($auth));
    }

    public function getUserName($id){
        return $this->where(array('id'=>(int)$id))->getField('username');
    }

    /**
     * 获取所有管理员和编辑
     */
        public function getManageUsers($filter =null) {
            $where = array('manager'=>'Y','username'=>array('neq','developer'));
            if($filter) {
                $where = array_merge($where,$filter);
            }
            $users = $this->where($where)->select();
            foreach($users as $k=>$user) {
                $users[$k] = $this->Rich($user);
            }

            return $users;
        }


    public function getUserById($id) {
        $user = $this->where(array('id'=>$id))->find();
        if($user['manager'] == 'Y') {
            $user = $this->Rich($user);
        }

        return $user;
    }

    public function Rich($user) {
        $managerRole = $this->managerRole();
        $user['type_display_name'] = $managerRole[$user[role]]['name'];
            if($user['role'] == 'manager') {
                $user['category_display'] = '全部栏目';
            }else {
                $category_display = D('User')->where(array('id'=>$user['id']))->getField('category_display');
                $user['category_display'] =  unserialize($category_display);
                $user['category_ids'] = array_keys(unserialize($category_display));

            }

        return $user;
    }

        public function managerRole() {
            return array(
               'manager' => array('name'=>'管理员','type'=>'manager','icon_class' => ''),
               'editor' => array('name'=>'编辑','type'=>'editor'),
               'contribute' => array('name'=>'投稿成员','type'=>'contribute'),
               );
        }

    }
