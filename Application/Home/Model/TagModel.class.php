<?php
namespace Home\Model;
use Think\Model;

class TagModel extends Model {

    public function getByObject($ids = array(), $object_type) {
        $one = is_array($ids) ? false : true;
        settype($ids, 'array');
        $idstring = join(',', $ids);
        if(preg_match('/[\s]/', $idstring)) return array();

        $tags = $this
           ->table("jxdrcms_tag ct, jxdrcms_tag_mapping ctm")
           ->field("ct.*, ctm.*")
           ->where("ct.id = ctm.tag_id and ctm.object_id in ($idstring)")
           ->query("select %FIELD% from %TABLE% %WHERE%", true);

        if(!$tags) return array();

        foreach ($tags as $t) {
            $rs[$t['object_id']][$t['tag_id']] = $t;
        }

        return $rs;
    }

    public function updateMapping($object_type, $object_id, $newTagIds) {
        $object_id = intval($object_id);
        if(!$object_id) return NULL;

        D("TagMapping")->where("object_id = $object_id and object_type = '$object_type'")->delete();

        foreach ($newTagIds as $tid) {
            $data = array('object_type' => $object_type, 'object_id' => $object_id, 'tag_id' => $tid);
            D("TagMapping")->add($data);
        }

        return $object_id;
    }

    public function getTagsWeight($object_type) {
        settype($object_type, 'array');

        $object_type_str = implode(',', $object_type);

        $sql = 'SELECT tag_id tag_id, name, COUNT(*) count 
                FROM jxdrcms_tag t, jxdrcms_tag_mapping tm 
                WHERE t.id = tm.tag_id and tm.object_type in (' . $object_type_str . ') GROUP BY tag_id order by count desc';
        $rs = ass_column($this->query($sql, true), 'tag_id');

        return $rs;
    }


    // Runmiao New
    function gets($filter,$page=0,$size=0, $order) {
        if(!$filter) $filter = array();

        if(!$order) {
            $order = 'id desc';
        }
        $pages = $this->where($filter)->order($order);

        if(!empty($page) && !empty($size)){
            $pages->page($page, $size);
        }
        $tags = $pages->select();
        foreach ($tags as $k => $v) {
            $sid = $v['id'];
            $pids = D("TagMapping")->where("tag_id = $sid")->getField('object_id',true);
            $fp['id'] = array('in', $pids);
            $tags[$k]['page_count'] = D("Pages")->where($fp)->count();
        }
        return $tags;
    }

    function updateTags($object_id, $tag_ids=array()) {
        if(!$object_id) {
            return false;
        }

        D("TagMapping")->where("object_id = $object_id")->delete();
        foreach ($tag_ids as $tid) {
            if(strpos($tid, 'newtag_')===0) {
                $new['name'] = substr($tid, 7);
                $tid = M("Tag")->saveOrUpdate($new);
            }
            $data = array('object_id' => $object_id, 'tag_id' => $tid);
            D("TagMapping")->add($data);
        }

        return true;
    }

    public function getByObjectId($ids = array()) {
        $one = is_array($ids) ? false : true;
        settype($ids, 'array');
        $idstring = join(',', $ids);
        if(preg_match('/[\s]/', $idstring)) return array();

        $tags = $this
           ->table("jxdrcms_tag ct, jxdrcms_tag_mapping ctm")
           ->field("ct.*, ctm.*")
           ->where("ct.id = ctm.tag_id and ctm.object_id in ($idstring)")
           ->query("select %FIELD% from %TABLE% %WHERE%", true);

        if(!$tags) return array();

        foreach ($tags as $t) {
            $rs[$t['object_id']][$t['tag_id']] = $t;
        }

        return $rs;
    }

    public function getTagNameByTagId($tag_id) {
        if(!$tag_id){
            return false;
        } 
        return M('Tags')->where(array('id'=>$tag_id))->find();
    }

}