<?php

namespace Manage\Controller;
// use Admin\Model\AuthGroupModel;
use Think\Page;

class ContentController extends ManageBaseController {

    public function __construct() {
        parent::__construct();

        // $this->getMenu();

        $this->models = D("Model")->getModels();
        $this->statuses = D("Status")->getContentStatus();
        $this->seditors = D("User")->getField('id,username',true);

        $this->id = $id = I('get.id',0);
        $this->model_id = I('get.model_id',1);

        $this->category_id = I('get.category_id',0);
        if(!$this->category_id) {
            $this->category_id = I('get.cid',0);
        }

        // 有内容，编辑页
        if($this->id) {
            $this->content = D('Content')->detail($this->id);
            $this->model_id = $this->content['model_id'];
            $this->category_id = $this->content['category_id'];
        }

        $this->model = $this->models[$this->model_id];
        $this->category = D("Category")->getById($this->category_id);

        $this->available_model_ids = array_keys($this->models);
        if($this->category) {
            $this->available_model_ids = array_keys($this->category['models']);
        }

        $this->default_new_model_id = $this->available_model_ids[0];

        // TODO 扩展还没.过滤一下后台设置不显示的字段
        $this->model_fields = D("Field")->getContentFields($this->model_id, $this->category_id);

        // 做一下权限的处理
        $user = $this->login_user;
        if($user['role'] != 'manager') {
            $ids = D('Category')->getIdsForTree($user['category_ids']);
            $filter['id'] = array('in',$ids);
        }
        $this->category_tree = D('Category')->getTree(0,false,$filter);

        $this->breadcrumb_info = D("Category")->getParentCategory($this->category_id);

        $this->left_menus = $this->_generate_menus($this->category_tree, array(), 0);

    }

    /**
     * 检测需要动态判断的文档类目有关的权限
     *
     * @return boolean|null
     *      返回true则表示当前访问有权限
     *      返回false则表示当前访问无权限
     *      返回null，则会进入checkRule根据节点授权判断权限
     *
     */
    // protected function checkDynamic() {

    //     if(IS_ROOT) {
    //         return true;//管理员允许访问任何页面
    //     }
    //     $cates = AuthGroupModel::getAuthCategories(UID);
    //     switch(strtolower(ACTION_NAME)) {
    //         case 'index':   //文档列表
    //             $cate_id =  I('cate_id');
    //             break;
    //         case 'edit':    //编辑
    //         case 'update':  //更新
    //             $doc_id  =  I('id');
    //             $cate_id =  D("Content")->where(array('id'=>$doc_id))->getField('category_id');
    //             break;
    //         case 'setstatus': //更改状态
    //         case 'permit':    //回收站
    //             $doc_id  =  (array)I('ids');
    //             $cate_id =  D("Content")->where(array('id'=>array('in',$doc_id)))->getField('category_id',true);
    //             $cate_id =  array_unique($cate_id);
    //             break;
    //     }
    //     if(!$cate_id) {
    //         return null;//不明,需checkRule
    //     } elseif( !is_array($cate_id) && in_array($cate_id,$cates) ) {
    //         return true;//有权限
    //     } elseif( is_array($cate_id) && $cate_id==array_intersect($cate_id,$cates) ) {
    //         return true;//有权限
    //     } else {
    //         return false;//无权限
    //     }
    //     return null;//不明,需checkRule
    // }

