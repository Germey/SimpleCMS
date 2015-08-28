<?php

// OneThink常量定义
const ONETHINK_ADDON_PATH = './Addons/';

function is_login(){
    $user = session('user_auth');
    if (empty($user)) {
        return 0;
    } else {
        return session('user_auth_sign') == data_auth_sign($user) ? $user['uid'] : 0;
    }
}

function is_developer($uid = null){
    $uid = is_null($uid) ? is_login() : $uid;
    return $uid && (intval($uid) === 1);
}

function is_administrator($uid = null){
    $uid = is_null($uid) ? is_login() : $uid;
    return $uid && (intval($uid) === 2);
}

/**
 * 字符串转换为数组，主要用于把分隔符调整到第二个参数
 * @param  string $str  要分割的字符串
 * @param  string $glue 分割符
 * @return array
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function str2arr($str, $glue = ','){
    return explode($glue, $str);
}

/**
 * 数组转换为字符串，主要用于把分隔符调整到第二个参数
 * @param  array  $arr  要连接的数组
 * @param  string $glue 分割符
 * @return string
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function arr2str($arr, $glue = ','){
    return implode($glue, $arr);
}

/**
 * 字符串截取，支持中文和其他编码
 * @static
 * @access public
 * @param string $str 需要转换的字符串
 * @param string $start 开始位置
 * @param string $length 截取长度
 * @param string $charset 编码格式
 * @param string $suffix 截断显示字符
 * @return string
 */
function msubstr($str, $start=0, $length, $charset="utf-8", $suffix=true) {
    if(function_exists("mb_substr"))
        $slice = mb_substr($str, $start, $length, $charset);
    elseif(function_exists('iconv_substr')) {
        $slice = iconv_substr($str,$start,$length,$charset);
        if(false === $slice) {
            $slice = '';
        }
    }else{
        $re['utf-8']   = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
        $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
        $re['gbk']    = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
        $re['big5']   = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
        preg_match_all($re[$charset], $str, $match);
        $slice = join("",array_slice($match[0], $start, $length));
    }
    return $suffix ? $slice.'...' : $slice;
}

/**
 * 系统加密方法
 * @param string $data 要加密的字符串
 * @param string $key  加密密钥
 * @param int $expire  过期时间 单位 秒
 * @return string
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function think_encrypt($data, $key = '', $expire = 0) {
    $key  = md5(empty($key) ? C('DATA_AUTH_KEY') : $key);
    $data = base64_encode($data);
    $x    = 0;
    $len  = strlen($data);
    $l    = strlen($key);
    $char = '';

    for ($i = 0; $i < $len; $i++) {
        if ($x == $l) $x = 0;
        $char .= substr($key, $x, 1);
        $x++;
    }

    $str = sprintf('%010d', $expire ? $expire + time():0);

    for ($i = 0; $i < $len; $i++) {
        $str .= chr(ord(substr($data, $i, 1)) + (ord(substr($char, $i, 1)))%256);
    }
    return str_replace(array('+','/','='),array('-','_',''),base64_encode($str));
}

/**
 * 系统解密方法
 * @param  string $data 要解密的字符串 （必须是think_encrypt方法加密的字符串）
 * @param  string $key  加密密钥
 * @return string
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function think_decrypt($data, $key = ''){
    $key    = md5(empty($key) ? C('DATA_AUTH_KEY') : $key);
    $data   = str_replace(array('-','_'),array('+','/'),$data);
    $mod4   = strlen($data) % 4;
    if ($mod4) {
       $data .= substr('====', $mod4);
    }
    $data   = base64_decode($data);
    $expire = substr($data,0,10);
    $data   = substr($data,10);

    if($expire > 0 && $expire < time()) {
        return '';
    }
    $x      = 0;
    $len    = strlen($data);
    $l      = strlen($key);
    $char   = $str = '';

    for ($i = 0; $i < $len; $i++) {
        if ($x == $l) $x = 0;
        $char .= substr($key, $x, 1);
        $x++;
    }

    for ($i = 0; $i < $len; $i++) {
        if (ord(substr($data, $i, 1))<ord(substr($char, $i, 1))) {
            $str .= chr((ord(substr($data, $i, 1)) + 256) - ord(substr($char, $i, 1)));
        }else{
            $str .= chr(ord(substr($data, $i, 1)) - ord(substr($char, $i, 1)));
        }
    }
    return base64_decode($str);
}

/**
 * 数据签名认证
 * @param  array  $data 被认证的数据
 * @return string       签名
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function data_auth_sign($data) {
    //数据类型检测
    if(!is_array($data)){
        $data = (array)$data;
    }
    ksort($data); //排序
    $code = http_build_query($data); //url编码并生成query字符串
    $sign = sha1($code); //生成签名
    return $sign;
}

/**
* 对查询结果集进行排序
* @access public
* @param array $list 查询结果
* @param string $field 排序的字段名
* @param array $sortby 排序类型
* asc正向排序 desc逆向排序 nat自然排序
* @return array
*/
function list_sort_by($list,$field, $sortby='asc') {
   if(is_array($list)){
       $refer = $resultSet = array();
       foreach ($list as $i => $data)
           $refer[$i] = &$data[$field];
       switch ($sortby) {
           case 'asc': // 正向排序
                asort($refer);
                break;
           case 'desc':// 逆向排序
                arsort($refer);
                break;
           case 'nat': // 自然排序
                natcasesort($refer);
                break;
       }
       foreach ( $refer as $key=> $val)
           $resultSet[] = &$list[$key];
       return $resultSet;
   }
   return false;
}

/**
 * 把返回的数据集转换成Tree
 * @param array $list 要转换的数据集
 * @param string $pid parent标记字段
 * @param string $level level标记字段
 * @return array
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function list_to_tree($list, $pk='id', $pid = 'pid', $child = '_child', $root = 0) {
    // 创建Tree
    $tree = array();
    if(is_array($list)) {
        // 创建基于主键的数组引用
        $refer = array();
        foreach ($list as $key => $data) {
            $refer[$data[$pk]] =& $list[$key];
        }
        foreach ($list as $key => $data) {
            // 判断是否存在parent
            $parentId =  $data[$pid];
            if ($root == $parentId) {
                $tree[] =& $list[$key];
            }else{
                if (isset($refer[$parentId])) {
                    $parent =& $refer[$parentId];
                    $parent[$child][] =& $list[$key];
                }
            }
        }
    }
    return $tree;
}

/**
 * 将list_to_tree的树还原成列表
 * @param  array $tree  原来的树
 * @param  string $child 孩子节点的键
 * @param  string $order 排序显示的键，一般是主键 升序排列
 * @param  array  $list  过渡用的中间数组，
 * @return array        返回排过序的列表数组
 * @author yangweijie <yangweijiester@gmail.com>
 */
function tree_to_list($tree, $child = '_child', $order='id', &$list = array()){
    if(is_array($tree)) {
        $refer = array();
        foreach ($tree as $key => $value) {
            $reffer = $value;
            if(isset($reffer[$child])){
                unset($reffer[$child]);
                tree_to_list($value[$child], $child, $order, $list);
            }
            $list[] = $reffer;
        }
        $list = list_sort_by($list, $order, $sortby='asc');
    }
    return $list;
}

/**
 * 格式化字节大小
 * @param  number $size      字节数
 * @param  string $delimiter 数字和单位分隔符
 * @return string            格式化后的带单位的大小
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function format_bytes($size, $delimiter = '') {
    $units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
    for ($i = 0; $size >= 1024 && $i < 5; $i++) $size /= 1024;
    return round($size, 2) . $delimiter . $units[$i];
}

/**
 * 处理插件钩子
 * @param string $hook   钩子名称
 * @param mixed $params 传入参数
 * @return void
 */
function hook($hook,$params=array()){
    \Think\Hook::listen($hook,$params);
}

