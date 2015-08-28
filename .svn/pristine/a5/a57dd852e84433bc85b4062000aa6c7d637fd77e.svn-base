<?php

namespace Manage\Model;
use Think\Model;


class ContentModel extends Model{

    /* 自动验证规则 */
    protected $_validate = array(
    );

    /* 自动完成规则 */
    protected $_auto = array(
        array('create_time', 'date', Model::MODEL_INSERT, 'function',array('Y-m-d H:i:s')),
        array('update_time', 'date', Model::MODEL_BOTH, 'function',array('Y-m-d H:i:s')),
    );

    function _after_insert($data,$options) {
        $this->_clear_cache($data);
    }

    function _after_delete($data,$options) {
        $this->_clear_cache($data);
    }

    function _after_update($data,$options) {
        $this->_clear_cache($data);
    }


    private function _clear_cache($data) {
        // 内容缓存
        S("content_rich_".$data['id'], NULL);
        S("content_rich_".$data['parent_id'], NULL);

        // 静态化文件，当前文章，父文章和栏目，父栏目
        unlink(HTML_PATH.md5('content'.$data['id']).'.html');
        unlink(HTML_PATH.md5('content'.$data['parent_id']).'.html');
    }

    /**
     * 获取文档列表
     * @param  integer  $category 分类ID
     * @param  string   $order    排序规则
     * @param  integer  $status   状态
     * @param  boolean  $count    是否返回总数
     * @param  string   $field    字段 true-所有字段
     * @param  string   $limit    分页参数
     * @param  array    $map      查询条件参数
     * @return array              文档列表
     */
    public function lists($category, $order = '`id` DESC', $status = 1, $field = true, $limit = '20', $map = array()) {
        $map = array_merge($this->listMap($category, $status), $map);
        return $this->field($field)->where($map)->order($order)->limit($limit)->select();
    }

    /**
     * 计算列表总数
     * @param  number  $category 分类ID
     * @param  integer $status   状态
     * @return integer           总数
     */
    public function listCount($category, $status = 1, $map = array()){
        $map = array_merge($this->listMap($category, $status), $map);
        return $this->where($map)->count('id');
    }

    /**
     * 获取详情页数据
     * @param  integer $id 文档ID
     * @return array       详细数据
     */
    public function detail($id){

        $info = $this->field(true)->find($id);
        if(!is_array($info)) {
            $this->error = '文档被禁用或已删除！';
            return false;
        }
        return $this->getRich($info, true);
        /* 获取模型数据 */
        // $logic  = $this->logic($info['model_id']);        
        // $detail = $logic->detail($id); //获取指定ID的数据
        // if(!$detail){
        //     $this->error = $logic->getError();
        //     return false;
        // }
        // $info = array_merge($info, $detail);

        return $info;
    }

    public function getRich($list, $more_rich=false) {
        if(!$list) return NULL;

        // 单个
        $single = false;
        if($list['title']) {
            $single = true;
            $lists[] = $list;
        } else {
            $lists = $list;
        }

        foreach ($lists as $k => $v) {

            $status = D('Status')->getContentStatus($v['status']);
            $v['status_name'] = $status['name'];
            $v['status_action'] = $status['action'];

            $v['model'] = D('Model')->getModels($v['model_id']);

            $v['category'] = M("Category")->find($v['category_id']);
            $v['category_name'] = $v['category']['title'];

            $v['update_user'] = M("User")->getById($v['update_user_id']);
            if($v['create_user_id']==$v['update_user_id']) {
                $v['create_user'] = $v['update_user'];
            } else {
                $v['create_user'] = M("User")->getById($v['create_user_id']);
            }
            
            //取出文章使用的模板
            $category_models = unserialize($v['category']['models']);
            $v['template']   = $category_models[$v['model_id']];
            $v['link'] = '/content/' . $v['id'];

            // if the model is link, use the external_url as link
            if($v['model_id']==3) {
                $v['link'] = $v['external_url'];
            }

            //children
            if($v['category']['enable_children']) {
                $cf['parent_id'] = $v['id'];
                $cf['status'] = array('lt', '10');
                $v['children'] = $this->getRich(M("Content")->where($cf)->order('publish_time desc')->select(),$more_rich);

                // 更新当前显示列表文章子文章数量，主要为前台展示使用
                $cf['status'] = 2;
                $children_count = $this->where($cf)->count();

                if($children_count && $v['child_content_count']!==$children_count) {
                    $this->where('id =%d', $v['id'])->setField('child_content_count', intval($children_count));
                }
            }

            if($v['author_id']) {
                $v['author'] = M('Author')->getById($v['author_id']);
                $v['author_name'] = $v['author']['name'];
            }

            $v['address'] = explode('///', $v['address']);

            // 如果只有address有数据，没有省市区，不能因为///切割坏掉数据，保留
            if(count($v['address'])==1) {
                $v['address'][3] = $v['address'][0];
                $v['address'][0] = '';
            }

            if($more_rich) {

                if($v['source_id']) {
                    $v['source_name'] = M('Source')->where('id='.$v['source_id'])->getField('name');
                }

                $tags = D("Tag")->getByObject($v['id']);
                $v['tags'] = $tags[$v['id']];

                $v['pictures'] = D('PictureMapping')->getMapping($v['id'], 'content');

                $v['files'] = D('FileMapping')->getMapping($v['id'], 'content');

                $v['extend'] = M("ContentExtend")->where('content_id='.$v['id'])->getField('name,value');
            }

            $lists[$k] = $v;
        }
        
        if($single) return $lists[0];

        return $lists;
    }