    public function index() {

        // category 单页，直接跳转到编辑页面
        if(intval($this->category['type']) === 4) {
            $this->display('category_single');
            return;
        }

        $content_id = $this->id;

        $filter = array();
        $filter['parent_id'] = 0;
        if(I('screate_user_id')) {
            unset($filter['parent_id']);
        }else if($content_id) {
            $filter['parent_id'] = $content_id;
        }

        $cat_id = $this->category_id;
        if($cat_id) {
            $cat_ids[] = $cat_id;
            $children_ids = D("Category")->getChildrenId($cat_id);
            if($children_ids) {
                $cat_ids = array_merge($cat_ids, $children_ids);
            }
            $filter['category_id'] = array('in',$cat_ids);
        }

        if($_GET['stitle']) {
            $this->stitle = I('stitle');
            $filter['title']  = array('like', '%'.(string)I('stitle').'%');
        }
        if($_GET['smodel_id']) {
            $filter['model_id']  = $this->smodel_id = I('smodel_id');
        }
        if($_GET['sauthor_id']) {
            $filter['author_id']  = $this->sauthor_id = I('sauthor_id');
        }
        if($_GET['screate_user_id']) {
            $filter['create_user_id']  = $this->screate_user_id = I('screate_user_id');
        }

        if($_GET['sstatus']) {
            $filter['status'] = $this->sstatus = I('sstatus');
            $status = $filter['status'];
            if(intval(I('sstatus'))==10) {      // 回收站里面不要结构，都展示出来
                unset($filter['parent_id']);
            }
        } else {
            $status = null;
            $filter['status'] = array('lt', '10');
        }
        if ( isset($_GET['time-start']) ) {
            $filter['update_time'][] = array('egt',strtotime(I('time-start')));
        }
        if ( isset($_GET['time-end']) ) {
            $filter['update_time'][] = array('elt',24*60*60 + strtotime(I('time-end')));
        }
        if ( isset($_GET['nickname']) ) {
            $filter['uid'] = M('Member')->where(array('nickname'=>I('nickname')))->getField('uid');
        }

        //文章根据栏目权限做一下筛选
        if($this->login_user  && $this->login_user['role'] != 'manager') {
            $ids = D('Category')->getIdsForTree($this->login_user['category_ids']);
            $where['category_id'] = array('in',$ids);
            $filter['_complex'] = $where;
        }
        $content = D('Content');

        $order = 'id desc';
        if(I('order')) {
            $order = I('order') . ' desc';
        }
        $list = $this->lists($content,$filter, $order);
        $this->list = $content->getRich($list);
        $this->status = $status;

        $this->meta_title = '内容列表';

        $this->assign('list_grids', $grids);

        // 记录当前列表页的cookie
        Cookie('__forward__',$_SERVER['REQUEST_URI']);
        $this->display('index');
    }

    public function category() {
        return $this->index(intval(I('cid')));
    }

    public function edit() {

        // 扩展字段
        if($this->category && $this->category['extend']) {
            foreach ($this->category['extend']['extends'] as $k => $v) {
                $key = $v['name'];
                $extend_fields[$key]['title'] = $v['title'];
                $extend_fields[$key]['class'] = 'span5';
                if($v['type']=='text') {
                    $extend_fields[$key]['type'] = 'textarea';
                } else if ($v['type']=='editor') {
                    $extend_fields[$key]['type'] = 'textarea';
                    $extend_fields[$key]['class'] = 'editor';
                } else if ($v['type']=='select') {
                    $extend_fields[$key]['type'] = 'select';
                    $extend_fields[$key]['options'] =  array_merge(array('0'=>'-'), explode(' ', $v['options']));
                } else if ($v['type']=='checkbox' || $v['type']=='radio') {
                    $extend_fields[$key]['class'] = 'col-sm-2';
                    $extend_fields[$key]['type'] = $v['type'];
                    $extend_fields[$key]['options'] = explode(' ', $v['options']);
                } else if ($v['type'] == 'picture') {
                    $extend_fields[$key]['type'] = 'image';
                }
            }
            $this->extend_fields = $extend_fields;
        }

        //编辑时如果是子文章，获取该栏目下的所有的父文章
        if($this->category['enable_children']) {
            $child_filter['category_id'] = $this->category_id;
            $child_filter['parent_id'] = 0;
            $child_filter['status'] = array('lt', '10');
            $parent_contents = D("Content")->where($child_filter)->order('weight desc, id')->getField('id,title');
            unset($parent_contents[$this->content['id']]);
            $this->parent_contents = $parent_contents;
        }

        // 默认id, content, model相关的参数，在构造函数栏目已经创建
        $this->meta_title  =  $id?'编辑':'创建' . $this->model['name'];
        $this->display();
    }


    public function save() {
        $data = I('post.');
        if($data['allow_comment'] && $data['allow_comment'][0]) {
            $data['allow_comment'] = 1;
        }

        // 存储地址的时候分隔一下
        if($data['address']) {
            $data['address'] = implode('///', $data['address']);
        }

        // 单独处理一下图片和文件的信息
        if($data['picture_ids']) {
            foreach ($data['picture_ids'] as $img_id) {
                $data['pictures'][$img_id]['link'] = $data['picture_link'.$img_id];
                $data['pictures'][$img_id]['title'] = $data['picture_title'.$img_id];
                $data['pictures'][$img_id]['summary'] = $data['picture_summary'.$img_id];
            }
        }

        if($data['file_ids']) {
            foreach ($data['file_ids'] as $fid) {
                $data['files'][$fid]['title'] = $data['file_title'.$fid];
                $data['files'][$fid]['summary'] = $data['file_summary'.$fid];
            }
        }

        if($data['publish_time']>date('Y-m-d H:i')) {
            $data['status'] = 3;
        }

        $cid = D('Content')->update($data);

        if(!$cid) {
            $this->error(D('Content')->getError());
        } else {
            // action_log('add_content', 'document', $id, UID);
            session("highlight_id",$cid);
            $this->success(intval($_POST['id'])?'更新成功':'新增成功', Cookie('__forward__'));
        }
    }