/**
 * 获取插件类的类名
 * @param strng $name 插件名
 */
function get_addon_class($name){
    $class = "Addons\\{$name}\\{$name}Addon";
    return $class;
}

/**
 * 获取插件类的配置文件数组
 * @param string $name 插件名
 */
function get_addon_config($name){
    $class = get_addon_class($name);
    if(class_exists($class)) {
        $addon = new $class();
        return $addon->getConfig();
    }else {
        return array();
    }
}

/**
 * 插件显示内容里生成访问插件的url
 * @param string $url url
 * @param array $param 参数
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function addons_url($url, $param = array()){
    $url        = parse_url($url);
    $case       = C('URL_CASE_INSENSITIVE');
    $addons     = $case ? parse_name($url['scheme']) : $url['scheme'];
    $controller = $case ? parse_name($url['host']) : $url['host'];
    $action     = trim($case ? strtolower($url['path']) : $url['path'], '/');

    /* 解析URL带的参数 */
    if(isset($url['query'])){
        parse_str($url['query'], $query);
        $param = array_merge($query, $param);
    }

    /* 基础参数 */
    $params = array(
        '_addons'     => $addons,
        '_controller' => $controller,
        '_action'     => $action,
    );
    $params = array_merge($params, $param); //添加额外参数

    return U('Addons/execute', $params);
}

/**
 * 时间戳格式化
 * @param int $time
 * @return string 完整的时间显示
 * @author huajie <banhuajie@163.com>
 */
function time_format($time = NULL,$format='Y-m-d H:i'){
    $time = $time === NULL ? NOW_TIME : intval($time);
    return date($format, $time);
}

/**
 * 根据用户ID获取用户名
 * @param  integer $uid 用户ID
 * @return string       用户名
 */
function get_username($uid = 0){
    static $list;
    if(!($uid && is_numeric($uid))){ //获取当前登录用户名
        return session('user_auth.username');
    }

    /* 获取缓存数据 */
    if(empty($list)){
        $list = S('sys_active_user_list');
    }

    /* 查找用户信息 */
    $key = "u{$uid}";
    if(isset($list[$key])){ //已缓存，直接使用
        $name = $list[$key];
    } else { //调用接口获取用户信息
        $User = new User\Api\UserApi();
        $info = $User->info($uid);
        if($info && isset($info[1])){
            $name = $list[$key] = $info[1];
            /* 缓存用户 */
            $count = count($list);
            $max   = C('USER_MAX_CACHE');
            while ($count-- > $max) {
                array_shift($list);
            }
            S('sys_active_user_list', $list);
        } else {
            $name = '';
        }
    }
    return $name;
}

/**
 * 根据用户ID获取用户昵称
 * @param  integer $uid 用户ID
 * @return string       用户昵称
 */
function get_nickname($uid = 0){
    static $list;
    if(!($uid && is_numeric($uid))){ //获取当前登录用户名
        return session('user_auth.username');
    }

    /* 获取缓存数据 */
    if(empty($list)){
        $list = S('sys_user_nickname_list');
    }

    /* 查找用户信息 */
    $key = "u{$uid}";
    if(isset($list[$key])){ //已缓存，直接使用
        $name = $list[$key];
    } else { //调用接口获取用户信息
        $info = M('Member')->field('nickname')->find($uid);
        if($info !== false && $info['nickname'] ){
            $nickname = $info['nickname'];
            $name = $list[$key] = $nickname;
            /* 缓存用户 */
            $count = count($list);
            $max   = C('USER_MAX_CACHE');
            while ($count-- > $max) {
                array_shift($list);
            }
            S('sys_user_nickname_list', $list);
        } else {
            $name = '';
        }
    }
    return $name;
}

/**
 * 获取分类信息并缓存分类
 * @param  integer $id    分类ID
 * @param  string  $field 要获取的字段名
 * @return string         分类信息
 */
function get_category($id, $field = null){
    static $list;

    /* 非法分类ID */
    if(empty($id) || !is_numeric($id)){
        return '';
    }

    /* 读取缓存数据 */
    // if(empty($list)){
    //     $list = S('sys_category_list');
    // }

    /* 获取分类名称 */
    if(!isset($list[$id])){
        $cate = M('Category')->find($id);
        if(!$cate || 1 != $cate['status']){ //不存在分类，或分类被禁用
            return '';
        }
        $list[$id] = $cate;
        S('sys_category_list', $list); //更新缓存
    }
    return is_null($field) ? $list[$id] : $list[$id][$field];
}

/* 根据ID获取分类标识 */
function get_category_name($id){
    return get_category($id, 'name');
}

/* 根据ID获取分类名称 */
function get_category_title($id){
    return get_category($id, 'title');
}

/**
 * 记录行为日志，并执行该行为的规则
 * @param string $action 行为标识
 * @param string $model 触发行为的模型名
 * @param int $record_id 触发行为的记录id
 * @param int $user_id 执行行为的用户id
 * @return boolean
 * @author huajie <banhuajie@163.com>
 */
function action_log($action = null, $model = null, $record_id = null, $user_id = null){

    //参数检查
    if(empty($action) || empty($model) || empty($record_id)){
        return '参数不能为空';
    }
    if(empty($user_id)){
        $user_id = is_login();
    }

    //查询行为,判断是否执行
    $action_info = M('Action')->getByName($action);
    if($action_info['status'] != 1){
        return '该行为被禁用或删除';
    }

    //插入行为日志
    $data['action_id']      =   $action_info['id'];
    $data['user_id']        =   $user_id;
    $data['action_ip']      =   ip2long(get_client_ip());
    $data['model']          =   $model;
    $data['record_id']      =   $record_id;
    $data['create_time']    =   NOW_TIME;

    //解析日志规则,生成日志备注
    if(!empty($action_info['log'])){
        if(preg_match_all('/\[(\S+?)\]/', $action_info['log'], $match)){
            $log['user']    =   $user_id;
            $log['record']  =   $record_id;
            $log['model']   =   $model;
            $log['time']    =   NOW_TIME;
            $log['data']    =   array('user'=>$user_id,'model'=>$model,'record'=>$record_id,'time'=>NOW_TIME);
            foreach ($match[1] as $value){
                $param = explode('|', $value);
                if(isset($param[1])){
                    $replace[] = call_user_func($param[1],$log[$param[0]]);
                }else{
                    $replace[] = $log[$param[0]];
                }
            }
            $data['remark'] =   str_replace($match[0], $replace, $action_info['log']);
        }else{
            $data['remark'] =   $action_info['log'];
        }
    }else{
        //未定义日志规则，记录操作url
        $data['remark']     =   '操作url：'.$_SERVER['REQUEST_URI'];
    }

    M('ActionLog')->add($data);

    if(!empty($action_info['rule'])){
        //解析行为
        $rules = parse_action($action, $user_id);

        //执行行为
        $res = execute_action($rules, $action_info['id'], $user_id);
    }
}

/**
 * 解析行为规则
 * 规则定义  table:$table|field:$field|condition:$condition|rule:$rule[|cycle:$cycle|max:$max][;......]
 * 规则字段解释：table->要操作的数据表，不需要加表前缀；
 *              field->要操作的字段；
 *              condition->操作的条件，目前支持字符串，默认变量{$self}为执行行为的用户
 *              rule->对字段进行的具体操作，目前支持四则混合运算，如：1+score*2/2-3
 *              cycle->执行周期，单位（小时），表示$cycle小时内最多执行$max次
 *              max->单个周期内的最大执行次数（$cycle和$max必须同时定义，否则无效）
 * 单个行为后可加 ； 连接其他规则
 * @param string $action 行为id或者name
 * @param int $self 替换规则里的变量为执行用户的id
 * @return boolean|array: false解析出错 ， 成功返回规则数组
 * @author huajie <banhuajie@163.com>
 */