    /**
     * 返回前一篇文档信息
     * @param  array $info 当前文档信息
     * @return array
     */
    public function prev($info){
        $map = array(
            'id'          => array('lt', $info['id']),
            'category_id' => $info['category_id'],
            'status'      => 1,
            );

        /* 返回前一条数据 */
        return $this->field(true)->where($map)->order('id DESC')->find();
    }

    /**
     * 获取下一篇文档基本信息
     * @param  array    $info 当前文档信息
     * @return array
     */
    public function next($info){
        $map = array(
            'id'          => array('gt', $info['id']),
            'category_id' => $info['category_id'],
            'status'      => 1,
        );

        /* 返回下一条数据 */
        return $this->field(true)->where($map)->order('id')->find();
    }


    public function update($data = null) {

        if(!$data['category_id'] || !$data['title']) {
            $this->error = '栏目和标题不能为空';
            return false;
        }
        $check_title = $this->where(array('title'=>$data['title']))->find();
        if(!$data['id'] && $check_title) {
            // $this->error = '此标题已存在，不能重复发布';
        }
        $cid = $data['id'];

        $source = D("Source")->getSourceByName(trim($data['source_name']));
        $data['source_id'] = $source['id'];

        $author = D("Author")->getAuthorByName(trim($data['author_name']));
        $data['author_id'] = $author['id'];

        if($data['status']==2 && $data['publish_time']<'1') {
            $data['publish_time'] = date('Y-m-d H:i:s');
            $data['publish_user_id'] = UID;
        }

        if(!$data['id']) {
            $data['create_user_id'] = UID;
        }
        $data['update_user_id'] = UID;

        if($data['alias']) {
            $maybe_content = $this->getByAlias($data['alias']);
            if($maybe_content) {
                // 新建的或者编辑但是和别的重复了
                if(!$cid || ($cid !== $maybe_content['id'])) {
                    $this->error = '该别名已经有定义，不可以重复';
                    return false;
                }
            }
        }

        $obj = $this->create($data);
        if(!$obj){
            $this->error = '创建Content对象有误';
            return false;
        }

        $last_id = $this->saveOrUpdate();
        if(!$last_id) {
            $this->error = $data['id']?'更新内容出错！':'新增内容出错！';
        }

        D('Tag')->updateTags($last_id, explode(',', $data['tags']), $data['category_id']);

        D("PictureMapping")->updateMapping($last_id, 'content', $data['pictures']);

        D("FileMapping")->updateMapping($last_id, 'content', $data['files']);

        // 扩展字段
        if($data['extend_field_keys']) {
            $extend_field_keys = explode(',', $data['extend_field_keys']);
            foreach ($extend_field_keys as $k) {
                if($data['_extend_'.$k]) {
                    if(is_array($data['_extend_'.$k])){ //新增 扩展数组判定
                        $extend_values[$k] = serialize($data['_extend_'.$k]);
                    }else{
                        $extend_values[$k] = $data['_extend_'.$k];
                    }
                }
            }

            D("ContentExtend")->update($last_id, $extend_values);
        }

        return $last_id;
    }


