<?php
namespace Manage\Model;
use Think\Model;

class ConfigModel extends Model {

    public function getTypes($id=0, $field=NULL) {
       $types = array(
            1 => array('id' => 1, 'name' => 'site', 'title' => '站点信息'),
            2 => array('id' => 2, 'name' => 'mail', 'title' => 'SMTP邮件'),
            3 => array('id' => 3, 'name' => 'register', 'title' => '注册登录'),
            4 => array('id' => 4, 'name' => 'lingxiapi', 'title' => '灵析API'),
            5 => array('id' => 5, 'name' => 'subscribe', 'title' => '用户订阅'),
            6 => array('id' => 6, 'name' => 'custom', 'title' => '自定义'),
            7 => array('id' => 7, 'name' => 'developer', 'title' => '开发者设置','developer_display' => true),
        );

        if($id && $field) {
            return $types[$id][$field];
        }

        if(!$field && $id) {
            return $types[$id];
        }

        return $types;
    }

    public function getConfigByType($type) {
        if(is_numeric($type)) {
            $filter['type'] = $this->getTypes($type, 'name');
        } else {
            $filter['type'] = $type;
        }

        return $this->where($filter)->order('id')->select();

    }

    public function getConfigValue($key) {
        $filter['key'] = $key;
        return $this->where($filter)->getField("value");
    }

    public function update($data){
        if(!$data) return null;
        $this->create($data);
        return $this->saveOrUpdate($data);
    }

}
?>