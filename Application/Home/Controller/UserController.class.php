<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Home\Controller;
use User\Api\UserApi;
use Common\Api\MailApi;
use Think\Crypt;

/**
 * 用户控制器
 * 包括用户中心，用户登录及注册
 */
class UserController extends HomeController {

    public function __construct(){
        parent::__construct();
        if(!C('register_is_enable')){
            $this->error('注册已关闭');
        }

    }

    /* 注册页面 */
    public function register(){

        //注册用户
        if(IS_POST){
            $data = $_POST;
            if($data['register_code'] != C('register_code')) {
                session('error', '注册邀请码不正确！');
                redirect("/user/register");
            }

            /* 检测验证码 */
            if(!check_captcha($data['captcha'])){
                session('error', '验证码输入错误！');
                redirect("/user/register");
            }

            if(!valid_email($data['email'])){
                session('error', '邮箱格式不正确！');
                redirect("/user/register");
            }

            /* 检测密码 */
            if(!$data['password'] || !$data['repassword']) {
                session('error', '密码不能为空！');
                redirect("/user/register");
            }

            if($data['password'] != $data['repassword']){
                session('error', '密码和重复密码不一致！');
                redirect("/user/register");
            }

            //验证信息
            $data['reg_verify_code'] = gen_password($data['email'] . time());


            /* 调用注册接口注册用户 */
            $uid = D('User')->register($data);

            if(0 < $uid){
                //TODO: 发送验证邮件
                $url = 'http://'. $_SERVER['HTTP_HOST'] . '/user/reg_verify?regcode=' . $data['reg_verify_code'];
                $url = '<a href="'.$url.'">'.$url.'</a>';

                MailApi::sendEmail($from, $data['email'], '账户激活连接', "点击以下链接激活账户:"  .$url);
                $this->regcode = $regcode;
                $this->display('reg_verify');
                redirect('/user/display_reg_result?email=' .$data['email']);
            } else { //注册失败，显示错误信息
                session('error', $this->showRegError($uid));
                $this->display();
            }
        } else { //显示注册表单
            $this->display();
        }
    }

    function reg_verify() {
        $regcode = I('regcode');
        $condition['reg_verify_code'] = $regcode;
        $user = D('User')->where($condition)->find();
        if(!$user) {
            session('error', "验证信息错误, 此链接无效");
            redirect('/user/login');
        }

        $info['reg_verify_code'] = '';
        D("user")->updateFieldsById($user['id'], $info);
        redirect('/user/display_reg_result');
    }

    function display_reg_result(){
        $this->email = I('email');
        $this->display('reg_verify');
    }


    public function forgot_pwd(){
        if(IS_POST) {
            $data =  $_POST;
            /* 检测验证码 */
            if(!check_captcha($data['captcha'])){
                session('error', '验证码输入错误！');
                redirect("/forgot_pwd");
            }

            if(!valid_email($data['email'])){
                session('error', '邮箱格式不正确！');
                redirect("/forgot_pwd");
            }

            $user = D('User')->field('id, email, username')->getByEmail($data['email']);

            if($user) {
                $subject ="找回密码";
                $this->username = $user['username'];
                $repwdcode = gen_password($user['email'] . "+" . time());
                $info['repwdcode'] = $repwdcode;
                $result = D('User')->updateFieldsById($user['id'], $info);
                if($result) {
                    $url = 'http://'. $_SERVER['HTTP_HOST'] . '/user/resetpwd?rpcode=' . $repwdcode;
                    $this->content = '<a href="'.$url.'">'.$url.'</a>';
                    $html = $this->fetch("public:send_mail_template");

                    $from['reply'] = "taoshuanghu@justering.com";
                    $from['name'] = "taoshuanghu";

                    MailApi::sendEmail($from, $data['email'], '找回密码', $html);
                    redirect('display_success?username=' .$user['username'] . '&email=' .$user['email']);
                }else{
                    $this->error("申请修改密码未通过，建议重新申请");
                }
            } else {
                session('error', '邮箱不存在, 请重新输入');
                redirect("/forgot_pwd");
            }

        } else {
            $this->display();
        }
    }

