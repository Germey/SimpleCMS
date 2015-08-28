<?php

namespace Manage\Model;
use Think\Model;

class ExtendModel extends Model{

    public function getExtendFieldTypes($type=NULL) {
        $types = array(
          'string'   => '字符串',
          'link'     => '链接',
          // 'select'   => '下拉框',
          'radio'   => '单选框',
          'checkbox' => '复选框',
          'text'     => '文本框',
          'editor'   => '富文本框',
          'picture'  => '图片',
          'file'     => '文件',
        );

        if($type) {
            return $types[$type];
        }
        return $types;
    }

    protected function _after_find(&$data, $options){
        if($data['extends']) {
            $data['extends'] = unserialize($data['extends']);
        }
    }

    protected function _after_select(&$result,$options){
        foreach($result as &$record){
            $this->_after_find($record,$options);
        }
    }

}
