<?php
namespace Manage\Controller;
use Think\Controller;

class UserController extends ManageBaseController {
    public function __construct() {
        parent::__construct();
        $this->left_menus = $this->_generate_menus();
        $this->manager_role = D('User')->managerRole();
        $this->category = D('Category')->getTree(0);
    }

    public function index() {

        // $filter['manager'] = 'Y';
        $filter['id'] = array('neq',1);

        if($_GET['susername']) {
            $this->susername = I('susername');
            $filter['username']  = array('like', '%'.(string)I('susername').'%');
        }

        $user = D('User');
        $list = $this->lists($user,$filter,'id asc');
        foreach($list as $k=>$v) {
            $list[$k] = $user->Rich($v);
        }
        $this->user_list = $list;
        
        // 记录当前列表页的cookie
        Cookie('__forward__',$_SERVER['REQUEST_URI']);
        $this->display();
    }
    
    public function render_profile($id=0) {

        $this->user = D("User")->getById($id);
        $this->title = "修改用户名密码";

        $html = $this->fetch('profile_dialog');
        $dialog = array(
            array("data" => $html, "type" => "dialog"),
            array("data" => "dialog_validator()", "type" => "eval")
        );
        
        json($dialog, "mix");
    }

    /**
     * 修改用户密码
     */

    public function changePassword() {
        //规则：developer &&admin 可以修改任何人的密码 
        //检测当前用户
        $login_user = $this->login_user;
        $user_id = I('user_id','intval');
        if($login_user['role'] == 'manager' || $user_id==UID) {
            $this->render_profile($user_id);            
        } else {
            session('error','你没权限修改密码,请与管理员联系');
            json(NULL,'refresh');
        }
    }

    public function submit_profile() {
        $data = I("post.");

        if(!$data['id'] || !$data['username'] || !$data['password']) {
            $this->error('用户名密码不能为空');
        }

        unset($data['password2']);
        $data['password'] = gen_password($data['password']);
        M("User")->save($data);

        session('success', '账户密码修改成功');
        if($data['id'] == 1) {
            redirect(U('public/logout'));
        } else {
            redirect('index');
        }

    }

    public function render_edit() {
        $this->user_id = $user_id = I('user_id');
        $this->manager_role = $manager_role = I('manager_role');
        if($user_id) {
            $this->user = $user =  D('User')->getUserById($user_id);
            $category_display =  unserialize($user['category_display']); 
            if(is_array($category_display)) {
                $this->ids = array_keys($category_display);
            }
        }
        $this->title = $user_id ? '编辑管理员/编辑' : '新增管理员/编辑';

        $html = $this->fetch('edit_dialog');
        $dialog = array(
            array("data" => $html, "type" => "dialog"),
            array("data" => "dialog_validator()", "type" => "eval")
        );
        
        json($dialog, "mix");
    }

    public function submit_edit() {
        $data = I('post.','htmlspecialchars');
        // var_dump($data);die;
        $data_user['id'] = $data['id'];
        $data_user['username'] = $data['username'];
        $data_user['role'] = $data['manager_role'];
        $data_user['email'] = $data['email'];
        $data_user['manager'] = 'Y';
        if(!$data['id']) {
            $data_user['password'] = gen_password($data['password']);
            $data_user['create_time'] = time();
        }
        
        if($data['manager_role']!= 'manager') {
            $category_display = D('Category')->where(array('id'=>array('in',explode(',', $data['cids']))))->getField('id,title',true);
        
            $data_user['category_display'] = serialize($category_display);
        }
        $user_id = M('User')->saveOrUpdate($data_user);
        
        session("highlight_id",$user_id);
        
        redirect(U('User/index'));
    }

    public function delete($id) {
        $id = intval($id);
        if($this->login_user['uid'] ==1 || $this->login_user['uid'] == 2) {
            if($id == 1 || $id == 2){
                session('error','超级管理员不能删除');
                json(NULL,'refresh');
            } else {
                M('User')->where(array('id'=>$id))->delete();   
                session('success','删除用户成功');
                json(NULL,'refresh');
            } 
        } else {
            session('error','你没权限删除用户');
            json(NULL,'refresh');
        }
    }

    private function _generate_menus() {
 
        $menus = array(
                array('title'=>'用户管理', 'icon' => 'fa fa-user', 'type'=>'header'),
                array('title'=>'管理员/编辑管理', 'link'=>U('User/index'), 'name' => 'index', ),

        );
        // 设置选中的
        foreach ($menus as $k => $v) {
            if(strtolower(ACTION_NAME)==$v['name']) {
                $menus[$k]['is_active'] = 1;
            }
        }

        return $menus;
    }

    public function get_info() {

        if($_GET['sweixin']) {
            $this->sweixin = I('sweixin');
            $filter['weixin']  = array('like', '%'.(string)I('sweixin').'%');
        }
        $this->lists = M('FormInfo')->where($filter)->order('create_time desc')->select();
        $this->display();
    }

}

?>