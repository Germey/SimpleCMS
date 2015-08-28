<?php

namespace Manage\Model;
use Think\Model;


class CategoryModel extends Model{

    protected $_validate = array(
        array('name', 'require', '栏目英文名不能为空', self::EXISTS_VALIDATE, 'regex', self::MODEL_BOTH),
        array('name', '', '英文名已经存在', self::VALUE_VALIDATE, 'unique', self::MODEL_BOTH),
        array('title', 'require', '栏目名称不能为空', self::MUST_VALIDATE , 'regex', self::MODEL_BOTH),
    	array('keywords', '1,255', '网页关键字不能超过255个字符', self::VALUE_VALIDATE , 'length', self::MODEL_BOTH),
    	array('meta_title', '1,255', '网页描述不能超过255个字符', self::VALUE_VALIDATE , 'length', self::MODEL_BOTH),
    );

    protected $_auto = array(
        array('create_time', NOW_TIME, self::MODEL_INSERT),
        array('update_time', NOW_TIME, self::MODEL_BOTH),
    );

    protected function _after_find(&$data, $options){
        /* 分割模型 */
        if($data['models']){
            $data['models'] = unserialize($data['models']);
            $data['children_models'] = unserialize($data['children_models']);
        }

        /* 还原扩展数据 */
        if($data['extend_id']){
            $data['extend'] = D("Extend")->find($data['extend_id']);
        }

        $data['parent'] = NULL;
        if($data['pid']) {
            // 递归获取了所有parent
            $data['parent'] = D("Category")->getById($data['pid']);
            $data['parent_title'] = $data['parent']['title'];
        }
        $data['children'] = M("Category")->getsByPid($data['id']);
    }

    public function getCategorytype() {
        return array(
            1 => '频道页',
            2 => '列表页',
            3 => '外部链接',
            4 => '单页面' ,
            );
    }

    public function info($id, $field = true){
        /* 获取分类信息 */
        $map = array();
        if(is_numeric($id)){ //通过ID查询
            $map['id'] = $id;
        } else { //通过标识查询
            $map['name'] = $id;
        }
        return $this->field($field)->where($map)->find();
    }

    public function getTree($id = 0, $field = true, $condition = false){

        /* 获取当前分类信息 */
        if($id){
            $info = $this->info($id);
            $id   = $info['id'];
        }

        /* 获取所有分类 */
        $map  = array('status' => array('gt', -1));

        if($condition) {
            $map = array_merge($map,$condition);
        }
        
        $list = $this->field($field)->where($map)->order('sort, id')->select();
        $list = list_to_tree($list, $pk = 'id', $pid = 'pid', $child = '_', $root = $id);

        /* 获取返回数据 */
        if(isset($info)){ //指定分类则返回当前分类极其子分类
            $info['_'] = $list;
        } else { //否则返回所有分类
            $info = $list;
        }
        return $info;
    }

    public function getSameLevel($id, $field = true){
        $info = $this->info($id, 'pid');
        $map = array('pid' => $info['pid'], 'status' => 1);
        return $this->field($field)->where($map)->order('sort')->select();
    }

    public function update($data) {
        $data = $this->create($data);
        if(!$data) { //数据对象创建错误
            return false;
        }

        $last_id = $this->saveOrUpdate();
        if(!$last_id) {
            $this->error = $data['id']?'更新栏目出错！':'新增栏目出错！';
        }

        //更新分类缓存
        // S('sys_category_list', null);
        return $last_id;
    }


    function getParentCategory($cid) {
        if(empty($cid)){
            return false;
        }
        $cates  =   M('Category')->where(array('status'=>1))->field('id,title,pid')->order('sort')->select();
        $child  =   get_category($cid); //获取参数分类的信息
        $pid    =   $child['pid'];
        $temp   =   array();
        $res[]  =   $child;
        while(true){
            foreach ($cates as $key=>$cate){
                if($cate['id'] == $pid){
                    $pid = $cate['pid'];
                    array_unshift($res, $cate); //将父分类插入到数组第一个元素前
                }
            }
            if($pid == 0){
                break;
            }
        }
        return $res;
    }

    public function getChildrenId($cat_id){
        
        $field = 'id,name,pid,title';
        $category = $this->getTree($cat_id, $field);

        $ids = array();
        foreach ($category['_'] as $key => $value) {
            $ids[] = $value['id'];
        }
        return $ids;
    }

    public function getCategoryLink ($category_id) {
        //还没想好栏目链接怎样扩展，先留个接口
        return '/home/type/'.$category_id;
    }

    /**
     * 取出编辑可浏览栏目的ids
     */
    public function getIdsForTree($ids) {
        if(!$ids) return NULL;

        static $res = array();
        if(is_array($ids)) {
            foreach($ids as $v) {
                $res[] = $v;
                $pid = $this->where(array('id'=>$v))->getField('pid');
                if($pid) {
                    $this->getIdsForTree($pid);
                }
            }
        }else {
            $res[] = intval($ids);
            $pid = $this->where(array('id'=>$ids))->getField('pid');
            if($pid !=0) {
                    $this->getIdsForTree($pid);
                }
        }
        
        return $res;
    }
}