function parse_action($action = null, $self){
    if(empty($action)){
        return false;
    }

    //参数支持id或者name
    if(is_numeric($action)){
        $map = array('id'=>$action);
    }else{
        $map = array('name'=>$action);
    }

    //查询行为信息
    $info = M('Action')->where($map)->find();
    if(!$info || $info['status'] != 1){
        return false;
    }

    //解析规则:table:$table|field:$field|condition:$condition|rule:$rule[|cycle:$cycle|max:$max][;......]
    $rules = $info['rule'];
    $rules = str_replace('{$self}', $self, $rules);
    $rules = explode(';', $rules);
    $return = array();
    foreach ($rules as $key=>&$rule){
        $rule = explode('|', $rule);
        foreach ($rule as $k=>$fields){
            $field = empty($fields) ? array() : explode(':', $fields);
            if(!empty($field)){
                $return[$key][$field[0]] = $field[1];
            }
        }
        //cycle(检查周期)和max(周期内最大执行次数)必须同时存在，否则去掉这两个条件
        if(!array_key_exists('cycle', $return[$key]) || !array_key_exists('max', $return[$key])){
            unset($return[$key]['cycle'],$return[$key]['max']);
        }
    }

    return $return;
}

/**
 * 执行行为
 * @param array $rules 解析后的规则数组
 * @param int $action_id 行为id
 * @param array $user_id 执行的用户id
 * @return boolean false 失败 ， true 成功
 * @author huajie <banhuajie@163.com>
 */
function execute_action($rules = false, $action_id = null, $user_id = null){
    if(!$rules || empty($action_id) || empty($user_id)){
        return false;
    }

    $return = true;
    foreach ($rules as $rule){

        //检查执行周期
        $map = array('action_id'=>$action_id, 'user_id'=>$user_id);
        $map['create_time'] = array('gt', NOW_TIME - intval($rule['cycle']) * 3600);
        $exec_count = M('ActionLog')->where($map)->count();
        if($exec_count > $rule['max']){
            continue;
        }

        //执行数据库操作
        $Model = M(ucfirst($rule['table']));
        $field = $rule['field'];
        $res = $Model->where($rule['condition'])->setField($field, array('exp', $rule['rule']));

        if(!$res){
            $return = false;
        }
    }
    return $return;
}


if(!function_exists('array_column')){
    function array_column(array $input, $columnKey, $indexKey = null) {
        $result = array();
        if (null === $indexKey) {
            if (null === $columnKey) {
                $result = array_values($input);
            } else {
                foreach ($input as $row) {
                    $result[] = $row[$columnKey];
                }
            }
        } else {
            if (null === $columnKey) {
                foreach ($input as $row) {
                    $result[$row[$indexKey]] = $row;
                }
            } else {
                foreach ($input as $row) {
                    $result[$row[$indexKey]] = $row[$columnKey];
                }
            }
        }
        return $result;
    }
}

/**
 * 获取属性信息并缓存
 * @param  integer $id    属性ID
 * @param  string  $field 要获取的字段名
 * @return string         属性信息
 */
function get_model_attribute($model_id, $group = true){
    static $list;

    /* 非法ID */
    if(empty($model_id) || !is_numeric($model_id)){
        return '';
    }

    /* 读取缓存数据 */
    if(empty($list)){
        $list = S('attribute_list');
    }

    /* 获取属性 */
    if(!isset($list[$model_id])){
        $map = array('model_id'=>$model_id);
        $extend = M('Model')->getFieldById($model_id,'extend');

        if($extend){
            $map = array('model_id'=> array("in", array($model_id, $extend)));
        }
        $info = M('Attribute')->where($map)->select();
        $list[$model_id] = $info;
        //S('attribute_list', $list); //更新缓存
    }

    $attr = array();
    foreach ($list[$model_id] as $value) {
        $attr[$value['id']] = $value;
    }

    if($group){
        $sort  = M('Model')->getFieldById($model_id,'field_sort');

        if(empty($sort)){	//未排序
            $group = array(1=>array_merge($attr));
        }else{
            $group = json_decode($sort, true);

            $keys  = array_keys($group);
            foreach ($group as &$value) {
                foreach ($value as $key => $val) {
                    $value[$key] = $attr[$val];
                    unset($attr[$val]);
                }
            }

            if(!empty($attr)){
                $group[$keys[0]] = array_merge($group[$keys[0]], $attr);
            }
        }
        $attr = $group;
    }
    return $attr;
}

/**
 * 调用系统的API接口方法（静态方法）
 * api('User/getName','id=5'); 调用公共模块的User接口的getName方法
 * api('Admin/User/getName','id=5');  调用Admin模块的User接口
 * @param  string  $name 格式 [模块名]/接口名/方法名
 * @param  array|string  $vars 参数
 */
function api($name,$vars=array()){
    $array     = explode('/',$name);
    $method    = array_pop($array);
    $classname = array_pop($array);
    $module    = $array? array_pop($array) : 'Common';
    $callback  = $module.'\\Api\\'.$classname.'Api::'.$method;
    if(is_string($vars)) {
        parse_str($vars,$vars);
    }
    return call_user_func_array($callback,$vars);
}

/**
 * 获取数据的所有子孙数据的id值
 * @author 朱亚杰 <xcoolcc@gmail.com>
 */

function get_stemma($pids,Model &$model, $field='id'){
    $collection = array();

    //非空判断
    if(empty($pids)){
        return $collection;
    }

    if( is_array($pids) ){
        $pids = trim(implode(',',$pids),',');
    }
    $result     = $model->field($field)->where(array('pid'=>array('IN',(string)$pids)))->select();
    $child_ids  = array_column ((array)$result,'id');

    while( !empty($child_ids) ){
        $collection = array_merge($collection,$result);
        $result     = $model->field($field)->where( array( 'pid'=>array( 'IN', $child_ids ) ) )->select();
        $child_ids  = array_column((array)$result,'id');
    }
    return $collection;
}

function pagestring($count, $pagesize, $wap=false) {
  $p = new Think\Pager($count, $pagesize, 'page');
  return array($pagesize, $p->pageNo, $p->genBasic());
}

function csubstr($str,$start,$len) {
  $strlen = strlen($str);
  $clen = 0;
  for($i=0; $i<$strlen; $i++,$clen++) {
    if ($clen >= $start+$len) {
      break;
  }
  if(ord(substr($str,$i,1))>0xa0) {
      if ($clen>=$start) {
        $tmpstr.=substr($str,$i,3);
    }
    $i = $i+2;
    $clen++;
} else {
  if ($clen >= $start)
      $tmpstr .= substr($str,$i,1);
}
}
return $tmpstr;
}

function get_short($str,$len, $ending="...") {
  $tempstr = csubstr($str,0,$len);
  if ($str<>$tempstr) {
    $tempstr .= $ending;
}
return $tempstr;
}

if(!function_exists('mime_content_type')) {

    function mime_content_type($filename) {

        $mime_types = array(

            'txt' => 'text/plain',
            'htm' => 'text/html',
            'html' => 'text/html',
            'php' => 'text/html',
            'css' => 'text/css',
            'js' => 'application/javascript',
            'json' => 'application/json',
            'xml' => 'application/xml',
            'swf' => 'application/x-shockwave-flash',
            'flv' => 'video/x-flv',

            // images
            'png' => 'image/png',
            'jpe' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'jpg' => 'image/jpeg',
            'gif' => 'image/gif',
            'bmp' => 'image/bmp',
            'ico' => 'image/vnd.microsoft.icon',
            'tiff' => 'image/tiff',
            'tif' => 'image/tiff',
            'svg' => 'image/svg+xml',
            'svgz' => 'image/svg+xml',

            // archives
            'zip' => 'application/zip',
            'rar' => 'application/x-rar-compressed',
            'exe' => 'application/x-msdownload',
            'msi' => 'application/x-msdownload',
            'cab' => 'application/vnd.ms-cab-compressed',

            // audio/video
            'mp3' => 'audio/mpeg',
            'qt' => 'video/quicktime',
            'mov' => 'video/quicktime',

            // adobe
            'pdf' => 'application/pdf',
            'psd' => 'image/vnd.adobe.photoshop',
            'ai' => 'application/postscript',
            'eps' => 'application/postscript',
            'ps' => 'application/postscript',

            // ms office
            'doc' => 'application/msword',
            'rtf' => 'application/rtf',
            'xls' => 'application/vnd.ms-excel',
            'ppt' => 'application/vnd.ms-powerpoint',

            // open office
            'odt' => 'application/vnd.oasis.opendocument.text',
            'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
            );
}
}

