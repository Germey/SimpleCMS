<?php

/**
 * 前台配置文件
 * 所有除开系统级别的前台配置
 */
return array(

    // 预先加载的标签库
    'TAGLIB_PRE_LOAD'     =>    'OT\\TagLib\\Article,OT\\TagLib\\Think,OT\\TagLib\\Category',


    /* 数据缓存设置 */
    'DATA_CACHE_PREFIX' => 'jxdrcms_', // 缓存前缀
    'DATA_CACHE_TYPE'   => 'File', // 数据缓存类型

    /* 文件上传相关配置 */
    'DOWNLOAD_UPLOAD' => array(
        'mimes'    => '', //允许上传的文件MiMe类型
        'maxSize'  => 5*1024*1024, //上传的文件大小限制 (0-不做限制)
        'exts'     => 'jpg,gif,png,jpeg,zip,rar,tar,gz,7z,doc,docx,txt,xml,pdf,xls,xlsx,ppt,pptx', //允许上传的文件后缀
        'autoSub'  => true, //自动子目录保存文件
        'subName'  => array('date', 'Y-m-d'), //子目录创建方式，[0]-函数名，[1]-参数，多个参数使用数组
        'rootPath' => './Uploads/file/', //保存根路径
        'savePath' => '', //保存路径
        'saveName' => array('uniqid', ''), //上传文件命名规则，[0]-函数名，[1]-参数，多个参数使用数组
        'saveExt'  => '', //文件保存后缀，空则使用原后缀
        'replace'  => false, //存在同名是否覆盖
        'hash'     => true, //是否生成hash编码
        'callback' => false, //检测文件是否存在回调函数，如果存在返回文件信息数组
    ), //下载模型上传配置（文件上传类配置）

    /* 图片上传相关配置 */
    'PICTURE_UPLOAD' => array(
        'mimes'    => '', //允许上传的文件MiMe类型
        'maxSize'  => 2*1024*1024, //上传的文件大小限制 (0-不做限制)
        'exts'     => 'jpg,gif,png,jpeg', //允许上传的文件后缀
        'autoSub'  => true, //自动子目录保存文件
        'subName'  => array('date', 'Ymd'), //子目录创建方式，[0]-函数名，[1]-参数，多个参数使用数组
        'rootPath' => './Uploads/picture/', //保存根路径
        'savePath' => '', //保存路径
        'saveName' => array('uniqid', ''), //上传文件命名规则，[0]-函数名，[1]-参数，多个参数使用数组
        'saveExt'  => '', //文件保存后缀，空则使用原后缀
        'replace'  => false, //存在同名是否覆盖
        'hash'     => true, //是否生成hash编码
        'callback' => false, //检测文件是否存在回调函数，如果存在返回文件信息数组
    ), //图片上传相关配置（文件上传类配置）

    /* SESSION 和 COOKIE 配置 */
    'SESSION_PREFIX' => 'jxdrcms_home', //session前缀
    'COOKIE_PREFIX'  => 'jxdrcms_home_', // Cookie前缀 避免冲突

    /**
     * 附件相关配置
     * 附件是规划在插件中的，所以附件的配置暂时写到这里
     * 后期会移动到数据库进行管理
     */
    'ATTACHMENT_DEFAULT' => array(
        'is_upload'     => true,
        'allow_type'    => '0,1,2', //允许的附件类型 (0-目录，1-外链，2-文件)
        'driver'        => 'Local', //上传驱动
        'driver_config' => null, //驱动配置
    ), //附件默认配置

    'ATTACHMENT_UPLOAD' => array(
        'mimes'    => '', //允许上传的文件MiMe类型
        'maxSize'  => 5*1024*1024, //上传的文件大小限制 (0-不做限制)
        'exts'     => 'jpg,gif,png,jpeg,zip,rar,tar,gz,7z,doc,docx,txt,xml', //允许上传的文件后缀
        'autoSub'  => true, //自动子目录保存文件
        'subName'  => array('date', 'Y-m-d'), //子目录创建方式，[0]-函数名，[1]-参数，多个参数使用数组
        'rootPath' => './Uploads/Attachment/', //保存根路径
        'savePath' => '', //保存路径
        'saveName' => array('uniqid', ''), //上传文件命名规则，[0]-函数名，[1]-参数，多个参数使用数组
        'saveExt'  => '', //文件保存后缀，空则使用原后缀
        'replace'  => false, //存在同名是否覆盖
        'hash'     => true, //是否生成hash编码
        'callback' => false, //检测文件是否存在回调函数，如果存在返回文件信息数组
    ), //附件上传配置（文件上传类配置）


    'URL_ROUTER_ON'   => true, //开启路由
    'URL_ROUTE_RULES' => array( //定义路由规则
        'content/edit'  => 'Home/content/edit',
        'content/save'  => 'Home/content/save',
        
        'content/ajax_dialog_map_position'  => 'Home/content/ajax_dialog_map_position',
        'content/get_contents_by_userid/:id'  => 'Home/content/get_contents_by_userid',
        'dashboard/edit_content'  => 'Home/dashboard/edit_content',
        'dashboard/del_content/:id'  => 'Home/dashboard/del_content',
        'user/register'  => 'Home/user/register',
        'content/render_get_content'  => 'Home/content/render_get_content',
        'content/ajax_get_contents'  => 'Home/content/ajax_get_contents',
        'content/lists'  => 'Home/content/lists',
        'category/:id' => 'Home/category/type',
        'content/:id'  => 'Home/content/detail',
        '404' => 'Common/Common/page_not_found',
    ),

    // 开启静态缓存 - Prod以后再开启
    'HTML_CACHE_ON'     =>    false,
    'HTML_CACHE_TIME'   =>    60,   // 全局静态缓存有效期（秒）
    'HTML_CACHE_RULES'  =>     array(

        // 修改的时候删除缓存
        'content:detail'=>array('content{id}','86400', 'md5'),
        // 'category:type'=>array('category{id}','3600', 'md5'),
    ),
    'LANG_SWITCH_ON'     =>     true,    //开启语言包功能       
    'LANG_AUTO_DETECT'     =>     true, // 自动侦测语言
    'DEFAULT_LANG'         =>     'zh-cn', // 默认语言       
    'LANG_LIST'            =>    'en-us,zh-cn', //必须写可允许的语言列表
    'VAR_LANGUAGE'     => 'l', // 默认语言切换变量
);