    public function save_category() {
        $data = I('post.');
        M("Category")->saveOrUpdate($data);
        S("category_info_".$data['id'], NULL);
        $this->success('更新成功', U('index?cid='.$data['id']));
    }

    public function publish() {
        if(!$this->content) return;

        $data['id'] = $this->content['id'];
        $data['update_time'] = $data['publish_time'] = date('Y-m-d H:i:s');
        $data['update_user_id'] = UID;
        $data['status'] = 2;

        D("Content")->save($data);

        session('highlight_id',$this->id);
        json(NULL, 'refresh');
    }

    public function batch_publish(){

        if(I('id')) {
            $ids[] = I('id');
        } elseif(I('ids')) {
            $ids = explode('-', I('ids'));
        }

        $data['update_time'] = $data['publish_time'] = date('Y-m-d H:i:s');
        $data['update_user_id'] = UID;
        $data['status'] = 2;

        foreach ($ids as $v) {
            $data['id'] = $v;
            D("Content")->save($data);
        }

        session('success', '发表成功');
        redirect(I('server.HTTP_REFERER'));

    }

    public function delete() {
        if(!$this->content) return;

        if($this->content['status']==10) {

            // 真的删除
            D("Content")->where('id='.$this->id)->delete();
            //删除子文章
            D('Content')->where('parent_id='.$this->content['parent_id'])->delete();

            $filter = array('object_id'=>$this->id, 'object_type' => 'content');
            M("FileMapping")->where($filter)->delete();
            M("PictureMapping")->where($filter)->delete();

            $tag_filter = array('object_id'=>$this->id);
            M("TagMapping")->where($tag_filter)->delete();
        } else {
            $data['id'] = $this->content['id'];
            $data['update_time'] = $data['publish_time'] = date('Y-m-d H:i:s');
            $data['update_user_id'] = UID;
            $data['status'] = 10;
            D("Content")->save($data);
        }

        session('success', '删除内容成功：' . $this->content['title']);
        json(NULL, 'refresh');
    }

    public function batch_delete() {
        $data = I('post.','htmlspecialchars');
        $ids = $data['checkbox'];
        $content = D('Content');
        foreach ($ids as $v) {
            $cont = $content->detail($v);
            if($cont['status']==10) {
            // 真的删除
                D("Content")->where('id='.$v)->delete();
                $filter = array('object_id'=>$v, 'object_type' => 'content');
                M("FileMapping")->where($filter)->delete();
                M("PictureMapping")->where($filter)->delete();

                $tag_filter = array('object_id'=>$v);
                M("TagMapping")->where($tag_filter)->delete();
            } else {
                $d['id'] = $v;
                $d['update_time'] = $data['publish_time'] = date('Y-m-d H:i:s');
                $d['update_user_id'] = UID;
                $d['status'] = 10;
                D("Content")->save($d);
            }
        }
        session('success', '删除内容成功');
        redirect(I('server.HTTP_REFERER'));
    }

    public function recycle() {
        // if(!$this->content) return;
        if(I('id')) {
            $ids[] = I('id');
        } elseif(I('ids')) {
            $ids = explode('-', I('ids'));
        }

        foreach($ids as $k=>$v) {
            $data['id'] = $v;
            $data['update_time'] = $data['publish_time'] = date('Y-m-d H:i:s');
            $data['update_user_id'] = UID;
            $data['status'] = 1;
            D("Content")->save($data);
        }

        session('success', '还原内容成功：' . $this->content['title']);
        json(NULL, 'refresh');
    }