/*
    M
    const IMAGE_THUMB_SCALE     =   1 ; //常量，标识缩略图等比例缩放类型
    const IMAGE_THUMB_FILLED    =   2 ; //常量，标识缩略图缩放后填充类型
    const IMAGE_THUMB_CENTER    =   3 ; //常量，标识缩略图居中裁剪类型
    const IMAGE_THUMB_NORTHWEST =   4 ; //常量，标识缩略图左上角裁剪类型
    const IMAGE_THUMB_SOUTHEAST =   5 ; //常量，标识缩略图右下角裁剪类型
    const IMAGE_THUMB_FIXED     =   6 ; //常量，标识缩略图固定尺寸缩放类型
*/

    function thumb($image=null, $width=0, $height=0, $mode=3) {
        if (!$image) {
            $defaults = D('Banner')->getBannerByName('default_thumb');

            if($defaults) {
                $image = $defaults[rand(0,count($defaults)-1)]['path'];
            }
        }
        if(!is_file(C('WWW_ROOT') . $image)) {
            return '';
        }

        $image = '/' . trim($image,'/');

        // gif图片不处理
        if(stripos($image, '.gif')!==false) {
            return $image;
        }

        if(!$width && !$height) {
            return $image;
        }

        if(C('IMAGE_CUT_TYPE')=='image') {
            $mode = 'i';
        }

        $postfix = '-' . $width . '-' . $height . '-' . $mode;

        $result_image = preg_replace('#(\w+)\.(\w+)$#', "\\1$postfix.\\2", $image);

        $result_path = C('WWW_ROOT') . $result_image;

        if(!file_exists($result_path)) {
            if(C('IMAGE_CUT_TYPE')=='image') {
                Org\Util\Image::convert(C('WWW_ROOT') . $image, $result_path, $width,$height);
            } else {
            // support png transparent
                $obj = new \Think\Image(C('WWW_ROOT') . $image);

                $obj->thumb($width,$height,$mode);
                $obj->save($result_path);
            }
        }

        return $result_image;
    }

    function display_tag_string($tags,$simple=1) {
      $stag_id = htmlspecialchars($_GET['stag_id']);

      if($tags) {
        if(!$simple) {
          $str = '<i class="icon-tag"></i>&nbsp;';
      }

      foreach ($tags as $one) {
          $extra_class = '';
          if($stag_id && $stag_id == $one['tag_id']) {
            $extra_class = ' label-important';
        }
        $link = '/home/search?stag_id=' . $one['tag_id'];
        if($simple) {
            $class = "simple-a";
        } else {
            $class = "label";
        }
        $str .= '<a href="'.$link.'" class="' . $class . $extra_class .'">'. $one['name'] .'</a>&nbsp;';
    }
}
return $str;

}

  /**
   * 判断wap访问函数
   */
  function check_wap () {
    if (isset($_SERVER['HTTP_VIA'])) return true;
    if (isset($_SERVER['HTTP_X_NOKIA_CONNECTION_MODE'])) return true;
    if (isset($_SERVER['HTTP_X_UP_CALLING_LINE_ID'])) return true;
    if (strpos(strtoupper($_SERVER['HTTP_ACCEPT']),"VND.WAP.WML") > 0) {
        // Check whether the browser/gateway says it accepts WML.
        $br = "WML";
    } else {
        $browser = isset($_SERVER['HTTP_USER_AGENT']) ? trim($_SERVER['HTTP_USER_AGENT']) : '';
        if(empty($browser)) return true;
        $mobile_os_list=array('Google Wireless Transcoder','Windows CE','WindowsCE','Symbian','Android','armv6l','armv5','Mobile','CentOS','mowser','AvantGo','Opera Mobi','J2ME/MIDP','Smartphone','Go.Web','Palm','iPAQ');
        $mobile_token_list=array('Profile/MIDP','Configuration/CLDC-','160×160','176×220','240×240','240×320','320×240','UP.Browser','UP.Link','SymbianOS','PalmOS','PocketPC','SonyEricsson','Nokia','BlackBerry','Vodafone','BenQ','Novarra-Vision','Iris','NetFront','HTC_','Xda_','SAMSUNG-SGH','Wapaka','DoCoMo','iPhone','iPod');
        $found_mobile=checkSubstrs($mobile_os_list,$browser) || checkSubstrs($mobile_token_list,$browser);
        if($found_mobile){
          $br ="WML";
      }else {$br = "WWW";}
  }
  if($br == "WML") {
    return true;
} else {
    return false;
}
}

function checkSubstrs($list,$str){
 $flag = false;
 for($i=0;$i<count($list);$i++){
  if(strpos($str,$list[$i]) > 0){
   $flag = true;
   break;
}
}
return $flag;
}



function select_option($a=array(), $v=null, $all=null)
{
    $option = null;
    if ( $all ){
        $selected = ($v) ? null : 'selected';
        $option .= "<option value='' $selected>".strip_tags($all)."</option>";
    }

    $v = explode(',', $v);
    settype($v, 'array');

    if(is_list($a)) {
        $a = array_to_map($a);
    }

    foreach( $a AS $key=>$value )
    {
        if (is_array($value)) {
            $key = strval($value['id']);
            $value = strval($value['name']);
        }
        $selected = in_array($key, $v) ? 'selected' : null;
        $option .= "<option value='{$key}' {$selected}>".strip_tags($value)."</option>";
    }

    return $option;
}

//判断PHP数组是否索引数组（列表/向量表）
function is_list($arr) {
    if (!is_array($arr) ) {
        return false;
    } else {
        $keys = array_keys($arr);
        $idx = 0;
        foreach ($keys as $k) {
            if(intval($k) !== $idx++)
              return false;
        }
    }
    return true;
}

function array_to_map($arr) {
    foreach ($arr as $v) {
        $rs[$v] = $v;
    }
    return $rs;
}

function valid_email($email, $strict=false) {
    $regexp = '/^[\w\-\.]+@[\w\-]+(\.[\w\-]+)*(\.[a-z]{2,})$/';
    if ( preg_match($regexp, $email) ){
        if (strstr(strtoupper(PHP_OS),'WIN')) {
            return true;
        }
        list ($user,$domain) = explode('@', $email, 2);
        if ( $strict && !gethostbyname($domain)
                && !getmxrr($domain,$mxhosts) ){
            return false;
        }
        return true;
    }
    return false;
}


function comma_tips($a=array(), $v=null) {
    $cval = array();
    if (is_string($v)) {
        $v = preg_split('/[\s,]+/', $v, -1, PREG_SPLIT_NO_EMPTY);
    }
    settype($v, 'array');
    foreach($a AS $key=>$value) {
        if (in_array($key, $v)) {
            if (is_array($value)) {
                $cval[] = $value['name'];
            } else {
                $cval[] = $value;
            }
        }
    }
    return join(',', $cval);
}

