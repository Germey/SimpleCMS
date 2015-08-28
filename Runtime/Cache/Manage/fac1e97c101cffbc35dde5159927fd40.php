<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->

<head>
    <meta charset="utf-8">

    <title>内容管理后台</title>
    <meta name="author" content="Justering">
    <meta name="robots" content="noindex, nofollow">
    <meta name="description" content="Justeirng CMS">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1.0">

    <!-- Stylesheets -->
    <!-- Bootstrap is included in its original form, unaltered -->
    <link rel="stylesheet" type="text/css" href="/Public/Static/bootstrap/css/bootstrap3.1.1.min.css" />
    <!-- Related styles of various icon packs and plugins -->
    <link rel="stylesheet" type="text/css" href="/Public/Static/proui/css/magnific-popup.css" />
    <link rel="stylesheet" type="text/css" href="/Public/Static/proui/css/plugins.css" />

    <link rel="stylesheet" type="text/css" href="/Public/Static/proui/css/main.css" />

    <!-- <link id="theme-link" rel="stylesheet" href="/Public/Static/proui/css/themes/flatie.css"> -->

    <link rel="stylesheet" type="text/css" href="/Public/Static/proui/css/themes.css" />
    <link rel="stylesheet" type="text/css" href="/Public/Static/proui/css/css3-cheat.css" />

    <link rel="stylesheet" type="text/css" href="/Public/Manage/css/style.css" />

    <script type="text/javascript" src="/Public/Static/proui/js/modernizr-2.7.1-respond-1.4.2.min.js"></script>

    <script type="text/javascript" src="/Public/Static/jquery-2.0.3.min.js"></script>    
    <script type="text/javascript" src="/Public/Static/bootstrap/js/bootstrap3.1.1.min.js"></script>
    <script type="text/javascript" src="/Public/Static/proui/js/plugins.js"></script>
    <script type="text/javascript" src="/Public/Static/proui/js/slim-scroll.min.js"></script>

    <script type="text/javascript" src="/Public/Static/ueditor1_4_3/ueditor.config.js"></script>
    <script type="text/javascript" src="/Public/Static/ueditor1_4_3/ueditor.all.js"></script>

    <script type="text/javascript" src="/Public/Static/jssrc/map.js"></script>
    <script type="text/javascript" src="/Public/Static/jssrc/application.js"></script>
    <script type="text/javascript" src="/Public/Static/jssrc/customize.js"></script>

    <script type="text/javascript" src="/Public/Static/jquery.datepicker/datepicker.js"></script>
    <link rel="stylesheet" type="text/css" href="/Public/Static/jquery.datepicker/datepicker.css" />

    <script type="text/javascript" src="/Public/Static/jquery.tokeninput/jquery.tokeninput.js"></script>
    <link rel="stylesheet" type="text/css" href="/Public/Static/jquery.tokeninput/token-input.css" />
    <link rel="stylesheet" type="text/css" href="/Public/Static/jquery.tokeninput/token-input-facebook.css" />

    <script type="text/javascript" src="/Public/Static/jquery.typeahead.js"></script>

    <script type="text/javascript" src="/Public/Static/uploadify/jquery.uploadify.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/Public/Static/uploadify/uploadify.css" />

    <script type="text/javascript" src="/Public/Static/dragsort/jquery.dragsort-0.5.1.js"></script>

    <script type="text/javascript" src="/Public/Static/colortip/colortip-1.0-jquery.js"></script>
    <link rel="stylesheet" type="text/css" href="/Public/Static/colortip/colortip-1.0-jquery.css" />

<!--notify start-->
<script type="text/javascript" src="/Public/Static/noty/packaged/jquery.noty.packaged.js"></script>
<script type="text/javascript">
    function display_noty(text, type) {
        if(!type) {
            type = 'error';
        }
        var n = noty({
            text        : text,
            type        : type,
            dismissQueue: true,
            layout      : 'topCenter',
            theme       : 'defaultTheme',
            timeout     : 4000,
        });
    }

    $(document).ready(function() {
        var session_success_msg = '<?php echo session("success", NULL);?>';
        if(session_success_msg) {
            display_noty(session_success_msg, 'success');
        }

        var session_error_msg = '<?php echo session("error", NULL);?>';
        if(session_error_msg) {
            display_noty(session_error_msg, 'error'); 
        }
    });
