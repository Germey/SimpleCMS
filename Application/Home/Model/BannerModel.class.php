<?php

namespace Home\Model;
use Think\Model;

class BannerModel extends Model{

    public function getBannerByName($name, $size) {
        $cache_key = 'banner_' . $name;
        if($result = S($cache_key)) {
            return $result;
        }

        $res = $this->getByName($name);
        $result = D('PictureMapping')->getMapping($res['id'], 'banner', intval($size));
        S($cache_key, $result);
        return $result;
    }
}
