<?php
namespace Home\Model;
use Think\Model;
use Think\Page;

/*
 * status   1 草稿
 *          2 已发
 *          3 定时发送
 *          10 回收站
 */
class ContentModel extends Model{

    /* 用户模型自动完成   array('field','填充内容','填充条件','附加规则',[额外参数])*/
    protected $_auto = array(
        array('update_time', 'date', Model::MODEL_BOTH, 'function', array('Y-m-d H:i:s')),
        array('create_time', 'date', Model::MODEL_INSERT, 'function', array('Y-m-d H:i:s')),
    );


    public function getPagesByCatgoryId($ids) {
        $filter['category_id'] = $ids;
        $res = $this->where($filter)->select();
        return $res;
    }

    public function getPages($filter, $page=0, $size=0, $order, $field=true,$offset=false, $rich=true) {
        // 默认是publish，如果设置了all，就全部
        if(!$filter) $filter = array();

        if(!$filter['status']){
            $filter['status'] = 2;
        }

        if(!$filter['parent_id']) {
            $filter['parent_id'] = 0;
        }

        $order = $order?$order:C('DEFAULT_CONTENT_SORT');
        if(!$order) {
            $order = 'weight desc, publish_time desc';
        }
        $offset = intval($offset);
        if($offset){
            $limit = "$offset,$size";
        }

        if($filter['distinct'] ){
            $this->field('distinct ' . $filter['distinct']);
            unset($filter['distinct']);
        }

        $pages = $this->where($filter)->order($order)->field($field)->limit($limit);
        if(!empty($page) && !empty($size) && !$offset){
            $pages->page($page, $size);
        }
        $ps = $pages->select();
        $map_icon = D("Banner")->getBannerByName('map_icon');
        $map_icon = ass_column($map_icon, 'title');
        if($rich) {
            foreach ($ps as $idx => $one) {
                $ps[$idx] = $this->getRichInfo($one);

                 //TODO带完善
                if($one['child_content_count']) {
                    $ps[$idx]['map_icon'] = $map_icon['map_child_icon']['path'];
                }else{
                    $ps[$idx]['map_icon'] = $map_icon['map_no_child_icon']['path'];
                }
            }
        }

        return $ps;
    }

    /**
     * 计算列表总数
     * @param  number  $category 分类ID
     * @param  integer $status   状态
     * @return integer           总数
     */
    public function listCount($map){
        return $this->where($map)->count('id');
    }


    public function getPagesByTypeId($object_id, $page=0, $size=0, $extra_condtion=array(), $just_count=false,$order,$field=true,$offset) {

        if(is_numeric($object_id)) {
            if($extra_condtion['is_getting_childrens']) {
                $object_ids = D("Category")->getChildrenId($object_id);
                unset($extra_condtion['is_getting_childrens']);
            } else {
                $object_ids = array($object_id);
            }
            unset($extra_condtion['is_getting_childrens']);
        }
        if(is_array($object_id)) {
            $object_ids = $object_id;
        }
        if(!$object_ids) return NULL;

        if($extra_condtion['tag_id']) {
            $tag_ids = $extra_condtion['tag_id'];
            settype($tag_ids, 'array');
            $condition['id'] = array('in', D('TagMapping')->where(array("tag_id" => array("in", $tag_ids)))->getField('object_id', true));
            unset($extra_condtion['tag_id']);
        }

        if($extra_condtion['extend']) {
            $f['name'] = $extra_condtion['extend']['name'];
            $f['value'] = $extra_condtion['extend']['value'];
            $condition['id'] = array('in', D('ContentExtend')->where($f)->getField('content_id', true));
            unset($extra_condtion['extend']);
        }

        if($object_ids) {
            $condition['category_id'] = array('in', $object_ids);
        }

        if($extra_condtion) {
            $condition = array_merge($condition, $extra_condtion);
        }
        $condition['status'] = 2;
        $condition['parent_id'] = 0;

        if($just_count) {
            return $this->where($condition)->count();
        }
        $ps = $this->getPages($condition, $page, $size,$order,$field,$offset, is_string($field)?false:true);
        return $ps;
    }


    public function getPageById($page_id, $shallow=false) {
        $page = $this->getById(intval($page_id));
        if($shallow) return $page;

        return $this->getRichInfo($page);
    }

    // For static page
    public function getPageByName($page_name) {
        $page = D('Content')->getByAlias($page_name);
        return self::getRichInfo($page);
    }

    public function getChildren($id, $page=0, $size=0) {
        if(!$id) return NULL;
        $filter['parent_id'] = $id;
        return $this->getPages($filter, $page, $size);
    }

