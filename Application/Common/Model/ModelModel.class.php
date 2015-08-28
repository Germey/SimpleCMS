<?php
namespace Common\Model;
use Think\Model;

class ModelModel extends Model {

    public function getModels($id=0, $field=NULL) {
        $models = array(
              1 => array('id' => 1, 'alias' => 'article', 'name' => '文章', 'template' => 'article/detail', 'icon_class' => 'gi gi-file'),
              2 => array('id' => 2, 'alias' => 'picture', 'name' => '组图', 'template' => 'picture/detail', 'icon_class' => 'hi hi-picture'),
              3 => array('id' => 3, 'alias' => 'link', 'name' => '链接', 'template' => '', 'icon_class' => 'gi gi-link'),
              4 => array('id' => 4, 'alias' => 'video', 'name' => '视频', 'template' => 'video/detail', 'icon_class' => 'gi gi-facetime_video'),
              5 => array('id' => 5, 'alias' => 'file', 'name' => '文件', 'template' => 'file/detail', 'icon_class' => 'gi gi-download_alt'),
              6 => array('id' => 6, 'alias' => 'mappoint', 'name' => '位置', 'template' => 'map/detail', 'icon_class' => 'hi hi-map-marker'),
            );

        $disabled_models_display = D('Config')->getConfigValue('disabled_content_models');
        $disabled_models_display = explode(',',$disabled_models_display);
        foreach($models as $k=>$v) {
          if(in_array($k, $disabled_models_display)) {
            unset($models[$k]);
          }
        }

        if($id && $field) {
            return $models[$id][$field];
        }

        if(!$field && $id) {
            return $models[$id];
        }

        return $models;
    }
}