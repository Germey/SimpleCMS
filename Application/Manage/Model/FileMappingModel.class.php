<?php
namespace Manage\Model;
use Think\Model;

class FileMappingModel extends Model {

    public function updateMapping($object_id, $object_type='content', $file_info) {
        if(!$object_id) return;

        $filter['object_id'] = $object_id;
        $filter['object_type'] = $object_type;
        M("FileMapping")->where($filter)->delete();

        foreach ($file_info as $fid => $info) {
            $data['object_id'] = $object_id;
            $data['object_type'] = $object_type;
            $data['file_id'] = $fid;
            $data['title'] = $info['title'];
            $data['summary'] = $info['summary'];
            $data['sequence'] = ++$seq;

            M("FileMapping")->add($data);
        } 
    }


    public function getMapping($object_id, $object_type='content') {
        if(!$object_type || !$object_id) return;

        $sql = "select * from jxdrcms_file_mapping m, jxdrcms_file f where m.file_id=f.id and m.object_id=$object_id and m.object_type='$object_type' order by sequence";

        return $this->query($sql, false);
    }
}