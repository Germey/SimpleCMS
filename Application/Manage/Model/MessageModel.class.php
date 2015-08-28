<?php

namespace Manage\Model;
use Think\Model;


class MessageModel extends Model{

    protected $_auto = array(
        array('update_time', 'date', Model::MODEL_BOTH, 'function',array('Y-m-d H:i:s')),
    );
}

?>