</script>
<!--notify end-->
<script type="text/javascript" src="/Public/Manage/js/common.js"></script>    
 
</head>
<body>


<div id="page-container" class="sidebar-partial sidebar-visible-lg sidebar-no-animations">
    <div id="sidebar">
        <div class="sidebar-scroll">
            <div class="sidebar-content">
                <a href="<?php echo U('Index/index');?>" class="sidebar-brand">
                    <i class="gi gi-stopwatch"></i><strong>管理后台</strong>
                </a>
                <ul class="sidebar-nav">
                    <?php if(is_array($left_menus)): foreach($left_menus as $key=>$m): if($m['type'] == 'header'): ?><li class="sidebar-header">
                                <span class="sidebar-header-title"><i class="<?php echo ($m['icon']); ?>"></i>&nbsp;<?php echo ($m['title']); ?></span>
                            </li>
                            <?php else: ?>
                            <li <?php echo ($m['is_active']?'class="active"':''); ?>>
                                <?php if($m['submenu']): ?><a href="<?php echo ($m['link']); ?>" onclick="window.location.href='<?php echo ($m['link']); ?>'" class="sidebar-nav-menu"><i class="fa fa-angle-left sidebar-nav-indicator"></i><?php echo ($m['title']); ?></a>
                                    <ul>
                                        <?php if(is_array($m['submenu'])): foreach($m['submenu'] as $key=>$m2): if($m2['submenu']): ?><li <?php echo ($m2['is_active']?'class="active"':''); ?>>
                                                    <a href="<?php echo ($m2['link']); ?>" onclick="window.location.href='<?php echo ($m2['link']); ?>'" class="sidebar-nav-submenu"><i class="fa fa-angle-left sidebar-nav-indicator"></i><?php echo ($m2['title']); ?></a>
                                                    <ul>
                                                        <?php if(is_array($m2['submenu'])): foreach($m2['submenu'] as $key=>$m3): ?><li>
                                                                <a <?php echo ($m3['is_active']?'class="active"':''); ?> href="<?php echo ($m3['link']); ?>"><?php echo ($m3['title']); ?></a>
                                                            </li><?php endforeach; endif; ?>
                                                    </ul>
                                                </li>
                                                <?php else: ?>
                                                <li>
                                                    <a <?php echo ($m2['is_active']?'class="active"':''); ?> href="<?php echo ($m2['link']); ?>"><?php echo ($m2['title']); ?></a>
                                                </li><?php endif; endforeach; endif; ?>
                                    </ul>
                                    <?php else: ?>
                                    <li>
                                        <a <?php echo ($m['is_active']?'class="active"':''); ?> href="<?php echo ($m['link']); ?>"><?php echo ($m['title']); ?></a>
                                    </li><?php endif; ?>
                            </li><?php endif; endforeach; endif; ?>

                </ul>
            </div>
        </div>
    </div>

    <!-- Main Container -->
    <div id="main-container">
        <!-- <header class="navbar navbar-fixed-top navbar-inverse"> -->
        <header class="navbar navbar-inverse">
            <ul class="nav navbar-nav-custom">
                <li>
                    <a href="javascript:void(0)" onclick="App.sidebar('toggle-sidebar');">
                        <i class="fa fa-bars fa-fw"></i>
                    </a>
                </li>
                <li>
                    <a href="<?php echo U('Content/index');?>">内容</a>
                </li>
                <li>
                    <a href="<?php echo U('Set/index');?>">设置</a>
                </li>
                <li>
                    <a href="<?php echo U('User/index');?>">用户</a>
                </li>
                <?php if(C('SHOW_MESSAGE')): ?><li>
                        <a href="<?php echo U('Message/index');?>">留言</a>
                    </li><?php endif; ?>
                <?php if(C('SHOW_STATISTIC')): ?><li>
                        <a href="<?php echo U('ContentStatistic/index');?>">统计</a>
                    </li><?php endif; ?>
            </ul>

            <ul class="nav navbar-nav-custom pull-right">
                <li>
                    <a href="<?php echo U('user/render_profile?id='.$login_user['uid']);?>" class="ajaxlink" title="点击修改账户密码">
                        hi，<?php echo ($login_user['username']); ?>
                    </a>
                </li>
                <li>
                    <a href="<?php echo U('public/logout');?>">退出</a>
                </li>
                <li>
                    <a href="/" target="_blank"><i class="gi gi-home"></i></a>
                </li>
            </ul>

        </header>
        <!-- END Header -->

        <div id="page-content">
            <div id="content-index">
    <?php
 $breads[U('index')] = '内容'; foreach ($breadcrumb_info as $key => $value) { $breads[U('index?cid='.$value['id'])] = $value['title']; } ?>
