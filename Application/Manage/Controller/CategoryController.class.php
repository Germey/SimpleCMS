<?php
namespace Manage\Controller;
use Think\Page;

class CategoryController extends SetController {

    public function __construct() {
        parent::__construct();

        $this->model_fields = D("Field")->getCategoryFields();

        $this->tree = D('Category')->getTree(0,'id,name,title,sort,pid,status');
    }
    
    public function index() {

        $id = intval(I('id'));
        if(!$id) {
            $id = $this->tree[0]['id'];
        }
        $this->category = D('Category')->find($id);

        $this->category_id = $id;

        $this->category_content_count = D('Content')->getCountByCategoryId($id);
        
        $this->pid = $this->category['pid'];
        $this->display();
    }

    public function create() {
        $this->pid = intval(I('pid'));
        if($this->pid) {
            $category['parent_title'] = M('Category')->where('id='.$this->pid)->getField('title');
        }
        $this->category = $category;
        $this->display('index');
    }

    public function save() {
        $data = I('post.');

        // 组合models
        for($i=1; $i<10; $i++) {
            if($data['model_ids'.$i]) {
                $models[$i] = $data['model_templates'.$i];
            }
            if($data['children_model_ids'.$i]) {
                $children_models[$i] = $data['children_model_templates'.$i];
            }
        }

        $data['models'] = serialize($models);
        $data['children_models'] = serialize($children_models);
        
        if(trim($data['link']) == C('CATEGORY_LINK').'{id}') {
            $data['link'] = C('CATEGORY_LINK').$data['id'];
        }elseif(trim($data['link']) == C('CATEGORY_LINK').'{name}') {
            $data['link'] = C('CATEGORY_LINK').$data['name']; 
        }

        $cid = D('Category')->update($data);
        if(!$data['id'] && $cid) {
            M('Category')->data(array('link'=>C('CATEGORY_LINK').$cid))->where(array('id'=>$cid))->save();
        }
        if(!$cid) {
            $this->error(D('Category')->getError());
        } else {
            // action_log('update_category', 'category', $data['id'] ? $data['id'] : $res, UID);
            S("category_info_".$data['id'], NULL);
            $this->success(intval($_POST['id'])?'更新成功':'新增成功', U("Category/index?id=".$cid));
        }
    }

    public function batch_create_category_dialog() {
        $pid = I('pid');
        if($pid) {
            $this->pid = $pid;
            $category_title = M('Category')->where(array('id'=>$pid))->getField('title');
            $this->title = "批量创建<span class='text-success'> ".$category_title." </span>的子频道";
        }else {
            $this->title = '批量创建频道';
        }

        $html = $this->fetch('category_dialog');
        $dialog = array(
            array("data" => $html, "type" => "dialog"),
            array("data" => "dialog_validator()", "type" => "eval")
        );

        Cookie('__forward__',$_SERVER['REQUEST_URI']);
        json($dialog, "mix");       
    }

    public function submit_batch_create() {
        $data = I('post.');
        foreach($data['title'] as $k=>$v) {
            $d['title'] = $data['title'][$k];
            $d['name'] = change_to_pinyin(strtolower($data['title'][$k]),1);
            $d['type'] = $data['type'][$k];
            if($data['pid']) {
                $d['pid'] = $data['pid'];
            }
            
            if(in_array($k, $data['is_menu'])) {
                $d['is_menu'] = 1;
            }else {
                $d['is_menu'] = 0;
            }

            $id = M('Category')->data($d)->add();
            if($id) {
                $res[] = $d['title'];
            }
        }
        session('success','栏目'.implode(',',$res).' 添加成功');
        redirect(U('category/index?id='.$data['pid']));
    }

    public function delete($id=0) {
        $id = intval($id);
        if(!$id) return;

        $count = D('Content')->getCountByCategoryId($cid);
        if($count) {
            session('error','栏目下面（包括回收站）还有内容，不能删除');
            json(NULL, 'refresh');
        }

        M("Category")->where('pid='.$id)->delete();
        M("Category")->where('id='.$id)->delete();

        session('success','删除栏目成功');
        json(U('Category/index'),'redirect');
    }


    public function clear_cache() {
        $files = glob(TEMP_PATH . '/*.php'); // get all file names
        foreach($files as $file){ // iterate files
          if(is_file($file))
            unlink($file); // delete file
        }
        session('success','清除栏目缓存成功');
        json(NULL, 'refresh');
    }
}