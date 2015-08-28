<?php
namespace Manage\Controller;
use Think\Page;

class BannerController extends SetController {

    public function __construct() {
        parent::__construct();

    }
    
    public function index() {

        $this->banners = D('Banner')->order('id')->select();

        $id = intval(I('id'));
        if(!$id) {
            $id = $this->banners[0]['id'];
        }
        $this->banner = D('Banner')->find($id);

        $this->banner_id = $id;

        $this->display();
    }


    public function render_edit($id=0) {
        $id = intval($id);

        if($id) {
            $this->banner = D('Banner')->find($id);
        }
        $this->title = $id?'编辑':'新建' . "Banner/Ad";

        $html = $this->fetch('edit_dialog');
        $dialog = array(
            array("data" => $html, "type" => "dialog"),
            array("data" => "dialog_validator()", "type" => "eval")
        );
        
        json($dialog, "mix");
    }

    public function submit_edit() {
        $data = I("post.");

        if(!$data['title'] || !$data['name']) {
            session('error', '名称/读取关键字不能为空');
        } else {
            $id = M("Banner")->saveOrUpdate($data);
            session('success', '保存成功');
        }
        redirect(U("Banner/index?id=".$id));
    }

    public function save() {
        $data = I('post.');

        // 单独处理一下图片和文件的信息
        if($data['picture_ids']) {
            foreach ($data['picture_ids'] as $img_id) {
                $pictures[$img_id]['link'] = $data['picture_link'.$img_id];
                $pictures[$img_id]['title'] = $data['picture_title'.$img_id];
                $pictures[$img_id]['summary'] = $data['picture_summary'.$img_id];
            }
        }

        D("PictureMapping")->updateMapping($data['id'], 'banner', $pictures);

        // action_log('update_banner', 'banner', $data['id'] ? $data['id'] : $res, UID);
        S("banner_".$data['banner_name'], NULL);
        $this->success('更新成功', U("Banner/index?id=".$data['id']));
    }

    public function delete($id=0) {
        $id = intval($id);
        if(!$id) return;

        M("Banner")->where('id='.$id)->delete();

        $filter = array('object_id'=>$id, 'object_type' => 'banner');
        M("PictureMapping")->where($filter)->delete();

        session('success','删除Banner/Ad成功');
        json(U('Banner/index'),'redirect');
    }
}