function form_radio_button($a=array(), $v=null, $n='cb') {
    $cbox = null;
    if (is_string($v)) $v = preg_split('/[\s,]+/', $v, -1, PREG_SPLIT_NO_EMPTY);
    settype($v, 'array');
    foreach($a AS $key=>$value) {
        if (is_array($value)) {
            $key = strval($value['id']);
            $value = strval($value['name']);
        }
        $checked = in_array($key, $v) ? 'checked' : null;
        $cbox .= "<li style='float:left; padding:1px 4px; margin:4px 0'><input type='radio' name='{$n}' value='{$key}' {$checked} />&nbsp;{$value}</li>";
    }
    return $cbox;
}

function OptionArray($a=array(), $c1, $c2) {
    if (empty($a)) return array();
    $s1 = get_column($a, $c1);
    $s2 = get_column($a, $c2);

    if ( $s1 && $s2 && count($s1)==count($s2) ) {
        return array_combine($s1, $s2);
    }
    return array();
}

function SortArray($a=array(), $s=array(), $key=null)
{
    if ($key) $a = self::AssColumn($a, $key);
    $ret = array();
    foreach( $s AS $one )
    {
        if ( isset($a[$one]) )
            $ret[$one] = $a[$one];
    }
    return $ret;
}



function get_column($a=array(), $column='id', $null=true, $column2=null)
{
    $ret = array();
    @list($column, $anc) = preg_split('/[\s\-]/',$column,2,PREG_SPLIT_NO_EMPTY);
    foreach( $a AS $one )
    {
        if ( $null || @$one[ $column ] )
            $ret[] = @$one[ $column ].($anc?'-'.@$one[$anc]:'');
    }
    return $ret;
}

/* support 2-level now  2-level将重复键的生成二维数组*/
function ass_column($a=array(), $column='id',$as_array=false)
{
    $two_level = func_num_args() > 2 ? true : false;
    if ( $two_level ) $scolumn = func_get_arg(2);

    $ret = array(); settype($a, 'array');
    if ( false == $two_level )
    {
        foreach( $a AS $one )
        {
            if ( is_array($one) )
                $ret[ @$one[$column] ] = $one;
            else
                $ret[ @$one->$column ] = $one;
        }
    }
    else
    {
        foreach( $a AS $one )
        {
            if (is_array($one)) {
                if ( false==isset( $ret[ @$one[$column] ] ) ) {
                    $ret[ @$one[$column] ] = array();
                }
                if($as_array) {
                    if(!in_array($one[$column], array_keys($ret))){
                        $ret[@$one[$column]][] = $one;
                    }else{
                        $ret[@$one[$column]][] = $one;
                    }
                } else {
                    $ret[ @$one[$column] ][ @$one[$scolumn] ] = $one;
                }
            } else {
                if ( false==isset( $ret[ @$one->$column ] ) )
                    $ret[ @$one->$column ] = array();

                $ret[ @$one->$column ][ @$one->$scolumn ] = $one;
            }
        }
    }
    return $ret;
}

function get_remote_ip($default='127.0.0.1')
{
    $ip_string = $_SERVER['HTTP_CLIENT_IP'].','.$_SERVER['HTTP_X_FORWARDED_FOR'].','.$_SERVER['REMOTE_ADDR'];
    if ( preg_match ("/\d+\.\d+\.\d+\.\d+/", $ip_string, $matches) )
    {
        return $matches[0];
    }
    return $default;
}

function CombineNull($keys=array())
{
    $ret = array();
    foreach( $keys AS $one )
    {
        $ret[$one] = null;
    }
    return $ret;
}

function ExtraEncode($extra=array())
{
    return base64_encode(json_encode($extra));
}

function ExtraDecode($extra=null)
{
    return json_decode(base64_decode($extra), true);
}

function GetPageNo($page='page')
{
    $page_no = isset($_GET['page'])
        ?  abs(intval($_GET['page'])) : 1;
    return $page_no > 0 ? $page_no : 1;
}

function HumanTime($time=null, $forceDate=false)
{
    $now = time();
    $time = is_numeric($time) ? $time : strtotime($time);

    $interval = $now - $time;

    if ( $forceDate || $interval > 30*86400 ){
        return strftime("%Y-%m-%d %a %H:%M",$time);
    }else if ( $interval > 86400 ){
        $number = intval($interval/86400);
        return "${number}天前";
    }else if ( $interval > 3600 ){ // > 1 hour
        $number = intval($interval/3600);
        return "${number}小时前";
    }else if ( $interval >= 60 ){ // > 1 min
        $number = intval($interval/60);
        return "${number}分钟前";
    }else if ( 5 >= $interval){// < 5 second
        return "就在刚才";
    }else{ // < 1 min
        return "${interval}秒前";
    }
}

function get_week_date() {
    $w = array('日','一','二','三','四','五','六');
    return $now = array(
            'date' => date('Y年m月d日'),
            'week' => '星期'.$w[ date('w')]
            );
}

function GetMessagePic($message) {
    $pic = '';
    $p = "#([^\s]{25,105})\.(jpg|gif|png)#i";
    if ( preg_match($p, $message, $mathes) ) {
        $pic = "{$mathes[1]}.{$mathes[2]}";
        $pic_s = explode('=', $pic);
        $pic = count($pic_s)>1 ? $pic_s[1]:$pic;
        $pic = trim(trim($pic),'\'"');
    }
    return $pic;
}


function Getcsv($s, $split=' ') {
    $r = array();
    while( $s ) {
        $qp1 = mb_strpos($s, '"');
        $p0 = mb_strpos($s, $split);
        $p1 = mb_strpos($s, "\t");
        $p = false;

        if ( $p0!==FALSE && $p1 !==FALSE ) {
            $p = min($p0, $p1);
        } else if ( $p0 !== FALSE ) {
            $p = $p0;
        } else if ( $p1 !== FALSE ) {
            $p = $p1;
        }

        $qp2 = false;
        if ( $qp1===0 ) {
            $qp2 = mb_strpos($s, '"', 1);
        }

        if ( $qp2 !== FALSE ) {
            $m = mb_substr($s, 0, $qp2);
            $m = trim($m, '"');
            $s = trim(trim(mb_substr($s, $qp2+1)),"\t");
        } else if ($p !== FALSE ){
            $m = mb_substr($s, 0, $p);
            $s = trim(mb_substr($s, $p+1));
        } else {
            $m = $s;
            $s = null;
        }
        $r[] = $m;
    }
    return $r;
}

function GetKeyValue($string=null)
{
    $csv = Utility::GetCsv($string);
    $kv = array();
    foreach( $csv AS $one ) {
        @list($name, $v) = explode('=', $one, 2);
        if ( $v === null ) $v = true;
        $kv[ strtolower($name) ] = trim($v,'" ');
    }
    return $kv;
}

const CHAR_MIX = 0;
const CHAR_NUM = 1;
const CHAR_WORD = 2;
function GenSecret($len=6, $type=CHAR_WORD)
{
    $secret = '';
    for ($i = 0; $i < $len;  $i++) {
        if ( CHAR_NUM==$type ){
            if (0==$i) {
                $secret .= chr(rand(49, 57));
            } else {
                $secret .= chr(rand(48, 57));
            }
        }else if ( CHAR_WORD==$type ){
            $secret .= chr(rand(65, 90));
        }else{
            if ( 0==$i ){
                $secret .= chr(rand(65, 90));
            } else {
                $secret .= (0==rand(0,1))?chr(rand(65, 90)):chr(rand(48,57));
            }
        }
    }
    return $secret;
}

function get_random($a=array()) {
    $tv = 0;
    foreach($a as $k=>$v) {
        if ($v<0) { $a[$k] = $v = 0; }
        $tv += $v;
    }
    if ( $tv == 0 ) return 0;
    $im = (float) 10000/$tv;
    $r = rand(0,10000);
    $tv = 0;
    foreach($a AS $k=>$v) {
        $tv += ($v*$im);
        if ( ceil($tv) >= $r )
            return $k;
    }
    return $k;
}