    public function render_copy($id) {

        if(!$id) return;
        $this->title = "复制文章到（可多选）";
        $this->content_id = $id;
        $to_category_ids = M("ContentCopy")->where('content_id='.$id)->getField('to_category_id', true);

        $this->to_categories = M("Category")->where(array('id'=>array('in',$to_category_ids)))->getField('id,title',true);

        $html = $this->fetch('copy_dialog');
        $dialog = array(
            array("data" => $html, "type" => "dialog"),
            array("data" => "dialog_validator()", "type" => "eval")
        );

        Cookie('__forward__',$_SERVER['REQUEST_URI']);
        json($dialog, "mix");
    }

    public function submit_copy() {
        $content_ids = explode('-',I("content_id"));
        $to_category_ids = explode(',', I('to_category_ids'));

        foreach ($to_category_ids as $category_id) {
            foreach($content_ids as $content_id) {
                $content = D('Content')->detail($content_id);

                $content['category_id'] = $category_id;
                $content['status'] = 1;
                unset($content['id']);
                unset($content['alias']);
                unset($content['pictures']);
                unset($content['files']);

                $to_content_id = D("Content")->update($content);

                $copy_data['content_id'] = $content_id;
                $copy_data['create_time'] = date('Y-m-d H:i:s');
                $copy_data['to_category_id'] = $category_id;
                $copy_data['to_content_id'] = $to_content_id;
                M('ContentCopy')->add($copy_data);

                // 关联的附件和图集
                $f = array();
                $f['object_id'] = $content_id;
                $tags = M("TagMapping")->where($f)->select();
                foreach ($tags as $tag) {
                    unset($tag['id']);
                    $tag['object_id'] = $to_content_id;
                    M("TagMapping")->add($tag);
                }

                $f['object_type'] = 'content';
                $pictures = M("PictureMapping")->where($f)->select();
                foreach ($pictures as $pic) {
                    unset($pic['id']);
                    $pic['object_id'] = $to_content_id;
                    M("PictureMapping")->add($pic);
                }

                $files = M("FileMapping")->where($f)->select();
                foreach ($files as $ff) {
                    unset($ff['id']);
                    $ff['object_id'] = $to_content_id;
                    M("FileMapping")->add($ff);
                }
            }
        }

        session('success', '复制内容成功，请到相应栏目查看');
        redirect('index');
    }

    public function render_move_content() {

        // if(!$id) return;
        $this->ids = I('ids');
        $this->title = "移动文章到";
        $this->content_id = $id;

        $html = $this->fetch('move_dialog');
        $dialog = array(
            array("data" => $html, "type" => "dialog"),
            array("data" => "dialog_validator()", "type" => "eval")
        );

        Cookie('__forward__',$_SERVER['HTTP_REFERER']);
        json($dialog, "mix");
    }

    public function submit_move() {
        $content_id = I('content_id');
        $to_category = I('to_category_ids');
        $ids = explode('-', $content_id);
        $content = D('Content');
        foreach($ids as $v) {
            $content->where(array('id'=>$v))->data(array('category_id'=>$to_category))->save();
        }

        session('success','移动文章成功');
        $this->redirect(Cookie('__forward__'));
    }


    public function batchOperate() {

        //获取左边菜单
        $this->getMenu();

        $pid = I('pid', 0);
        $cate_id = I('cate_id');

        empty($cate_id) && $this->error('参数不能为空！');

        //检查该分类是否允许发布
        $allow_publish = D('Content')->checkCategory($cate_id);
        !$allow_publish && $this->error('该分类不允许发布内容！');

        //批量导入目录
        if(IS_POST) {
            $model_id = I('model_id');
            $type = 1;	//TODO:目前只支持目录，要动态获取
            $content = I('content');
            $_POST['content'] = '';	//重置内容
            preg_match_all('/[^\r]+/', $content, $matchs);	//获取每一个目录的数据
            $list = $matchs[0];
            foreach ($list as $value) {
                if(!empty($value) && (strpos($value, '|') !== false)) {
                    //过滤换行回车并分割
                    $data = explode('|', str_replace(array("\r", "\r\n", "\n"), '', $value));
                    //构造新增的数据
                    $data = array('name'=>$data[0], 'title'=>$data[1], 'category_id'=>$cate_id, 'model_id'=>$model_id);
                    $data['description'] = '';
                    $data['pid'] = $pid;
                    $data['type'] = $type;
                    //构造post数据用于自动验证
                    $_POST = $data;

                    $res = D('Content')->update($data);
                }
            }
            if($res) {
                $this->success('批量导入成功！', U('index?pid='.$pid.'&cate_id='.$cate_id));
            } else {
                if(isset($res)) {
                    $this->error(D('Content')->getError());
                } else {
                    $this->error('批量导入失败，请检查内容格式！');
                }
            }
        }

        $this->assign('pid',        $pid);
        $this->assign('cate_id',	$cate_id);
        $this->assign('type_list',  get_type_bycate($cate_id));

        $this->meta_title       =   '批量导入';
        $this->display('batchoperate');
    }


