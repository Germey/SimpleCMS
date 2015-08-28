<?php

namespace Common\Model;
use Think\Model;

class ConfigModel extends Model{
   
   public function getConfigValue($key) {
        $filter['key'] = $key;
        return $this->where($filter)->getField("value");
    }
}