<ul class="breadcrumb breadcrumb-top">
    <?php if(is_array($breads)): foreach($breads as $key=>$one): ?><li><a href="<?php echo ($key); ?>"><?php echo ($one); ?></a></li><?php endforeach; endif; ?>
    <?php if($content): ?><li class="text-muted"><?php echo ($content['title']); ?></li><?php endif; ?>
</ul>



    <?php if($category['type'] != 3): ?><div class="content-header">
            <div class="header-section">
                <form method="get" class="pull-left" style="margin-bottom: 10px">
                    <input type="hidden" name="id" value="<?php echo ($id); ?>">
                    <table><tr>
                        <td>
                            <div class="btn-group btn-group-sm btn-create-group">
                                  <a href="<?php echo U('Manage/content/edit?model_id='.$default_new_model_id.'&category_id='.$category_id);?>" class="btn btn-primary">发布</a>
                                  <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                    <span class="caret"></span>
                                  </button>
                                  <ul class="dropdown-menu" role="menu">
                                    <?php if(is_array($models)): foreach($models as $key=>$one): if(in_array($one['id'], $available_model_ids)): ?><li><a href="<?php echo U('Manage/content/edit?model_id='.$key.'&category_id='.$category_id);?>"><i class="<?php echo ($one['icon_class']); ?>"></i><?php echo ($one['name']); ?></a></li><?php endif; endforeach; endif; ?>
                                  </ul>
                            </div>
                        </td>
                        <td>
                            <select class="form-control input-sm" name="smodel_id">
                                <option value="0">-类型-</option><?php echo select_option($models, $smodel_id);?>
                            </select>
                        </td>
                        <td>
                            <select class="form-control input-sm" name="sstatus">
                                <option value="0">-状态-</option><?php echo select_option($statuses, $sstatus);?>
                              </select>
                        </td>
                        <td>
                            <select class="form-control input-sm" name="screate_user_id">
                                <option value="0">-编辑-</option><?php echo select_option($seditors, $screate_user_id);?>
                              </select>
                        </td>
                        <td>
                            <div class="input-group">
                              <input class="form-control input-sm" name="stitle" value="<?php echo ($stitle); ?>" placeholder="标题" />
                              <span class="input-group-btn">
                                <button class="btn btn-default btn-sm" type="submit">搜索</button>
                                <a href="<?php echo U('Content/index');?>" class="btn btn-default btn-sm" title="重置"><i class="hi hi-repeat"></i></a>
                                <!-- <button type="button" class="btn btn-default btn-sm" title="高级搜索"><i class="fa fa-chevron-right"></i></button> -->
                              </span>
                            </div>
                        </td>
                    </tr></table>
                </form>
                <a href="<?php echo U('Content/index?sstatus=10');?>" title="查看回收站" class="pull-right"><i class="hi hi-trash"></i></a>
            </div>
            <div class="clearfix"></div>
        </div><?php endif; ?>

    <div class="block">
    <?php if($list): ?><form class="content_form" action="" method="post">
            <?php  $current_url = $_SERVER['REQUEST_URI']; if(strpos($current_url, '?')>0) { $get_prefix = $current_url . '&'; } else { $get_prefix = $current_url . '?'; } ?>
            <table id="general-table" class="table table-vcenter table-hover">
                <thead>
                    <tr>
                        <th style="width:10px;padding:8px 2px"><input class="check-all-content" type="checkbox"></th>
                        <th>标题
                            <?php if($category['children']): ?><div class="btn-group btn-group-sm">
                                    <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" style="padding:0px 10px 0px 10px">
                                      <i class="fa fa-sitemap"></i>
                                      <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                        <?php if(is_array($category['children'])): foreach($category['children'] as $key=>$cc): ?><li><a href="<?php echo U('Content/category?cid='.$cc['id']);?>"><?php echo ($cc['title']); ?></a></li><?php endforeach; endif; ?>
                                    </ul>
                                </div><?php endif; ?>
                            <?php if($id AND $content): ?><!--子文章详情页-->
                                <?php  $ref = $_SERVER['HTTP_REFERER']; if(strpos($ref, '?')>0) { $ref = $ref . '&focuspid='.$content['id']; } else { $ref = $ref . '?focuspid='.$content['id']; } ?>
                                &nbsp;<a href="<?php echo ($ref); ?>"><span class="text-warning" title="点击返回">【<i class="fa fa-reply"></i><?php echo ($content['title']); ?>】</span></a><?php endif; ?>
                        </th>
                        <th style="width:120px">操作</th>
                        <th style="width:74px">状态</th>
                        <th style="width:60px">点击</th>
                        <th style="width:64px">
                            <a href="<?php echo $get_prefix;?>order=weight">权重
                                <?php if($_GET['order'] == 'weight'): ?><i class="fa fa-chevron-down"></i><?php endif; ?>
                            </a>
                        </th>
                        <th style="width:70px">编辑</th>
                        <th style="width:140px">
                            <a href="<?php echo $get_prefix;?>order=publish_time">发布时间
                                <?php if($_GET['order'] == 'publish_time'): ?><i class="fa fa-chevron-down"></i><?php endif; ?>
                            </a>
                        </th>
                    </tr>
                </thead>

                <tbody>
                    <?php $hilight_id = session('highlight_id', NULL); ?>
                    <?php if(is_array($list)): foreach($list as $key=>$one): $one_content = $one; $is_child = 0; ?>
                        <tr
        <?php if($is_child == 1): ?>style="display:none" 
            class="child<?php echo $one_content['parent_id'];?>"
        <?php elseif($hilight_id==$one_content['id']): ?>
            class="success"<?php endif; ?>
    >
    <td style="padding:8px 2px"><input type="checkbox" id="checkbox-<?php echo ($one_content['id']); ?>" name="checkbox[]" value="<?php echo ($one_content['id']); ?>"></td>
    <td <?php echo ($is_child==1?'class="child-indent"':''); ?>>
        <i title="<?php echo ($one_content['model']['name']); ?>" class="<?php echo ($one_content['model']['icon_class']); ?>"></i>
        <?php if($category_id != $one_content['category_id']): ?><a href="<?php echo U('Content/category?cid='.$one_content['category_id']);?>">[<?php echo ($one_content['category_name']); ?>]</a>&nbsp;<?php endif; ?>
        <a href="<?php echo U('Content/edit?id='.$one_content['id']);?>"><?php echo ($one_content['title']); ?></a>
        <?php if($one_content['thumb']): ?><a href="<?php echo ($one_content['thumb']); ?>" data-toggle="lightbox-image">
                <i class="fa fa-picture-o text-warning"></i>
            </a><?php endif; ?>
        <?php if($one_content['children']): ?><a href="javascript:void(0)" onclick="$('.child'+<?php echo ($one_content['id']); ?>).toggle()">
                <i class="fa fa-list text-warning" title="点击展开子文章">&nbsp;(<?php echo count($one_content['children']);?>)</i>
            </a><?php endif; ?>
    </td>
    <td nowrap>
        <div class="btn-group btn-group-xs">
            <a href="<?php if($one_content[template] == "category" ): ?>/category/<?php echo ($one_content['category']['id']); ?>#<?php echo ($one_content['id']); ?> <?php else: echo ($one_content['link']); endif; ?>" target="_blank" title="网站前台访问" class="btn btn-default"><i class="hi hi-link"></i></a>
            <a href="<?php echo U('Content/edit?id='.$one_content['id']);?>" title="编辑" class="btn btn-default"><i class="hi hi-pencil"></i></a>
            <a href="<?php echo U('Content/render_copy?id='.$one_content['id']);?>" title="复制" class="btn btn-default ajaxlink"><i class="fa fa-files-o"></i></a>                                
            <a href="<?php echo U('Content/delete?id='.$one_content['id']);?>" title="删除"class="btn btn-default ajaxlink" 
                ask="<?php echo ($one_content['status']<10?'确定删除么？删除后内容在回收站中，还可以恢复。':'确认要彻底删除该内容？'); ?>">
                <i class="<?php echo ($one_content['status']<10?'hi hi-trash':'hi hi-remove'); ?>"></i>
            </a>
        </div>
    </td>
    <td nowrap>
        <?php echo ($one_content['status_name']); ?>&nbsp;
        <?php if($one_content['status_action']): ?><a  href="<?php echo ($one_content['status_action']['link']); ?>?id=<?php echo ($one_content['id']); ?>" 
                ask="<?php echo ($one_content['status_action']['ask']); ?>" 
                title="<?php echo ($one_content['status_action']['title']); ?>" class="ajaxlink">
                <i class="<?php echo ($one_content['status_action']['icon']); ?>"></i>
            </a><?php endif; ?>

    </td>
    <td><?php echo ($one_content['pv']); ?></td>
    <td><?php echo ($one_content['weight']); ?></td>
    <td><a href="/Manage/user/index?susername=<?php echo ($one_content['create_user']['username']); ?>" target="_blank"><?php echo ($one_content['create_user']['username']); ?></a></td>
    <td><?php echo ($one_content['publish_time'] > 1?substr($one_content['publish_time'],0,16):'-'); ?></td>