    public function export_content($category_id, $ids) {
        $ids = explode('-',$ids);

        $f['id'] = array('in', $ids);
        $contents = D("Content")->where($f)->select();
        $contents = D("Content")->getRich($contents,true);

        foreach($contents as $k=>$c) {
            $maybe_model_ids[] = $c['model_id'];
            $c['address'] = implode(' ', $c['address']);
            $c['tags'] = implode(' ', get_column($c['tags'], 'name'));
            foreach($c['extend'] as $ek => $ev) {
                $c[$ek] = $ev;
            }
            $res[] = $c;
            if($c['children']) {
                foreach ($c['children'] as $sk => $sc) {
                    $maybe_model_ids[] = $sc['model_id'];
                    $sc['address'] = implode(' ', $sc['address']);
                    $sc['title'] = '【'.$c['title'].'】' . $sc['title'];
                    $sc['tags'] = implode(' ', get_column($sc['tags'], 'name'));
                    foreach($sc['extend'] as $ek => $ev) {
                        $sc[$ek] = $ev;
                    }
                    $res[] = $sc;
                }
            }
        }

        $maybe_model_ids = array_unique($maybe_model_ids);
        foreach ($maybe_model_ids as $m) {
            $models[$m] = D("Field")->getContentFields($m, $category_id);
        }

        $keys['id'] = '编号';
        $keys['category_name'] = '栏目';
        $unsets = array('allow_comment', 'status', 'thumb', 'alias', 'weight');
        foreach ($models as $ms) {
            foreach($ms as $k=>$m) {
                if(in_array($k,$unsets)) continue;
                $keys[$k] = $m['title'];
            }
        }
        $keys['create_time'] = '创建时间';
        $keys['status_name'] = '状态';

        foreach($this->category['extend']['extends'] as $ee) {
            $keys[$ee['name']] = $ee['title'];
        }

        simple_down_xls($res, $keys);
    }

    public function import_content() {
        $this->display('import');
    }

    public function submit_import_excel() {
        $map = $_POST;
        unset($map['method']);

        $method = I('post.method', 0);
        $file = $_FILES['excel_file'];

        if($method == 'excel' && strpos($file['name'], '.xls') === FALSE && strpos($file['name'], '.xlsx') === FALSE ) {
            session("error", "文件格式不对，请用*.xls *.xlsx文件导入");
            redirect("/manage/content/import_content/cid/" . $this->category_id);
        }
        $file_path = upload_file("excel_file", "tmp");
        $file_path =  C('WWW_ROOT') . "/Uploads/" . $file_path;

        //如果是Excel格式的话，则需要检查是不是行数小于2000个
        $titles = D('Import')->getTitles($file_path);

        if(in_array('类型详细名称', $titles)) {
            $extends = $this->category['extend']['extends'];
            $fields = array();

            $extend_field_keys = '';

            $fields['content_title'] = '类型详细名称';
            $fields['title'] = '标题';

            foreach ($extends as $ex) {
                $fields['_extend_' . $ex['name']] = $ex['title'];
                $extend_field_keys .= $ex['name'] . ',';
            }
            $map['extend_field_keys'] = $extend_field_keys;

        }else{
            $fields = $this->get_import_column();
        }
        $import_check_results = D("Import")->importCheck($file_path, $fields);
        if(!$import_check_results['notice']) {
            $map['status'] = 1;
            $result =  D('Import')->importContent($file_path, $fields, $map);
            session(C('LOAD_EXT_CONFIG') . '_import_result_' . UID, $result);
            redirect('/Manage/content/display_import_result/cid/' .$this->category_id );
        }else{
            $this->import_check_results = $import_check_results;
            $this->display('import_check_result');
        }

    }

    public function setStatus($model='Content') {
        return parent::setStatus('Content');
    }

    public function display_import_result(){
        $this->result = session(C('LOAD_EXT_CONFIG') . '_import_result_' . UID);
        $this->display('import_result');
    }

