<?php
namespace Manage\Model;
use Think\Model;

class StatusModel extends Model {

    public function getContentStatus($id=0, $field=NULL) {
        $statuses = array(
              1 => array('id' => 1, 'alias' => 'draft', 'name' => '<span class="text-danger">草稿</span>', 
                         'action' => array('link' => U('publish'), 'title' => '发布文章', 'ask' => '确定要发布该文章？', 'icon' => 'fa fa-level-up'), 
                         ),
              2 => array('id' => 2, 'alias' => 'publish', 'name' => '<span class="text-success">已发</span>', 
                         // 'action' => array('link' => '/manage/', 'title' => '下线', 'ask' => '确定要下线该文章？', 'icon' => 'fa fa-chevron-down'), 
                        ),
              3 => array('id' => 3, 'alias' => 'due_publish' , 'name' => '<span class="text-danger">定时发布</span>'),
              10 => array('id' => 10, 'alias' => 'trash', 'name' => '<span class="text-warning">回收站</span>',
                         'action' => array('link' => U('recycle'), 'title' => '还原', 'ask' => '确定要还原该文章？还原后文章默认为草稿状态。', 'icon' => 'gi gi-restart'), 
                        ),
            );

        if($id && $field) {
            return $statuses[$id][$field];
        }

        if(!$field && $id) {
            return $statuses[$id];
        }

        return $statuses;
    }
}