</tr>
                        <?php if($one['children']): ?><!--默认显示10个，其他的到更多去看去-->
                            <?php if(is_array($one['children'])): foreach($one['children'] as $key=>$child): $one_content = $child; $is_child = 1; ?>
                                <?php if($key < 10): ?><tr
        <?php if($is_child == 1): ?>style="display:none" 
            class="child<?php echo $one_content['parent_id'];?>"
        <?php elseif($hilight_id==$one_content['id']): ?>
            class="success"<?php endif; ?>
    >
    <td style="padding:8px 2px"><input type="checkbox" id="checkbox-<?php echo ($one_content['id']); ?>" name="checkbox[]" value="<?php echo ($one_content['id']); ?>"></td>
    <td <?php echo ($is_child==1?'class="child-indent"':''); ?>>
        <i title="<?php echo ($one_content['model']['name']); ?>" class="<?php echo ($one_content['model']['icon_class']); ?>"></i>
        <?php if($category_id != $one_content['category_id']): ?><a href="<?php echo U('Content/category?cid='.$one_content['category_id']);?>">[<?php echo ($one_content['category_name']); ?>]</a>&nbsp;<?php endif; ?>
        <a href="<?php echo U('Content/edit?id='.$one_content['id']);?>"><?php echo ($one_content['title']); ?></a>
        <?php if($one_content['thumb']): ?><a href="<?php echo ($one_content['thumb']); ?>" data-toggle="lightbox-image">
                <i class="fa fa-picture-o text-warning"></i>
            </a><?php endif; ?>
        <?php if($one_content['children']): ?><a href="javascript:void(0)" onclick="$('.child'+<?php echo ($one_content['id']); ?>).toggle()">
                <i class="fa fa-list text-warning" title="点击展开子文章">&nbsp;(<?php echo count($one_content['children']);?>)</i>
            </a><?php endif; ?>
    </td>
    <td nowrap>
        <div class="btn-group btn-group-xs">
            <a href="<?php if($one_content[template] == "category" ): ?>/category/<?php echo ($one_content['category']['id']); ?>#<?php echo ($one_content['id']); ?> <?php else: echo ($one_content['link']); endif; ?>" target="_blank" title="网站前台访问" class="btn btn-default"><i class="hi hi-link"></i></a>
            <a href="<?php echo U('Content/edit?id='.$one_content['id']);?>" title="编辑" class="btn btn-default"><i class="hi hi-pencil"></i></a>
            <a href="<?php echo U('Content/render_copy?id='.$one_content['id']);?>" title="复制" class="btn btn-default ajaxlink"><i class="fa fa-files-o"></i></a>                                
            <a href="<?php echo U('Content/delete?id='.$one_content['id']);?>" title="删除"class="btn btn-default ajaxlink" 
                ask="<?php echo ($one_content['status']<10?'确定删除么？删除后内容在回收站中，还可以恢复。':'确认要彻底删除该内容？'); ?>">
                <i class="<?php echo ($one_content['status']<10?'hi hi-trash':'hi hi-remove'); ?>"></i>
            </a>
        </div>
    </td>
    <td nowrap>
        <?php echo ($one_content['status_name']); ?>&nbsp;
        <?php if($one_content['status_action']): ?><a  href="<?php echo ($one_content['status_action']['link']); ?>?id=<?php echo ($one_content['id']); ?>" 
                ask="<?php echo ($one_content['status_action']['ask']); ?>" 
                title="<?php echo ($one_content['status_action']['title']); ?>" class="ajaxlink">
                <i class="<?php echo ($one_content['status_action']['icon']); ?>"></i>
            </a><?php endif; ?>

    </td>
    <td><?php echo ($one_content['pv']); ?></td>
    <td><?php echo ($one_content['weight']); ?></td>
    <td><a href="/Manage/user/index?susername=<?php echo ($one_content['create_user']['username']); ?>" target="_blank"><?php echo ($one_content['create_user']['username']); ?></a></td>
    <td><?php echo ($one_content['publish_time'] > 1?substr($one_content['publish_time'],0,16):'-'); ?></td>
