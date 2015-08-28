<?php
namespace Home\Model;
use Think\Model;

class ContentExtendModel extends Model {

    public function update($content_id, $extend_values) {
        $content_id = intval($content_id);
        if(!$content_id) return false;

        M('ContentExtend')->where('content_id='.$content_id)->delete();

        $data['content_id'] = $content_id;
        foreach ($extend_values as $k => $v) {
            if(!$v) {
                continue;
            }

            $data['name'] = $k;
            $data['value'] = $v;
            $this->add($data);
        }

        return true;
    }
}