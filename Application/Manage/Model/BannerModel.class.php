<?php

namespace Manage\Model;
use Think\Model;

class BannerModel extends Model{

    protected function _after_find(&$data, $options){
        $data['pictures'] = D('PictureMapping')->getMapping($data['id'], 'banner');
    }

    protected function _after_select(&$result,$options){

    }

}