    public function getRichInfo($p) {
        if(!$p) return NULL;
        $cache_key = 'content_rich_' . $p['id'];
        if($result = S($cache_key)) {
            return $result;
        }

        $p['category_name'] = D("Category")->getFieldById($p['category_id'], 'title');

        $tags = D("Tag")->getByObject($p['id']);
        $p['tags'] = $tags[$p['id']];

        if($p['author_id']) {
            $p['author'] = D('Author')->getById($p['author_id']);
            $p['author_name'] = $p['author']['name'];
        }

        if($p['source_id']) {
            $p['source_name'] = D('Source')->where(array('id'=>$p['source_id']))->getField('name');
        }
        $p['update_user'] = D("User")->field('password', true)->getById($p['update_user_id']);
        $p['create_user'] = D("User")->field('password', true)->getById($p['create_user_id']);
        $p['link'] = format_url($p['external_url']);
        if(!$p['link']) {
            $p['link'] = '/content/' . $p['id'];
        }

        // files
        if($p['model_id'] == 5) {
            $p['files'] = D('FileMapping')->getMapping($p['id'], 'content');
        }

        if($p['model_id'] == 2) {
            $p['pictures'] = D('PictureMapping')->getMapping($p['id'], 'content');
        }

        $p['address'] = explode('///', $p['address']);

        $p['gallery'] = D('PictureMapping')->getMapping($p['id'], 'content');

        // Extend
        $p['extend'] = M("ContentExtend")->where('content_id='.$p['id'])->getField('name,value');

        // parent
        if($p['parent_id'] && $p['parent_id'] != $p['id']) {
            $p['parent'] = $this->getPageById($p['parent_id']);
        }
        //取child page
        $children_pages = $this->where(array('parent_id'=>$p['id'], 'status' => 2))->order('weight desc, publish_time desc')->select();

        if($children_pages) {
            //extend
            foreach ($children_pages as $key => $child_page) {
                $children_pages[$key]['extend'] = D("ContentExtend")->where('content_id='.$child_page['id'])->getField('name,value');
                $children_pages[$key]['update_user'] = D("User")->getById($child_page['update_user_id']);
                $children_pages[$key]['create_user'] = D("User")->field('password', true)->getById($child_page['create_user_id']);
                $children_pages[$key]['gallery'] = D('PictureMapping')->getMapping($child_page['id'], 'content');
                $children_pages[$key]['link'] = format_url($children_pages[$key]['external_url']);
                if(!$child_page['link']) {
                    $children_pages[$key]['link'] = '/content/' . $children_pages[$key]['id'];
                }
                if($child_page['author_id']) {
                    $children_pages[$key]['author_name'] = D('Author')->where('id=%d',$children_pages[$key]['author_id'])->getField('name');
                }
            }
            $p['children_pages'] = $children_pages;
        }

        //更新当前文章的子文章数
        if($p['child_content_count'] != count($children_pages)) {
            M('Content')->where('id=%d', intval($p['id']))->setField('child_content_count', count($children_pages));
        }

        S($cache_key, $p);
        return $p;
    }

    public function publishDuecontents() {
        $sql = "update jxdrcms_content set status=2 where status=3 and publish_time < '" . date('Y-m-d H:i:s') . "'";
        return $this->query($sql, true);
    }

    public function getLists($condition, $field = '', $param = null, $page=0, $size=0, $status=1, $limit='20', $order='weight desc, publish_time desc') {

        $filter['parent_id'] = array('gt', 0);
        $filter['cont.status'] = 2;

        $model = $this->alias('cont');

        if($param['has_user_info']) {
            $filter['u.status'] = $status;
            $new_field = 'u.username, u.email, u.avatar';
            $model->join('inner join __USER__ u on u.id=cont.create_user_id');
        }

        if($param['group']) {
            $new_field = 'count(cont.id) as count, create_user_id'. ',' . $new_field;
            $model->group($param['group']);
            $order = 'count desc, update_time desc';
        }else{
            $new_field = $field? ($field . ',' . $new_field ):'cont.*,' .$new_field;
        }

        $model->field($new_field);

        if($filter){
            $model->where($filter);
        }

        if(!empty($page) && !empty($size)){
            $model->page($page, $size);
        }

        $contents = $model->order($order)->limit($limit)->select();

        $condition['status'] = 2;
        $condition['parent_id'] = array('gt', 0);
        foreach ($contents as $key => $content) {
            $condition['create_user_id'] = $content['create_user_id'];
            $contents[$key]['children_pages'] = M('Content')->where($condition)->select();
        }
        return $contents;
    }