function GetHttpContent($fsock=null) {
    $out = null;
    while($buff = @fgets($fsock, 2048)){
        $out .= $buff;
    }
    fclose($fsock);
    $pos = strpos($out, "\r\n\r\n");
    $head = substr($out, 0, $pos);    //http head
    $status = substr($head, 0, strpos($head, "\r\n"));    //http status line
    $body = substr($out, $pos + 4, strlen($out) - ($pos + 4));//page body
    if(preg_match("/^HTTP\/\d\.\d\s([\d]+)\s.*$/", $status, $matches)){
        if(intval($matches[1]) / 100 == 2){
            return $body;
        }else{
            return false;
        }
    }else{
        return false;
    }
}

function DoGet($url){
    $url2 = parse_url($url);
    $url2["path"] = ($url2["path"] == "" ? "/" : $url2["path"]);
    $url2["port"] = ($url2["port"] == "" ? 80 : $url2["port"]);
    $host_ip = @gethostbyname($url2["host"]);
    $fsock_timeout = 2;  //2 second
    if(($fsock = fsockopen($host_ip, $url2['port'], $errno, $errstr, $fsock_timeout)) < 0){
        return false;
    }
    $request =  $url2["path"] .($url2["query"] ? "?".$url2["query"] : "");
    $in  = "GET " . $request . " HTTP/1.0\r\n";
    $in .= "Accept: */*\r\n";
    $in .= "User-Agent: Payb-Agent\r\n";
    $in .= "Host: " . $url2["host"] . "\r\n";
    $in .= "Connection: Close\r\n\r\n";
    if(!@fwrite($fsock, $in, strlen($in))){
        fclose($fsock);
        return false;
    }
    return GetHttpContent($fsock);
}

function DoPost($url,$post_data=array()){
    $url2 = parse_url($url);
    $url2["path"] = ($url2["path"] == "" ? "/" : $url2["path"]);
    $url2["port"] = ($url2["port"] == "" ? 80 : $url2["port"]);
    $host_ip = @gethostbyname($url2["host"]);
    $fsock_timeout = 2; //2 second
    if(($fsock = fsockopen($host_ip, $url2['port'], $errno, $errstr, $fsock_timeout)) < 0){
        return false;
    }
    $request =  $url2["path"].($url2["query"] ? "?" . $url2["query"] : "");
    $post_data2 = http_build_query($post_data);
    $in  = "POST " . $request . " HTTP/1.0\r\n";
    $in .= "Accept: */*\r\n";
    $in .= "Host: " . $url2["host"] . "\r\n";
    $in .= "User-Agent: Lowell-Agent\r\n";
    $in .= "Content-type: application/x-www-form-urlencoded\r\n";
    $in .= "Content-Length: " . strlen($post_data2) . "\r\n";
    $in .= "Connection: Close\r\n\r\n";
    $in .= $post_data2 . "\r\n\r\n";
    unset($post_data2);
    if(!@fwrite($fsock, $in, strlen($in))){
        fclose($fsock);
        return false;
    }
    return GetHttpContent($fsock);
}

function HttpRequest($url, $data=array(), $abort=false) {
    if ( !function_exists('curl_init') ) { return empty($data) ? DoGet($url) : DoPost($url, $data); }
    $timeout = $abort ? 1 : 2;
    $ch = curl_init();
    if (is_array($data) && $data) {
        $formdata = http_build_query($data);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $formdata);
    }
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
    $result = curl_exec($ch);
    return (false===$result && false==$abort)? ( empty($data) ? DoGet($url) : DoPost($url, $data) ) : $result;
}

function is_mobile($no) {
    return preg_match('/^1[\d]{10}$/', $no)
        || preg_match('/^0[\d]{10,11}$/', $no);
}

function check_captcha($code){
    return Think\PhpCaptcha::Validate($code);
}


function gen_password($p) {
    $SECRET_KEY = '2@0!1@2#1$0%1@0&';
    return md5($p . $SECRET_KEY);
}

/**
 * 汉字转换成拼音函数，第二个参数随意给就用utf-8编码
 */