</tr>
                                <?php else: ?>
                                    <tr style="display:none" class="child<?php echo $one_content['parent_id'];?>">
                                        <td></td>
                                        <td colspan="8" style="padding-left: 54px;">
                                            <a href="/manage/content?id=<?php echo ($one['id']); ?>"><i class="fa fa-fighter-jet"></i>默认显示10条，点击查看全部 <i class="gi gi-more"></i></a>
                                        </td>
                                    </tr>
                                    <?php break; endif; endforeach; endif; endif; endforeach; endif; ?>
                </tbody>
            </table>
            <div>
                <div class="pull-left" style="padding-top:15px;">
                    <?php if($sstatus != 10): ?><a class="btn btn-info btn-xs move-btn ajaxlink" ><i class="fa fa-arrows"></i>移动</a>
                        <a class="btn btn-info btn-xs ajaxlink" style="margin-left:10px;" id="export-btn"><i class="hi hi-export"></i>导出</a>
                        <a class="btn btn-info btn-xs ajaxlink" style="margin-left:10px;" id="import-btn" href="javascript::void(0)"><i class="hi hi-import"></i>导入</a>
                        <a class="btn btn-info btn-xs copy-btn ajaxlink" style="margin-left:10px;"><i class="fa fa-files-o"></i>复制</a>
                        <a class="btn btn-info btn-xs delete-much-btn ajaxlink" href="javascript:;"  style="margin-left:10px;"><i class="hi hi-remove"></i>删除</a>
                        <a class="btn btn-info btn-xs update-status  ajaxlink" href="javascript:;"  style="margin-left:10px;"><i class="hi hi-ok"></i>发布</a>
                    <?php else: ?>
                        <a class="btn btn-info btn-xs thorough-delete-btn ajaxlink" ><i class="hi hi-remove"></i>彻底删除</a>
                        <a class="btn btn-info btn-xs recycle-btn ajaxlink" ><i class="gi gi-restart"></i>还原</a><?php endif; ?>
                </div>
                <div class="pull-right">
                    <?php echo ($_page); ?>
                </div>
            </div>
            <div class="clearfix"></div>
            <?php if($category['remark']): ?><div class="alert alert-warning">栏目备注：</i><?php echo ($category['remark']); ?></div><?php endif; ?>
        </form>
    <?php else: ?>
        <?php if($category['type'] == 3 AND $category['extralink']): ?><a target="_blank" href="<?php echo ($category['extralink']); ?>">
                <i class="gi gi-link icon-fix"></i>
                该栏目为外部链接，点击查看：<?php echo ($category['extralink']); ?>
            </a>
        <?php else: ?>
            <h5>该栏目没有内容，请点击上面“发布”创建</h5><?php endif; endif; ?>
    </div>
