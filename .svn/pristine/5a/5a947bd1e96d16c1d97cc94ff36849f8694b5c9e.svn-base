<?php
namespace Manage\Controller;
use Think\Page;

class ExtendController extends SetController {

    public function __construct() {
        parent::__construct();

        $this->field_types = D('Extend')->getExtendFieldTypes();
    }

    public function index() {

        $this->extends = D('Extend')->select();

        $id = intval(I('id'));
        if(!$id) {
            $id = $this->extends[0]['id'];
        }
        $this->extend = D('Extend')->find($id);

        $this->extend_id = $id;

        $this->display();
    }


    public function render_edit($id=0) {
        $id = intval($id);

        if($id) {
            $this->extend = D('Extend')->find($id);
        }
        $this->title = $id?'编辑':'新建' . "扩展字段方案";

        $html = $this->fetch('edit_dialog');
        $dialog = array(
            array("data" => $html, "type" => "dialog"),
            array("data" => "dialog_validator()", "type" => "eval")
        );

        json($dialog, "mix");
    }

    public function submit_edit() {
        $data = I("post.");

        if(!$data['title']) {
            session('error', '方案不能不能为空');
        } else {
            $id = M("Extend")->saveOrUpdate($data);
            session('success', '保存成功');
        }
        redirect(U("Extend/index?id=".$id));
    }

    public function save() {
        $data = I('post.');
        for($i=0; $i<100; $i++) {
            if($data['extends_title'][$i] && $data['extends_name'][$i] && $data['extends_type'][$i]) {
                $extends[$i]['title'] = trim($data['extends_title'][$i]);
                $extends[$i]['name'] = trim($data['extends_name'][$i]);
                $extends[$i]['tip'] = trim($data['extends_tip'][$i]);
                $extends[$i]['type'] = $data['extends_type'][$i];
                if($data['extends_type'][$i] == 'radio' || $data['extends_type'][$i] == 'checkbox') {
                    $extends[$i]['options'] =  preg_replace('/\s+/', ' ', $data['extends_option'][$i]);
                }
            }
        }
        unset($data['extends_title']);
        unset($data['extends_name']);
        unset($data['extends_type']);
        unset($data['extends_tip']);
        unset($data['extends_option']);

        $data['extends'] = serialize($extends);

        $cid = D('Extend')->saveOrUpdate($data);
        if(!$cid) {
            $this->error(D('Extend')->getError());
        } else {
            // action_log('update_extend', 'extend', $data['id'] ? $data['id'] : $res, UID);
            $this->success('更新成功', U("Extend/index?id=".$cid));
        }
    }

    public function delete($id=0) {
        $id = intval($id);
        if(!$id) return;

        M("Extend")->where('id='.$id)->delete();

        session('error','删除扩展方案成功');
        json(U('Extend/index'),'redirect');
    }
}