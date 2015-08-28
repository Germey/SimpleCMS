<?php
namespace Manage\Controller;
use Think\Controller;

class TagController extends SetController {
    
    public function __construct(){
        parent::__construct();

        $this->model_fields = D("Field")->getTagFields();
    }

    function index() {

        $content = D('Tag');
        // $filter[] = array();
        if($_GET['sname']) {
            $this->sname = I('sname');
            $filter['name']  = array('like', '%'.(string)I('sname').'%');
        }
        $this->tags = $this->lists($content,$filter, 'convert(name USING gbk) COLLATE gbk_chinese_ci asc', NULL);

        $this->tag_content_map = D("Tag")->getTagContentMap();

        $this->display();
    }


    public function edit() {
        $id = I('get.id');
        $this->author = M("Tag")->getById($id);
        $this->display();
    }

    public function save() {
        $data = I('post.');
        $id = M("Tag")->saveOrUpdate($data);

        $this->success(intval($data['id'])?'更新成功':'新增成功', '/manage/tag');
    }

    public function delete($id) {
        $id = intval($id);
        // 关联文章

        M('Tag')->where(array('id'=>$id))->delete();
        session('success','删除标签成功');
        json(NULL,'refresh');
    }

    public function ajax_search_for_input(){
        $q = I("q");
        $tags = M("Tag")->field(array("id", "name"))->where(array("name" => array("like", "%$q%")))->limit(10)->select();

        // 如果不存在，就返回自己
        if(!$tags) {
            $tags[] = array('id' => 'newtag_'.$q, 'name' => $q);
        }

        $result = array();
        foreach ($tags as $tag) {
            $result[] = array(
                "id" => $tag['id'],
                "name" => $tag['name'],
                );
        }

        echo json_encode($result);
    }
}