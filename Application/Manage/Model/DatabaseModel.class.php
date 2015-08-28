<?php

namespace Manage\Model;
use Think\Model;


class DatabaseModel extends Model{

    function sub_menu() {
      return  array(
            'export' => array('title'=>'数据备份','link'=>U('Database/index?type=export'),'name'=>'export',),
            'import' => array('title'=>'数据还原', 'link'=>U('Database/index?type=import'),'name'=>'import',),
            );
    }
}