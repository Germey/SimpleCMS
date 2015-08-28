<?php
namespace Manage\Model;
use Think\Model;

class AuthorModel extends Model {

    public function getAuthorByName($author_name, $with_save=true) {
        if(!$author_name) return NULL;

        $author = M('Author')->getByName($author_name);
        if($author) return $author;

        if(!$with_save) return NULL;

        $data['name'] = $author_name;
        $last_id = $this->saveOrUpdate($data);

        return $this->getById($last_id);
    }


    public function getAuthorContentMap($author_id) {
        $sql = 'select author_id, count(*) count from jxdrcms_content group by author_id';
        $raw = $this->query($sql, true);
        foreach ($raw as $k => $v) {
            $rs[intval($v['author_id'])] = $v['count'];
        }
        if(isset($author_id)) {
            return $rs[$author_id];
        }
        return $rs;
    }
}