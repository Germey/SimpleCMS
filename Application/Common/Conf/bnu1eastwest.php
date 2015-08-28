<?php

    return array(

        'DB_TYPE'   => 'mysqli',
        'DB_HOST'   => 'localhost',
        'DB_NAME'   => 'bnu1eastwest',
        'DB_USER'   => 'root',
        'DB_PWD'    => '123456',
        'DB_PORT'   => '3306',
        'DB_PREFIX' => 'jxdrcms_',

        /* 主题设置 */
        'DEFAULT_THEME' =>  'bnu1eastwest',  // 默认模板主题名称

        /* 图片切割类型，默认为空，用GD库
            image: 是传统的covert方法，图片压缩率小，但是比较清晰*/
        'IMAGE_CUT_TYPE' =>  'image',

        'DEFAULT_CONTENT_SORT'  => 'publish_time desc',

        /* 模板相关配置 */
        'TMPL_PARSE_STRING' => array(
            '__STATIC__' => __ROOT__ . '/Public/Static',
            '__ADDONS__' => __ROOT__ . '/Public/Home/Addons',
            '__IMG__'    => __ROOT__ . '/Application/Home/View/bnu1eastwest/styles/css/images',
            '__CSS__'    => __ROOT__ . '/Application/Home/View/bnu1eastwest/styles/css',
            '__JS__'     => __ROOT__ . '/Application/Home/View/bnu1eastwest/styles/js',
        ),

    );