function change_to_pinyin($_String, $_Code='gb2312') {
    $_DataKey = "a|ai|an|ang|ao|ba|bai|ban|bang|bao|bei|ben|beng|bi|bian|biao|bie|bin|bing|bo|bu|ca|cai|can|cang|cao|ce|ceng|cha".
    "|chai|chan|chang|chao|che|chen|cheng|chi|chong|chou|chu|chuai|chuan|chuang|chui|chun|chuo|ci|cong|cou|cu|".
    "cuan|cui|cun|cuo|da|dai|dan|dang|dao|de|deng|di|dian|diao|die|ding|diu|dong|dou|du|duan|dui|dun|duo|e|en|er".
    "|fa|fan|fang|fei|fen|feng|fo|fou|fu|ga|gai|gan|gang|gao|ge|gei|gen|geng|gong|gou|gu|gua|guai|guan|guang|gui".
    "|gun|guo|ha|hai|han|hang|hao|he|hei|hen|heng|hong|hou|hu|hua|huai|huan|huang|hui|hun|huo|ji|jia|jian|jiang".
    "|jiao|jie|jin|jing|jiong|jiu|ju|juan|jue|jun|ka|kai|kan|kang|kao|ke|ken|keng|kong|kou|ku|kua|kuai|kuan|kuang".
    "|kui|kun|kuo|la|lai|lan|lang|lao|le|lei|leng|li|lia|lian|liang|liao|lie|lin|ling|liu|long|lou|lu|lv|luan|lue".
    "|lun|luo|ma|mai|man|mang|mao|me|mei|men|meng|mi|mian|miao|mie|min|ming|miu|mo|mou|mu|na|nai|nan|nang|nao|ne".
    "|nei|nen|neng|ni|nian|niang|niao|nie|nin|ning|niu|nong|nu|nv|nuan|nue|nuo|o|ou|pa|pai|pan|pang|pao|pei|pen".
    "|peng|pi|pian|piao|pie|pin|ping|po|pu|qi|qia|qian|qiang|qiao|qie|qin|qing|qiong|qiu|qu|quan|que|qun|ran|rang".
    "|rao|re|ren|reng|ri|rong|rou|ru|ruan|rui|run|ruo|sa|sai|san|sang|sao|se|sen|seng|sha|shai|shan|shang|shao|".
    "she|shen|sheng|shi|shou|shu|shua|shuai|shuan|shuang|shui|shun|shuo|si|song|sou|su|suan|sui|sun|suo|ta|tai|".
    "tan|tang|tao|te|teng|ti|tian|tiao|tie|ting|tong|tou|tu|tuan|tui|tun|tuo|wa|wai|wan|wang|wei|wen|weng|wo|wu".
    "|xi|xia|xian|xiang|xiao|xie|xin|xing|xiong|xiu|xu|xuan|xue|xun|ya|yan|yang|yao|ye|yi|yin|ying|yo|yong|you".
    "|yu|yuan|yue|yun|za|zai|zan|zang|zao|ze|zei|zen|zeng|zha|zhai|zhan|zhang|zhao|zhe|zhen|zheng|zhi|zhong|".
    "zhou|zhu|zhua|zhuai|zhuan|zhuang|zhui|zhun|zhuo|zi|zong|zou|zu|zuan|zui|zun|zuo";
    $_DataValue = "-20319|-20317|-20304|-20295|-20292|-20283|-20265|-20257|-20242|-20230|-20051|-20036|-20032|-20026|-20002|-19990".
    "|-19986|-19982|-19976|-19805|-19784|-19775|-19774|-19763|-19756|-19751|-19746|-19741|-19739|-19728|-19725".
    "|-19715|-19540|-19531|-19525|-19515|-19500|-19484|-19479|-19467|-19289|-19288|-19281|-19275|-19270|-19263".
    "|-19261|-19249|-19243|-19242|-19238|-19235|-19227|-19224|-19218|-19212|-19038|-19023|-19018|-19006|-19003".
    "|-18996|-18977|-18961|-18952|-18783|-18774|-18773|-18763|-18756|-18741|-18735|-18731|-18722|-18710|-18697".
    "|-18696|-18526|-18518|-18501|-18490|-18478|-18463|-18448|-18447|-18446|-18239|-18237|-18231|-18220|-18211".
    "|-18201|-18184|-18183|-18181|-18012|-17997|-17988|-17970|-17964|-17961|-17950|-17947|-17931|-17928|-17922".
    "|-17759|-17752|-17733|-17730|-17721|-17703|-17701|-17697|-17692|-17683|-17676|-17496|-17487|-17482|-17468".
    "|-17454|-17433|-17427|-17417|-17202|-17185|-16983|-16970|-16942|-16915|-16733|-16708|-16706|-16689|-16664".
    "|-16657|-16647|-16474|-16470|-16465|-16459|-16452|-16448|-16433|-16429|-16427|-16423|-16419|-16412|-16407".
    "|-16403|-16401|-16393|-16220|-16216|-16212|-16205|-16202|-16187|-16180|-16171|-16169|-16158|-16155|-15959".
    "|-15958|-15944|-15933|-15920|-15915|-15903|-15889|-15878|-15707|-15701|-15681|-15667|-15661|-15659|-15652".
    "|-15640|-15631|-15625|-15454|-15448|-15436|-15435|-15419|-15416|-15408|-15394|-15385|-15377|-15375|-15369".
    "|-15363|-15362|-15183|-15180|-15165|-15158|-15153|-15150|-15149|-15144|-15143|-15141|-15140|-15139|-15128".
    "|-15121|-15119|-15117|-15110|-15109|-14941|-14937|-14933|-14930|-14929|-14928|-14926|-14922|-14921|-14914".
    "|-14908|-14902|-14894|-14889|-14882|-14873|-14871|-14857|-14678|-14674|-14670|-14668|-14663|-14654|-14645".
    "|-14630|-14594|-14429|-14407|-14399|-14384|-14379|-14368|-14355|-14353|-14345|-14170|-14159|-14151|-14149".
    "|-14145|-14140|-14137|-14135|-14125|-14123|-14122|-14112|-14109|-14099|-14097|-14094|-14092|-14090|-14087".
    "|-14083|-13917|-13914|-13910|-13907|-13906|-13905|-13896|-13894|-13878|-13870|-13859|-13847|-13831|-13658".
    "|-13611|-13601|-13406|-13404|-13400|-13398|-13395|-13391|-13387|-13383|-13367|-13359|-13356|-13343|-13340".
    "|-13329|-13326|-13318|-13147|-13138|-13120|-13107|-13096|-13095|-13091|-13076|-13068|-13063|-13060|-12888".
    "|-12875|-12871|-12860|-12858|-12852|-12849|-12838|-12831|-12829|-12812|-12802|-12607|-12597|-12594|-12585".
    "|-12556|-12359|-12346|-12320|-12300|-12120|-12099|-12089|-12074|-12067|-12058|-12039|-11867|-11861|-11847".
    "|-11831|-11798|-11781|-11604|-11589|-11536|-11358|-11340|-11339|-11324|-11303|-11097|-11077|-11067|-11055".
    "|-11052|-11045|-11041|-11038|-11024|-11020|-11019|-11018|-11014|-10838|-10832|-10815|-10800|-10790|-10780".
    "|-10764|-10587|-10544|-10533|-10519|-10331|-10329|-10328|-10322|-10315|-10309|-10307|-10296|-10281|-10274".
    "|-10270|-10262|-10260|-10256|-10254";
    $_TDataKey = explode('|', $_DataKey);
    $_TDataValue = explode('|', $_DataValue);
    $_Data = (PHP_VERSION>='5.0') ? array_combine($_TDataKey, $_TDataValue) : _Array_Combine($_TDataKey, $_TDataValue);
    arsort($_Data);
    reset($_Data);
    if($_Code != 'gb2312') $_String = _U2_Utf8_Gb($_String);
    $_Res = '';
    for($i=0; $i<strlen($_String); $i++){
        $_P = ord(substr($_String, $i, 1));
        if($_P>160) {
            $_Q = ord(substr($_String, ++$i, 1)); $_P = $_P*256 + $_Q - 65536;
        }
        $_Res .= _Pinyin($_P, $_Data);
    }
    return preg_replace("/[^a-z0-9]*/", '', $_Res);
}
function _Pinyin($_Num, $_Data) {
    if ($_Num>0 && $_Num<160 ) return chr($_Num);
    elseif($_Num<-20319 || $_Num>-10247) return '';
    else {
        foreach($_Data as $k=>$v){ if($v<=$_Num) break; }
        return $k;
    }
}
function _U2_Utf8_Gb($_C) {
    $_String = '';
    if($_C < 0x80) $_String .= $_C;
    elseif($_C < 0x800)
    {
        $_String .= chr(0xC0 | $_C>>6);
        $_String .= chr(0x80 | $_C & 0x3F);
    }elseif($_C < 0x10000){
        $_String .= chr(0xE0 | $_C>>12);
        $_String .= chr(0x80 | $_C>>6 & 0x3F);
        $_String .= chr(0x80 | $_C & 0x3F);
    } elseif($_C < 0x200000) {
        $_String .= chr(0xF0 | $_C>>18);
        $_String .= chr(0x80 | $_C>>12 & 0x3F);
        $_String .= chr(0x80 | $_C>>6 & 0x3F);
        $_String .= chr(0x80 | $_C & 0x3F);
    }
    return iconv('UTF-8', 'GB2312', $_String);
}
function _Array_Combine($_Arr1, $_Arr2)
{
    for($i=0; $i<count($_Arr1); $i++) $_Res[$_Arr1[$i]] = $_Arr2[$i];
        return $_Res;
}

