<?php
namespace Manage\Model;
use Think\Model;

class SourceModel extends Model {

    public function getSourceByName($source_name, $with_save=true) {
    	if(!$source_name) return NULL;

        $source = M('Source')->getByName($source_name);
        if($source) return $source;

        if(!$with_save) return NULL;

        $data['name'] = $source_name;
        $last_id = $this->saveOrUpdate($data);

        return $this->getById($last_id);
    }
}