</div>
<script type="text/javascript">
    var allCheck = $('tbody input[type="checkbox"]');
    $('.check-all-content').click(function(){
        var checkStatus = $(this).prop('checked');
        if(checkStatus) {
            allCheck.prop('checked',true);
        }else {
            allCheck.prop('checked',false);
        }
    })

    $('.delete-much-btn').click(function(){
        
        if(!checkCheckbox()) {
            alert('请最少选择一个');
            return;
        }
        if(confirm('确认要删除吗？')) {
            $('.content_form').prop('action','/manage/content/batch_delete').submit();
        }
    })

    $('.thorough-delete-btn').click(function(){
        if(!checkCheckbox()) {
            alert('请最少选择一个');
            return;
        }
        if(confirm('确认要彻底删除吗？删除后不可恢复')) {
            $('.content_form').prop('action','/manage/content/batch_delete').submit();
        }
    })

    $('.copy-btn').click(function(){
        if(!checkCheckbox()) {
            alert('请最少选择一个');
            return;
        }
        var chooseBox = [];
        $.each(allCheck,function(i,v) {
            if($(this).prop('checked')==true) {
                chooseBox.push($(this).val());
            }
        })
        var stringIds = chooseBox.join('-');
        $(this).attr('href','/Manage/Content/render_copy?id='+stringIds);
    })

    

     $('.update-status').click(function(){
        if(!checkCheckbox()) {
            alert('请最少选择一个');
            return;
        }
        var chooseBox = [];
        $.each(allCheck,function(i,v) {
            if($(this).prop('checked')==true) {
                chooseBox.push($(this).val());
            }
        })
        var stringIds = chooseBox.join('-');
        location.href = '/Manage/Content/batch_publish?ids='+stringIds;
    })

    $('#export-btn').click(function(){

        if(!checkCheckbox()) {
            alert('请最少选择一个');
            return;
        }

        var category_id = parseInt(<?php echo ($category_id); ?>);
        if(!category_id) {
            alert('请选择在某个栏目下进行导出');
            return;
        }

        var chooseBox = [];
        $.each(allCheck,function(i,v) {
            if($(this).prop('checked')==true) {
                chooseBox.push($(this).val());
            }
        })
        var stringIds = chooseBox.join('-');
        location.href='/Manage/Content/export_content?category_id=<?php echo ($category_id); ?>&ids='+stringIds;
    })

    $('#import-btn').click(function(){
        var category_id = parseInt(<?php echo ($category_id); ?>);
        if(!category_id) {
            alert('请选择在某个栏目下进行导入');
            return;
        }
        location.href='/Manage/Content/import_content/cid/<?php echo ($category_id); ?>';
    })


    $('.move-btn').click(function(){
        if(!checkCheckbox()) {
            alert('请最少选择一个');
            return;
        }
        var chooseBox = [];
        $.each(allCheck,function(i,v) {
            if($(this).prop('checked')==true) {
                chooseBox.push($(this).val());
            }
        })
        var stringIds = chooseBox.join('-');
        $(this).attr('href','/Manage/Content/render_move_content?ids='+stringIds);
    })

    $('.recycle-btn').click(function(){
        if(!checkCheckbox()) {
            alert('请最少选择一个');
            return;
        }

        if(confirm('确认要还原吗？')) {
            var chooseBox = [];
            $.each(allCheck,function(i,v) {
                if($(this).prop('checked')==true) {
                    chooseBox.push($(this).val());
                }
            })
            var stringIds = chooseBox.join('-');
            $(this).attr('href','/Manage/Content/recycle?ids='+stringIds);
        }
    })

    function checkCheckbox() {
        var num = 0;
        $.each(allCheck,function(i,v) {
            if($(this).prop('checked') == true) {
                num+=1;
            }
        })
        if(num) {
            return true;
        }else {
            return false;
        }
    }

    $(document).ready(function() {
        var focuspid = parseInt(<?php echo ($_GET['focuspid']); ?>);
        if(focuspid) {
            $('.child'+focuspid).toggle();
        }
    });
