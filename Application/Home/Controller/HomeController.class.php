<?php
namespace Home\Controller;
use Think\Controller;
use Common\Controller\BaseController;
/**
 * 前台公共控制器
 * 为防止多分组Controller名称冲突，公共Controller名称统一使用分组名称
 */
class HomeController extends BaseController {

    /* 空操作，用于输出404页面 */
    public function _empty(){
        $this->redirect('Index/index');
    }

    protected function _initialize() {
        parent::_initialize();
        /*加入用户模块时打开*/
        define('UID', is_login());

        D('Content')->publishDueContents(); //定时发布

        $wap = check_wap();//访问首页的时候如果是手机用户访问跳转到mobile显示
        if($wap && C('OPEN_WAP_TPL') ) {
            $this->iswap = true;
            layout('layout_wap');
        }else{
            $this->iswap =false;
        }

        $this->login_user = session('user_auth');

        // set visit
        $visit = array(
                'ip' => get_remote_ip(),
                'http_user_agent' => htmlspecialchars($_SERVER['HTTP_USER_AGENT']),
                'http_referer' => htmlspecialchars($_SERVER['HTTP_REFERER']),
                'uri' => htmlspecialchars($_SERVER['REQUEST_URI']),
                'module' =>  strtolower(CONTROLLER_NAME),
                'module_id' => I('id'),
                'request' => serialize($_REQUEST),
                'first_get' => array_shift(I('get.')),   // 第一个get
            );
        D("Visit")->add($visit);

    }

	protected function login(){
		is_login() || $this->error('您还没有登录，请先登录！', U('User/login'));
	}

 
    protected function display($templateFile='',$charset='',$contentType='',$content='',$prefix='') {
        
        if(!$templateFile) {
            $templateFile =  strtolower(CONTROLLER_NAME . '/' . ACTION_NAME);
        }

        // TODO white_list 数据库得出可以显示的CONTROLLER_NAME
        if($this->iswap) {
            $templateFile = 'wap/' . $templateFile;
        }
        parent::display($templateFile);
    }

}