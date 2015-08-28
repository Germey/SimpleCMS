<?php
namespace Home\Model;
use Think\Model;

class FileMappingModel extends Model {


    public function getMapping($object_id, $object_type='content') {
        if(!$object_type || !$object_id) return;

        $sql = "select * from jxdrcms_file_mapping m, jxdrcms_file f where m.file_id=f.id and m.object_id=$object_id and m.object_type='$object_type' order by sequence";
        return $this->query($sql, false);
    }
}