    public function updateContent($data = null) {

        if(!$data['category_id']) {
            $this->error = '栏目不能为空';
            return false;
        }

        // 0需要审核 1 不需要审核
        $category  = M('Category')->where('id=%d', $data['category_id'])->find();
        if(!$category['enable_check']) {
            $data['status'] = 2;
            $data['publish_time'] = date('Y-m-d H:i:s');
        }

        //填写用户信息
        if($data['_user_fields'] && $data['_user_email']) {
            $user_field_keys = explode(',', $data['_user_fields']);
            foreach ($user_field_keys as $k) {
                if($data['_user_'.$k]) {
                    $user_values[$k] = $data['_user_'.$k];
                }
            }

            $user = D('User')->where('email="' . $user_values['email'] .'"')->find();
            if($user){
                $user_values['id'] = $user['id'];
            }
            if(D('User')->create($user_values)) {
                $user_id = D('User')->saveOrUpdate();
            }
        }

        if($user_id) {
            $data['create_user_id'] = $user_id;
        }

        //清空缓存
        S('content_rich_' . $data['id'], null);
        S('category_info_' . $data['category_id'], null);

       /* $check_title = $this->where(array('title'=>$data['title']))->find();
        if(!$data['id'] && $check_title) {
            $this->error= '此标题已存在，不能重复发布';
            return false;
        }*/

        //如果有创建时间 就从auto中移除自动添加的create_time
        if($data['create_time']) {
            unset($this->_auto[1]);
        }

        $obj = $this->create($data);
        if(!$obj){
            $this->error= '创建Content对象有误';
            return false;
        }

        $last_id = $this->saveOrUpdate();
        if(!$last_id) {
            $this->error= $data['id']?'更新内容出错！':'新增内容出错！';
        }

        //更新图集
        D("PictureMapping")->updateMapping($last_id, 'content', $data['pictures']);
        // 扩展字段
        if($data['extend_field_keys']) {
            $extend_field_keys = explode(',', $data['extend_field_keys']);
            foreach ($extend_field_keys as $k) {
                if($data['_extend_'.$k]) {
                    $extend_values[$k] = $data['_extend_'.$k];
                }
            }
            D("ContentExtend")->update($last_id, $extend_values);
        }
        return $last_id;
    }

    public function getRelatedContents($content, $size = 6, $exclude_category_ids = array()){
        if(!$content) return ;

        //获取tag中的文章
        $tag_ids = array_keys($content['tags']);
        if($tag_ids){
            $tag_cond['tag_id'] = array('in', $tag_ids);
            $tag_mappings  = D('TagMapping')->where($tag_cond)->page(1, $rsize)->select();
            $content_ids = get_column($tag_mappings, 'object_id');
            $condition['id'] = array('in', $content_ids);
            unset($content_ids[array_search($content['id'], $content_ids)]);

            if(count($content_ids) > $size){
                unset($content_ids[count($content_ids)-1]);
            }

            $tcontents = $this->getPages($condition, 1, $size);
            if($tcontents) {
                $tcontents = ass_column($tcontents);
            }

            if(count($tcontents) == $size) {
                return $tcontents;
            }
        }
        //获取父相关文章
        if($content['parent_id']){
            $parent_cond['parent_id'] = $content['parent_id'];
            $tcontents = $this->_mergeMoreRelatedContent($parent_cond, $tcontents, $content['id'], $size);
            if(count($tcontents) == $size) {
                return $tcontents;
            }
        }

        //获取当前栏目下相关文章
        if($content['category_id']){
            $category_cond['category_id'] = $content['category_id'];
            $tcontents = $this->_mergeMoreRelatedContent($category_cond, $tcontents, $content['id'], $size);
            if(count($tcontents) == $size) {
                return $tcontents;
            }

            //获取当前栏目的父栏目文章
            $category =  D('Category')->where('id=%d', $content['category_id'])->find();
            if($category['pid']){
                $pcategory_cond['category_id'] = $content['category_id'];
            }
            $tcontents = $this->_mergeMoreRelatedContent($pcategory_cond, $tcontents, $content['id'], $size);
            if(count($tcontents) == $size) {
                return $tcontents;
            }
        }


        //排除部分栏目下的文章
        if($exclude_category_ids){
            $exclude_cond['category_id'] =array('not in', $exclude_category_ids);
        }
        //获取所有栏目的id
        return $this->_mergeMoreRelatedContent($exclude_cond, $tcontents, $content['id'], $size);
    }

    //处理相关文章
    private function  _mergeMoreRelatedContent($filter, $current_contents, $current_id, $size){
        $rsize = $size + 1;
        $contents = $this->getPages($filter, 1, $rsize);
        foreach ($contents as $key => $p) {
            if($current_contents[$p['id']] || $current_id == $p['id']) continue;
            $current_contents[$p['id']] = $p;
            if(count($current_contents) >= $size){
               return $current_contents;
            }
        }
        return $current_contents;
    }

    public function getPrev($content_id, $category_id)
    {
        $f = array(
            'id'          => array('lt', intval($content_id)),
            'category_id' => intval($category_id),
            'status'      => 2,
            );

        /* 返回前一条数据 */
        $c = $this->field(true)->where($f)->order('weight desc, publish_time desc')->find();
        return $this->getRichInfo($c);
    }

    public function getNext($content_id, $category_id){
        $f = array(
            'id'          => array('gt', intval($content_id)),
            'category_id' => intval($category_id),
            'status'      => 2,
            );

        /* 返回前一条数据 */
        $c = $this->field(true)->where($f)->order('weight desc, publish_time asc')->find();
        return $this->getRichInfo($c);
    }


}
?>