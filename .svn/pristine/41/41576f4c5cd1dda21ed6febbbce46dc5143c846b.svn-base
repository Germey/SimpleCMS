<?php 
namespace Manage\Controller;
use Think\Controller;

class ConfigController extends SetController {
    public function __construct() {
        parent::__construct();

    }


    public function index($type=NULL) {
        if(!$type) $type = 'site';
        $this->configs = D("Config")->getConfigByType($type);

        $this->type = $type;
        $this->display();
    }


    public function save() {
        $data = I('post.');

        $config_ids = explode(',', $data['config_ids']);
        foreach ($config_ids as $id) {
            $config['id'] = $id;
            $config['key'] = $data['key'.$id];
            $config['value'] = $data['value'.$id];

            M("Config")->save($config);
        }

        $this->success('更新成功', 'refresh');
    }


    public function render_new() {

        $this->config_fields = D("Field")->getConfigFields();
        $this->title = "新建配置项";

        $html = $this->fetch('new_dialog');
        $dialog = array(
            array("data" => $html, "type" => "dialog"),
            array("data" => "dialog_validator()", "type" => "eval")
        );
        
        json($dialog, "mix");
    }

    public function submit_new() {
        $data = I("post.");

        if(!$data['title'] || !$data['key']) {
            session('error', '显示名称、关键字不能为空');
        } else {
            M("Config")->add($data);
            session('success', '保存成功');
        }
        redirect(U("Config/index?type=custom"));
    }


    public function delete($id=NULL) {
        $id = intval($id);
        if(!$id) return;

        M("Config")->where('id='.$id)->delete();
        session('success', '删除成功');
        json(NULL, 'refresh');
    }
}

?>