//图片加水印
function setWater($imgSrc,$markImg,$markText,$TextColor,$markPos,$fontType,$markType)
{

    $srcInfo = @getimagesize($imgSrc);
    $srcImg_w    = $srcInfo[0];
    $srcImg_h    = $srcInfo[1];

    switch ($srcInfo[2])
    {
        case 1:
            $srcim =imagecreatefromgif($imgSrc);
            break;
        case 2:
            $srcim =imagecreatefromjpeg($imgSrc);
            break;
        case 3:
            $srcim =imagecreatefrompng($imgSrc);
            break;
        default:
            die("不支持的图片文件类型");
            exit;
    }

    if(!strcmp($markType,"img"))
    {
        if(!file_exists($markImg) || empty($markImg))
        {
            return;
        }

        $markImgInfo = @getimagesize($markImg);
        $markImg_w    = $markImgInfo[0];
        $markImg_h    = $markImgInfo[1];

        if($srcImg_w < $markImg_w || $srcImg_h < $markImg_h)
        {
            return;
        }

        switch ($markImgInfo[2])
        {
            case 1:
                $markim =imagecreatefromgif($markImg);
                break;
            case 2:
                $markim =imagecreatefromjpeg($markImg);
                break;
            case 3:
                $markim =imagecreatefrompng($markImg);
                break;
            default:
                die("不支持的水印图片文件类型");
                exit;
        }

        $logow = $markImg_w;
        $logoh = $markImg_h;
    }

    if(!strcmp($markType,"text"))
    {
        $fontSize = 16;
        if(!empty($markText))
        {
            if(!file_exists($fontType))
            {
                return;
            }
        }
        else {
            return;
        }

        $box = @imagettfbbox($fontSize, 0, $fontType,$markText);
        $logow = max($box[2], $box[4]) - min($box[0], $box[6]);
        $logoh = max($box[1], $box[3]) - min($box[5], $box[7]);
    }

    if($markPos == 0)
    {
        $markPos = rand(1, 9);
    }

    switch($markPos)
    {
        case 1:
            $x = +5;
            $y = +5;
            break;
        case 2:
            $x = ($srcImg_w - $logow) / 2;
            $y = +5;
            break;
        case 3:
            $x = $srcImg_w - $logow - 5;
            $y = +15;
            break;
        case 4:
            $x = +5;
            $y = ($srcImg_h - $logoh) / 2;
            break;
        case 5:
            $x = ($srcImg_w - $logow) / 2;
            $y = ($srcImg_h - $logoh) / 2;
            break;
        case 6:
            $x = $srcImg_w - $logow - 5;
            $y = ($srcImg_h - $logoh) / 2;
            break;
        case 7:
            $x = +5;
            $y = $srcImg_h - $logoh - 5;
            break;
        case 8:
            $x = ($srcImg_w - $logow) / 2;
            $y = $srcImg_h - $logoh - 5;
            break;
        case 9:
            $x = $srcImg_w - $logow - 5;
            $y = $srcImg_h - $logoh -5;
            break;
        default:
            die("此位置不支持");
            exit;
    }

    $dst_img = @imagecreatetruecolor($srcImg_w, $srcImg_h);

    imagecopy ( $dst_img, $srcim, 0, 0, 0, 0, $srcImg_w, $srcImg_h);

    if(!strcmp($markType,"img"))
    {
        imagecopy($dst_img, $markim, $x, $y, 0, 0, $logow, $logoh);
        imagedestroy($markim);
    }

    if(!strcmp($markType,"text"))
    {
        $rgb = explode(',', $TextColor);

        $color = imagecolorallocate($dst_img, $rgb[0], $rgb[1], $rgb[2]);
        imagettftext($dst_img, $fontSize, 0, $x, $y, $color, $fontType,$markText);
    }

    switch ($srcInfo[2])
    {
        case 1:
            imagegif($dst_img, $imgSrc);
            break;
        case 2:
            imagejpeg($dst_img, $imgSrc);
            break;
        case 3:
            imagepng($dst_img, $imgSrc);
            break;
        default:
            die("不支持的水印图片文件类型");
            exit;
    }

    imagedestroy($dst_img);
    imagedestroy($srcim);
}

function upload_image($input, $image=null, $type='page', $force=false) {
  $year = date('Y'); $day = date('md'); $n = time().rand(1000,9999).'.jpg';
  $img_root = str_replace('\\','/',getcwd()) .'Uploads/';
  $z = $_FILES[$input];
  if ($z && strpos($z['type'], 'image')===0 && $z['error']==0) {
    if (!$image) {
      // RecursiveMkdir( $img_root . '/' . "{$type}/{$year}/{$day}" );
      $image = "{$type}/{$year}/{$day}/{$n}";
      $path = $img_root . '/' . $image;
    } else {
      // RecursiveMkdir( dirname($img_root .'/' .$image) );
      $path = $img_root . '/' .$image;

      $postfixs = array_keys(get_image_size_map());
      foreach ($postfixs as $fix) {
        $index_image = preg_replace('#(\w+)\.(\w+)$#', "\\1_$fix.\\2", $path);
        unlink($index_image);
      }
    }

    move_uploaded_file($z['tmp_name'], $path);

    return $image;
  }
  return $image;
}

// that the recursive feature on mkdir() is broken with PHP 5.0.4 for
function RecursiveMkdir($path) {
  if (!file_exists($path)) {
    RecursiveMkdir(dirname($path));
    @mkdir($path, 0777);
  }
}


// 主要后台用的 ， 生成当前栏目的所有的子栏目
function content_category_select($cats, $result, $indent, $current_id, $for_edit=false) {
    if(!$indent) $indent = 0;
    foreach ($cats as $value) {
        // if(!$for_edit && $value['type']==4) {       // 单篇文章，只有在category编辑时候显示
        //     continue;
        // }
        $cid = $value['id'];
        $pid = $value['pid'];
        if($cid==$current_id) {
            $active = 'active';
        } else {
            $active = '';
        }
        if($value['type'] == 1){
            $is_menu = "is_menu";
        }else {
            $is_menu ='';
        }
        if($value['_']) {
            if($for_edit) {
            $result .= <<<str
        <div class="pl{$indent} {$active} {$is_menu}" id="{$cid}" pid="{$pid}" onclick="select_category({$cid})">
            <i class="fa fa-caret-right"></i>&nbsp;{$value['title']}
        </div>
str;
            }  else {

            $result .= <<<str
        <div class="text-muted pl{$indent} {$is_menu}" id="{$cid}" pid="{$pid}" >
            <i class="fa fa-caret-right"></i>&nbsp;{$value['title']}
        </div>
str;
            }
            $result = content_category_select($value['_'], $result, $indent+1, $current_id, $for_edit);
        } else {
            if($cid == $current_id) {
                $i_class = 'fa fa-circle';
            } else {
                $i_class = 'fa fa-circle-o';
            }

            $result .= <<<str
        <div class="pl{$indent} {$active} {$is_menu}" id="{$cid}" pid="{$pid}" onclick="select_category({$cid}, '{$value['title']}')">
            <i class="{$i_class}"></i>&nbsp;{$value['title']}
        </div>
str;
        }
    }
    return $result;
}


function form_image_upload($name, $value, $placeholder) {
    $html .= '<input type="hidden" name="'.$name.'" id="image_upload_value_'.$name.'" value="'.$value.'"/>';
    $html .= '<input type="file" class="image_uploadify" id="image_upload_'.$name.'" data-image-val="'.$name.'" value="' . $name .'"/>';
    if($placeholder) {
        $html .= '<div class="text-muted">'.$placeholder.'</div>';
    }
    if($value) {
        $preview_part = '<div id="image_display_'.$name.'"><a href="'. $value .'" data-toggle="lightbox-image"><img style="max-width:200px" src="' . $value . '"/></a>';
        $preview_part .= '&nbsp;<a href="javascript:void(0);" onclick="$(\'#image_display_'.$name.'\').remove();$(\'#image_upload_value_'.$name.'\').val(\'\');">&times;删除</a></div>';
    }
    $html .= '<div id="image_upload_preview_'.$name.'">'.$preview_part.'</div>';

    return $html;
}


function json($data, $type='eval') {
    $type = strtolower($type);
    $allow = array('eval','alert','updater','dialog','mix', 'refresh', 'replacer', 'redirect');

    if (false==in_array($type, $allow))
        return false;

    $result['data'] = array( 'data' => $data, 'type' => $type);
    die( json_encode($result));
}


function format_url($str) {
    $str = trim($str);
    if($str && (strpos($str, 'http://')!==0 && strpos($str, 'https://')!==0 )) {
        $str = 'http://' . $str;
    }
    return $str;
}

function strlen_utf8($str) {
    $i = 0;
    $count = 0;
    $len = strlen ($str);
    while ($i < $len) {
        $chr = ord ($str[$i]);
        $count++;
        $i++;
        if($i >= $len) break;
        if($chr & 0x80) {
            $chr <<= 1;
            while ($chr & 0x80) {
                $i++;
                $chr <<= 1;
            }
        }
    }
    return $count;
}


function objectToArray($object) {
    if( count($object)==0 ) {
      if(is_array($object)){
        return array();
      }else{
        return trim((string)$object);
      }
    }
    $result = array();
    $object = is_object($object) ? get_object_vars($object) : $object;
    foreach ($object as $key => $val) {
        $val = (is_object($val) || is_array($val)) ? objectToArray($val) : $val;
        $result[$key] = $val;
    }
    return $result;
}