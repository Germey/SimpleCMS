<?php
namespace Manage\Model;
use Think\Model;

class PictureMappingModel extends Model {

    public function updateMapping($object_id, $object_type='content', $picture_info) {
        if(!$object_id) return;

        $filter['object_id'] = $object_id;
        $filter['object_type'] = $object_type;
        M("PictureMapping")->where($filter)->delete();

        foreach ($picture_info as $pid => $info) {
            $data['object_id'] = $object_id;
            $data['object_type'] = $object_type;
            $data['picture_id'] = $pid;
            $data['title'] = $info['title'];
            $data['summary'] = $info['summary'];
            $data['link'] = $info['link'];
            $data['sequence'] = ++$seq;

            M("PictureMapping")->add($data);
        } 
    }


    public function getMapping($object_id, $object_type='content') {
        if(!$object_type || !$object_id) return;

        $sql = "select * from jxdrcms_picture_mapping g, jxdrcms_picture p where g.picture_id=p.id and g.object_id=$object_id and g.object_type='$object_type' order by sequence";

        return $this->query($sql, false);
    }
}