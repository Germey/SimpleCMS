<?php 
namespace Manage\Controller;
use Think\Controller;

class SetController extends ManageBaseController {
    public function __construct() {
        parent::__construct();

        $this->left_menus = $this->_generate_menus();

    }
    
    public function index() {
        $this->redirect($this->left_menus[1]['link']);
    }

    private function _generate_menus() {
        $config_types = D("Config")->getTypes();
        foreach ($config_types as $k => $v) {
            if($v['developer_display'] && !session('developer_mode')) { //如果不是developer就不显示
                unset($config_types[$k]);
            } else {
                $config_submenu[$k]['title'] = $v['title'];
                $config_submenu[$k]['link'] = U('Config/index?type=' . $v['name']);
                if(strtolower(CONTROLLER_NAME)=='config' && I('type')==$v['name']) {
                    $config_submenu[$k]['is_active'] = 1;
                }
            }
            
        }

        $database_submenu = D('Database')->sub_menu();
        foreach($database_submenu as $k=>$v) {
            if(I('type') == $v['name']) {
                $database_submenu[$k]['is_active'] = 1;
            }
        }
        $menus = array(
                array('title'=>'配置管理', 'icon' => 'hi hi-cog', 'type'=>'header'),
                array('title'=>'栏目管理', 'link'=>U('Category/index'), 'name' => 'category', 'auth' => 'manager'),
                array('title'=>'广告/Banner', 'link'=>U('Banner/index'), 'name' => 'banner', ),
                array('title'=>'文章作者', 'link'=>U('Author/index'), 'name' => 'author', ),
                array('title'=>'文章标签', 'link'=>U('Tag/index'), 'name' => 'tag', ),
                array('title'=>'系统配置', 'link'=>U('Config/index?type=site'),  'submenu'=> $config_submenu, 'name' => 'config', 'auth' => 'manager'),
                array('title'=>'内容扩展', 'link'=>U('Extend/index'), 'name' => 'extend', 'developer_display' =>true, 'auth' => 'manager'),
                array('title'=>'数据库备份', 'link'=>U('Database/index?type=export'),  'submenu'=> $database_submenu, 'name' => 'database', 'auth' => 'manager'),

        );

        if($this->login_user['role']=='editor') {
            foreach ($menus as $k => $v) {
                if($v['auth']=='manager') {
                    unset($menus[$k]);
                }
            }
            $menus = array_values($menus);
        }

        // 设置选中的
        foreach ($menus as $k => $v) {
            if(strtolower(CONTROLLER_NAME)==$v['name']) {
                $menus[$k]['is_active'] = 1;
            }
            if($v['developer_display'] && !session('developer_mode')) { //如果不是developer就不显示
                unset($menus[$k]);
            }
        }

        return $menus;
    }
}

?>