</script>
        </div>

        <footer class="clearfix">
            <div class="pull-right">
                Crafted by <a href="http://www.justering.com" target="_blank">Justering</a>
            </div>
        </footer>
    </div>
    <!-- END Main Container -->
</div>
<!-- END Page Container -->

<!-- Scroll to top link, initialized in js/app.js - scrollToTop() -->
<a href="#" id="to-top"><i class="fa fa-angle-double-up"></i></a>

<div id="modaldialog"></div>


<script type="text/javascript">

    var max_up_size = parseInt(("<?php echo C('PICTURE_UPLOAD.maxSize');?>" / 1024/1014));
    $(document).ready(function() {

        // preview thumb image
        $(".image_uploadify").each(function(){
            var key = $(this).attr('value');
            setTimeout(function () {
                $("#image_upload_"+key).uploadify({
                    'formData'        : {'field_key' : key},
                    "height"          : 30,
                    "swf"             : "/Public/Static/uploadify/uploadify.swf",
                    "fileObjName"     : "download",
                    "buttonText"      : "上传图片(最大"+max_up_size+"M)",
                    "uploader"        : "<?php echo U('File/uploadPicture',array('session_id'=>session_id()));?>",
                    "width"           : 130,
                    'queueID'         : 'image_upload_preview_'+key,
                    'removeTimeout'   : 1,
                    'fileTypeExts'    : '*.jpg; *.png; *.gif;',
                    "onUploadSuccess" : image_upload_thumb_preview,
                    'onFallback' : function() {
                        alert('未检测到兼容版本的Flash.');
                    }
                });
            },0);
        });

        function image_upload_thumb_preview(file, data) {
          var data = $.parseJSON(data);
          var src = '';
          if(data.status){
              src = data.url || '' + data.path
              var field_key = data.field_key;

              $("#image_upload_value_"+field_key).val(src);
              $("#image_upload_preview_"+field_key).html('<a title="点击预览" href="'+ src +'" target="_blank"><img style="max-width:200px" src="' + src + '"/></a>');
          } else {
              alert('上传有误，请联系管理员：');
          }
      }
  });
</script>


<script type="text/javascript" src="/Public/Static/proui/js/magnific-popup.min.js"></script>
<script type="text/javascript" src="/Public/Static/proui/js/app.js"></script>
<script type="text/javascript" src="/Public/Static/js/form_post.js"></script>
<script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "//hm.baidu.com/hm.js?c01103610061d40b39b6627b785cd2fd";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
</script>
</body>
</html>