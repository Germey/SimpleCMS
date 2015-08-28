<?php
namespace Manage\Controller;
use Think\Controller;

class AuthorController extends SetController {

    public function __construct(){
        parent::__construct();

        $this->model_fields = D("Field")->getAuthorFields();
    }

    public function index() {
        $content = D('Author');
        // $filter[] = array();
        if($_GET['sname']) {
            $this->sname = I('sname');
            $filter['name']  = array('like', '%'.(string)I('sname').'%');
        }
        $this->authors = $this->lists($content,$filter, 'convert(name USING gbk) COLLATE gbk_chinese_ci asc',NULL);

        $this->author_content_map = D("Author")->getAuthorContentMap();
        $this->display();
    }

    public function edit() {
        $id = I('get.id');
        $this->author = M("Author")->getById($id);
        $this->display();
    }

    public function save() {
        $data = I('post.');
        $id = M("Author")->saveOrUpdate($data);

        $this->success(intval($data['id'])?'更新成功':'新增成功', '/manage/Author');
    }

    public function delete($id) {
        $id = intval($id);
        // 关联文章检查
        
        // $count = D("Author")->getAuthorContentMap($id);
        
        M('Author')->where(array('id'=>$id))->delete();
        session('success','删除作者成功');
        json(NULL,'refresh');
    }


    // 搜索提示
    public function ajax_search_for_input() {

        $name = I('get.query');
        $f['name'] = array('like', "%$name%");

        $raw = M("Author")->where($f)->select();
        if($raw) {
            foreach ($raw as $k => $v) {
                $res[] = $v['name'];
            }
        } else {
            $res[] = $name;
        }

        echo json_encode($res);
    }
}