    // TODO 递归
    private function _generate_menus($category_tree) {
        $result[] = array('title'=>'内容列表', 'type'=>'header', 'icon'=>'fa fa-list');
        foreach ($category_tree as $key => $cat) {
            $key = $key+1;
            $result[$key]['link'] = U('index?cid='.$cat['id']);
            $result[$key]['title'] = $cat['title'];
            $result[$key]['is_active'] = $this->category_id==$cat['id'] ? 1 : 0;

            // 二级
            if($cat['_']) {
                foreach ($cat['_'] as $k2 => $v2) {
                    $result[$key]['submenu'][$k2]['link'] = U('index?cid='.$v2['id']);
                    $result[$key]['submenu'][$k2]['title'] = $v2['title'];
                    if($this->category_id==$v2['id']) {
                        $result[$key]['submenu'][$k2]['is_active'] = 1;
                        $result[$key]['is_active'] = 1;
                    }

                    // 三级
                    if($v2['_']) {
                        foreach ($v2['_'] as $k3 => $v3) {
                            $one['link'] = U('index?cid='.$v3['id']);
                            $one['title'] = $v3['title'];
                            $one['is_active'] = 0;
                            if($this->category_id==$v3['id']) {
                                $result[$key]['submenu'][$k2]['is_active'] = 1;
                                $result[$key]['is_active'] = 1;
                                $one['is_active'] = 1;
                            }
                            $result[$key]['submenu'][$k2]['submenu'][$k3] = $one;
                        }
                    }
                }
            }
        }

        return $result;
    }

    function ajax_find_repeat() {
        $title = I('post.title');
        $article = D("Content")->where(array('title'=>$title))->find();
        if($article) {
            echo json_encode($article);
        } else {
            echo 0;
        }
    }

    function ajax_dialog_map_position() {
        $this->title = "请选择位置";
        $html = $this->fetch("map_position_dialog");
        json($html, "dialog");
    }

    function get_import_column(){
        $import_fields = $this->model_fields;
        $disabled_fields = $this->category['disabled_fields'] . ',status,weight,thumb,publish_time';
        $disabled_fields = explode(',', $disabled_fields);
        foreach ($disabled_fields as $dis) {
            unset($import_fields[$dis]);
        }
        foreach ($import_fields as $key => $field) {
            $fields[$key] = $field['title'];
        }
        $fields['provice'] = "省";
        $fields['city'] = "市";
        $fields['area'] =  "区";
        $fields['detail_address'] = "详细地址";
        $fields['latlng'] = "经纬度";
        return $fields;
    }


    // Good, but too slow from local and aliyun(domestic) hosts
    function tinypng() {
        $key = "9DrH9Xv99eMMThirI7fWX3fLoV5QFawe";
        $input = "large-input.jpg";
        $output = "tiny-output.jpg";

        $request = curl_init();
        curl_setopt_array($request, array(
          CURLOPT_URL => "https://api.tinify.com/shrink",
          CURLOPT_USERPWD => "api:" . $key,
          CURLOPT_POSTFIELDS => file_get_contents($input),
          CURLOPT_BINARYTRANSFER => true,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_HEADER => true,
          /* Uncomment below if you have trouble validating our SSL certificate.
             Download cacert.pem from: http://curl.haxx.se/ca/cacert.pem */
          // CURLOPT_CAINFO => __DIR__ . "/cacert.pem",
          CURLOPT_SSL_VERIFYPEER => false
        ));

        $response = curl_exec($request);
        if (curl_getinfo($request, CURLINFO_HTTP_CODE) === 201) {
          /* Compression was successful, retrieve output from Location header. */
          $headers = substr($response, 0, curl_getinfo($request, CURLINFO_HEADER_SIZE));
          foreach (explode("\r\n", $headers) as $header) {
            if (strtolower(substr($header, 0, 10)) === "location: ") {
              $request = curl_init();
              curl_setopt_array($request, array(
                CURLOPT_URL => substr($header, 10),
                CURLOPT_RETURNTRANSFER => true,
                /* Uncomment below if you have trouble validating our SSL certificate. */
                // CURLOPT_CAINFO => __DIR__ . "/cacert.pem",
                CURLOPT_SSL_VERIFYPEER => false
              ));
              file_put_contents($output, curl_exec($request));
            }
          }
        } else {
            print(curl_error($request));
            /* Something went wrong! */
            print("Compression failed");
        }        
    }
}
