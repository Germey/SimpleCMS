<?php

namespace Home\Model;
use Think\Model;
use Think\Log;

class SearchModel extends Model{ 
    function getMatchContent($content, $keyword,$headlen=60,$keyfront=30,$keybehind=60) {

        mb_internal_encoding("UTF-8");
        $content = trim(strip_tags($content));

        $head = mb_substr($content, 0,$headlen);
        $keycount = strlen($keyword);
        $pos = mb_stripos($content, $keyword);
        if($pos>$headlen){
            $start = $pos-$keyfront;
            $end = $keyfront+$keycount+$keybehind;
            $str = mb_substr($content,$start,$end);
            $str = $head."...&nbsp;&nbsp;".$str."...";
        } else {
            $start = 0;
            $end = $headlen+$keycount+$keybehind;
            $str = mb_substr($content, 0,$end);
            $str = $str ."...";
        }

        return $str;
    }

    function searchContent($keyword,$type,$range="shallow") {
        $keyword = trim($keyword);
        if(!$keyword) return NULL;

        $tagfilter['name'] = array('like', '%'.$keyword.'%');
        $maybe_tag_ids = D("Tag")->where($tagfilter)->getField('id',true);
        if($maybe_tag_ids) {
            $mapfilter['tag_id'] = array('in', $maybe_tag_ids);
            $maybe_content_ids = D("TagMapping")->where($mapfilter)->getField('object_id',true);
        }

        if($maybe_content_ids) {
            $filter['_string'] = ' (title like "%'.$keyword.'%")  OR id in ('. implode(',',$maybe_content_ids) .')';
        } else {
            $filter['title'] = array('like', '%'.$keyword.'%');
        }
        $order = 'publish_time desc';
        $pages = D('Content')->getPages($filter,0,0,$order);
        
        return $pages;
    }


    function getTopSearchKeys($size) {
        if(!$size) $size = 5;
        $result = D("Visit")->where('module="search"')->field('first_get skey, count(*) count')->group('skey')->order('count desc')->limit($size)->select();
        return $result;
    }
}