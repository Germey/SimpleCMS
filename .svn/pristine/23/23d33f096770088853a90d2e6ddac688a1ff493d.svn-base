<?php

namespace Home\Model;
use Think\Model;

class MessageModel extends Model{
    /* 用户模型自动完成   array('field','填充内容','填充条件','附加规则',[额外参数])*/
    protected $_auto = array(
        array('create_time', 'date', Model::MODEL_INSERT, 'function', array('Y-m-d H:i:s')),
        array('update_time', 'date', Model::MODEL_BOTH, 'function', array('Y-m-d H:i:s')),
    );
}