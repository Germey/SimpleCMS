<?php

/**
 * 系统配文件
 * 所有系统级别的配置
 */

// 通过子域名访问不同的主题
$domain_theme = trim(substr(trim($_SERVER['HTTP_HOST']), 0, strpos($_SERVER['HTTP_HOST'],'.')),'.');
return array(

    'WWW_ROOT' => dirname(dirname(dirname(str_replace('\\','/',dirname(__FILE__))))),

    'AUTOLOAD_NAMESPACE' => array('Addons' => ONETHINK_ADDON_PATH), //扩展模块列表
    'MODULE_DENY_LIST'   => array('Common','User','Install'),
    'MODULE_ALLOW_LIST'  => array('Home','Manage', 'Weixin'),
    'DEFAULT_MODULE'     => 'Home',

    /* 系统数据加密设置 */
    'DATA_AUTH_KEY' => 'H5*?O;b=M)gRutl0xG(,[zP+1s&_~@c{]TD:IpK!',
    'IMAGE_CUT_TYPE' =>  'image',

    // 'COMMON_SHOW_PAGE_TRACE' => true,

    /* 用户相关设置 */
    'USER_MAX_CACHE'     => 1000, //最大缓存用户数
    'USER_ADMINISTRATOR' => 1, //管理员用户ID

    /* URL配置 */
    'URL_CASE_INSENSITIVE' => true, //默认false 表示URL区分大小写 true则表示不区分大小写
    'URL_MODEL'            => 2, //URL模式
    'VAR_URL_PARAMS'       => '', // PATHINFO URL参数变量
    'URL_PATHINFO_DEPR'    => '/', //PATHINFO URL分割符

    /* 全局过滤配置 */
    'DEFAULT_FILTER' => '', //全局过滤函数

    /*默认错误跳转对应的模板文件*/
    'TMPL_ACTION_ERROR' => 'public:error',

    'LOAD_EXT_CONFIG' => $domain_theme,

    /*定义了一个栏目的显示地址*/
    'CATEGORY_LINK' => '/category/',

    /*数据库备份保存路径*/
    'DATA_BACKUP_PATH' => './Data/',

    'ENABLE_CACHE'     => false,    // 缓存开关
    );
