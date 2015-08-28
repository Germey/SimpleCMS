<?php

namespace Home\Model;
use Think\Model;


class UserModel extends Model {

        /* 用户模型自动完成   array('field','填充内容','填充条件','附加规则',[额外参数])*/
        protected $_auto = array(
            // array('update_time', 'date', Model::MODEL_BOTH, 'function', array('Y-m-d H:i:s')),
            array('create_time', 'date', Model::MODEL_INSERT, 'function', array('Y-m-d H:i:s')),
        );

    function  _after_find(&$result,$options){
        if($result['address']) {
            $result['address'] = explode('///', $result['address']);
        }
    }


    /* 用户模型自动验证 */
    protected $_validate = array(
        /* 验证用户名 */
        // array('username', '1,30', -1, self::EXISTS_VALIDATE, 'length'), //用户名长度不合法
        // array('username', '', -3, self::EXISTS_VALIDATE, 'unique'), //用户名长度不合法

        /* 验证密码 */
        // array('password', '6,60', -4, self::EXISTS_VALIDATE, 'length'), //密码长度不合法

        /* 验证邮箱 */
        // array('email', 'email', -5, self::EXISTS_VALIDATE), //邮箱格式不正确
        // array('email', '1,32', -6, self::EXISTS_VALIDATE, 'length'), //邮箱长度不合法
        // array('email', '', -8, self::EXISTS_VALIDATE, 'unique'), //邮箱被占用

        /* 验证手机号码 */
        // array('mobile', '//', -9, self::EXISTS_VALIDATE), //手机格式不正确 TODO:
        // array('mobile', '', -11, self::EXISTS_VALIDATE, 'unique'), //手机号被占用
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

    public function updateFieldsById($uid, $data, $old_password) {
        $user_id = intval($uid);
        if(!$user_id) return $this->error = "您还没有登陆";
        $data['id'] = $user_id;

        //更新前检查用户密码
        if($old_password && !$this->verifyUser($user_id, $old_password)){
            $this->error = '验证出错：密码不正确！';
            return false;
        }

        if($data['password']){
            $data['password'] = gen_password($data['password']);
        } 

        if($this->create($data)) {
            $this->saveOrUpdate();
        }
        return true;
    }

    /**
     * 注册一个新用户
     * @param  string $username 用户名
     * @param  string $password 用户密码
     * @param  string $email    用户邮箱
     * @param  string $mobile   用户手机号码
     * @return integer          注册成功-用户信息，注册失败-错误编号
     */
    public function register($data){

        if(empty($data)) return 0;
        if($data['address']) $data['address'] = implode("///", $data['address']);
        if(!$data['role']) $data['role'] = 'contribute';
        $data['password'] = gen_password($data['password']);
        
        /* 添加用户 */
        if($this->create($data)){
            $uid = $this->add();
            return $uid ? $uid : 0; //0-未知错误，大于0-注册成功
        } else {
            return $this->getError(); //错误详情见自动验证注释
        }
    }


    /*
     *
     *
     */
    public function getUsersByTypeId($ids, $type="", $field='id, username, avatar'){
        if(!$ids || !$type) return null;
        if(!is_array($ids)) settype($ids, $ids);
        $condition[$type] = array('in', $ids);
        $condition['category_id'] = array('gt', 0);
        $condition['create_user_id'] = array('gt', 0);
        $user_ids = D('Content')->distinct(true)->field('create_user_id')->where($condition)->getField('create_user_id', true);
        if(!$user_ids) return null;
        $filter['id'] = array('in', $user_ids);

        $users = $this->field($field)->where($filter)->select();

        foreach ($users as $key => $user) {
         $condition['create_user_id'] = $user['create_user_id'];

     }
     return $users;
 }


    /**
     * 验证用户密码
     * @param int $uid 用户id
     * @param string $password_in 密码
     * @return true 验证成功，false 验证失败
     * @author huajie <banhuajie@163.com>
     */
    protected function verifyUser($uid, $password_in){
        $password = $this->getFieldById($uid, 'password');
        if(gen_password($password_in) === $password){
            return true;
        }
        return false;
    }


}