    /**
     * 获取推荐位数据列表
     * @param  number  $pos      推荐位 1-列表推荐，2-频道页推荐，4-首页推荐
     * @param  number  $category 分类ID
     * @param  number  $limit    列表行数
     * @param  boolean $filed    查询字段
     * @return array             数据列表
     */
    public function position($pos, $category = null, $limit = null, $field = true){
        $map = $this->listMap($category, 1, $pos);

        /* 设置列表数量 */
        is_numeric($limit) && $this->limit($limit);

        /* 读取数据 */
        return $this->field($field)->where($map)->select();
    }

    protected function getCreateTime(){
        $create_time    =   I('post.create_time');
        return $create_time?strtotime($create_time):NOW_TIME;
    }

    /**
     * 验证分类是否允许发布内容
     * @param  integer $id 分类ID
     * @return boolean     true-允许发布内容，false-不允许发布内容
     */
    public function checkCategory($id){
        $publish = get_category($id, 'allow_publish');
        return $publish ? true : false;
    }

    /**
     * 检测分类是否绑定了指定模型
     * @param  array $info 模型ID和分类ID数组
     * @return boolean     true-绑定了模型，false-未绑定模型
     */
    protected function checkModel($info){
        $model = get_category($info['category_id'], 'model');
        return in_array($info['model_id'], $model);
    }

    /**
     * 设置where查询条件
     * @param  number  $category 分类ID
     * @param  number  $pos      推荐位
     * @param  integer $status   状态
     * @return array             查询条件
     */
    private function listMap($category, $status = 1, $pos = null){
        /* 设置状态 */
        $map = array('status' => $status);

        /* 设置分类 */
        if(!is_null($category)){
            if(is_numeric($category)){
                $map['category_id'] = $category;
            } else {
                $map['category_id'] = array('in', str2arr($category));
            }
        }

        /* 设置推荐位 */
        if(is_numeric($pos)){
            $map[] = "position & {$pos} = {$pos}";
        }

        return $map;
    }


    /**
     * 删除状态为-1的数据（包含扩展模型）
     * @return true 删除成功， false 删除失败
     * @author huajie <banhuajie@163.com>
     */
    public function remove(){
        //查询假删除的基础数据
        if ( is_administrator() ) {
            $map = array('status'=>-1);
        }else{
            $cate_ids = AuthGroupModel::getAuthCategories(UID);
            $map = array('status'=>-1,'category_id'=>array( 'IN',trim(implode(',',$cate_ids),',') ));
        }
        $base_list = $this->where($map)->field('id,model_id')->select();
        //删除扩展模型数据
        $base_ids = array_column($base_list,'id');
        //孤儿数据
        $orphan   = get_stemma( $base_ids,$this, 'id,model_id');

        $all_list  = array_merge( $base_list,$orphan );
        foreach ($all_list as $key=>$value){
            $logic = $this->logic($value['model_id']);
            $logic->delete($value['id']);
        }

        //删除基础数据
        $ids = array_merge( $base_ids, (array)array_column($orphan,'id') );
        if(!empty($ids)){
            $res = $this->where( array( 'id'=>array( 'IN',trim(implode(',',$ids),',') ) ) )->delete();
        }

        return $res;
    }

    public function getCountByCategoryId($category_id) {
        $id = intval($category_id);
        if(!$id) return 0;

        $child_ids = D("Category")->getChildrenId($id);
        $filter['category_id'] = array('in', array_merge(array($id), $child_ids));
  
        return M('Content')->where($filter)->count();
    }

    /*
     *  志愿者VS 监测信息数量  group by create_id
     *  监测点 VS 志愿者数量（监测过该点的志愿）
     *  
     */
    public function getContentStatistics($filter, $map= array(), $field=true, $order='create_time desc', $status=2){

        if(!$filter['parent_id']) {
            $filter['parent_id'] = 0;
        }

        $model = $this;
        $filter['status'] = $status;
        $model->field($field)->where($filter)->order($order);

        if($map['group']) {
            $model->group($map['group']);
        }
        return $model->select();
    }
}