    public function resetpwd(){
        $repwdcode  = I('rpcode');
        $this->user = D('User')->field('password', true)->getByRepwdcode($repwdcode);
        if(!$this->user) {
            session('error', "连接失效，建议重新申请");
            redirect(U('User/login'));
        }
        $this->display();
    }

    public function resetpwd_submit() {
        $data = $_POST;
        /* 检测验证码 */
        if(!check_captcha($data['captcha'])){
            session('error', "验证码输入错误！");
            redirect('/user/resetpwd?rpcode=' . $data['repwdcode']);
        }

        if($data['password'] != $data['repassword']) {
            session('error', "两次密码输入不一致!");
            redirect('/user/resetpwd?rpcode=' . $data['repwdcode']); 

        }

        $condition['id'] = $data['id'];
        $condition['repwdcode'] = $data['repwdcode'];
        $user = D('User')->where($condition)->find();

        if(!$user) {
            session('error', "用户信息不正确，请重新申请");
            redirect('/user/forgot_pwd');
        }

        $info['repwdcode'] = ""; 
        $info['password'] = $data['password']; 
        D('User')->updateFieldsById(intval($data['id']), $info);
        session('success', '密码修改成功! ');        
        redirect(U('User/login'));
    }

    public function display_success() {
        $this->username =I('username');
        $this->email =I('email');
        $this->display('apply_success');
    }

    /* 登录页面 */
    public function login($username = '', $password = '', $captcha = ''){

        if(IS_POST){
            /* 检测验证码 */
            if(!check_captcha($captcha)){
                $this->error('验证码输入错误！');
            }

            if(!valid_email($username)){
                $this->error('邮箱格式不正确！');
            }        
            $reg_verify_code = D('User')->field('reg_verify_code')->getByEmail($username);
            if($reg_verify_code['reg_verify_code']) {
                $regcode = explode('+', $user['reg_verify_code']);
                $this->error('您还没有验证邮箱');
                $this->redirect( U('User/reg_verify?regcode=' .$regcode[0]));
            }

            $user = D('User')->login($username, $password);
            if($user['id']) {
                $this->success('登录成功！', U('Dashboard/list_contents?status=2'));
            } else {
                $this->error('用户名或密码错误');
            }
        } else {
            //显示登录
            if(UID){
                $this->redirect(U('Dashboard/edit_user'));
            }else{
                $this->display();
            }

        }
    }

    public function logout(){
        if(UID) {
            D('User')->logout();
            session('success', "成功退出");
            $this->redirect(U('login'));
        } else {
            $this->redirect('login');
        }
    }


    /**
     * 获取用户注册错误信息
     * @param  integer $code 错误编码
     * @return string        错误信息
     */
    private function showRegError($code = 0){
        switch ($code) {
            case -1:  $error = '用户名长度必须在16个字符以内！'; break;
            case -2:  $error = '用户名被禁止注册！'; break;
            case -3:  $error = '用户名被占用！'; break;
            case -4:  $error = '密码长度必须在6-30个字符之间！'; break;
            case -5:  $error = '邮箱格式不正确！'; break;
            case -6:  $error = '邮箱长度必须在1-32个字符之间！'; break;
            case -7:  $error = '邮箱被禁止注册！'; break;
            case -8:  $error = '邮箱被占用！'; break;
            case -9:  $error = '手机格式不正确！'; break;
            case -10: $error = '手机被禁止注册！'; break;
            case -11: $error = '手机号被占用！'; break;
            default:  $error = '未知错误';
        }
        return $error;
    }

    // 生成登录验证码
    function common_captcha(){
        ob_get_clean();
        $v = new \Think\PhpCaptcha(null,120,50);
        $v->UseColour(true);
        $v->SetNumChars(4);
        $v->Create();
    }

    public function top_content_contribute() {
        $size = intval(I('size'))?intval(I('size')):20;
        $filter['group'] = 'create_user_id';
        $filter['has_user_info'] = true;
        $filter['child_content_count'] = array('gt', 0);
        $this->user_list = D('Content')->getLists(null, null, $filter,0, 0, 1, $size);
        
        $this->display();
    }
}
