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
            <div id="category-edit">
    

    <div class="content-header">
        <div class="header-section btn-group btn-group-sm btn-create-group">
            <a href="/Manage/category/create" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> 新建栏目</a>
            <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" role="menu" style="width:110px;">
                <li><a  href="/Manage/category/create"><i class="fa fa-plus" ></i>新建栏目</a></li>
                <li><a class="ajaxlink" href="<?php echo U('batch_create_category_dialog');?>"><i class="hi hi-plus-sign"></i>批量新建栏目</a></li>
            </ul>
        </div>
        <a class="btn btn-link dropdown-toggle ajaxlink pull-right" style="margin:15px 25px 0 0" href="<?php echo U('Category/clear_cache');?>" title="修改完栏目但前台展示有误，可点击清除"><i class="hi hi-refresh"></i>清除栏目缓存</a>
    </div>
    <div class="block">
        <div class="form-group">
            <div class="col-md-2" style="padding-left:0">
                <div class="category-select" style="position: ;"><?php echo content_category_select($tree, '',0, $category_id,true);?></div>
            </div>
            <div class="col-md-10">
                <?php if($category['id']): ?><div class="pull-right ">
                        <?php if(!$category['parent']['parent']): ?><div class="btn-group btn-group-xs btn-create-group" style="inline-block">
                                <a href="<?php echo U('Category/create?pid='.$category['id']);?>" class="btn btn-xs btn-primary"><i class="hi hi-plus"></i>创建子栏目</a>
                                <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown">
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" role="menu" style="width:110px;">
                                    <li><a  href="<?php echo U('Category/create?pid='.$category['id']);?>"><i class="fa fa-plus" ></i>新建子栏目</a></li>
                                    <li><a class="ajaxlink" href="<?php echo U('batch_create_category_dialog?pid='.$category['id']);?>"><i class="hi hi-plus-sign"></i>批量新建子栏目</a></li>
                                </ul>
                            </div><?php endif; ?>
                        <?php if($category_content_count): ?><a href="#" class="btn btn-xs btn-danger" onclick="display_noty('清空栏目内容（包括回收站）后才能删除栏目')">
                                <i class="hi hi-remove"></i>删除当前栏目(<?php echo ($category_content_count); ?>)
                            </a>
                        <?php else: ?>
                            <a href="<?php echo U('Category/delete?id='.$category['id']);?>" class="btn btn-xs btn-danger ajaxlink" ask="栏目中没有内容了，你可以删除，删除栏目将同时删除其子栏目，确定要删除该栏目？"><i class="hi hi-remove"></i>删除当前栏目</a><?php endif; ?>
                        <a href="<?php echo U('Content/index?cid='.$category['id']);?>" target="_blank" class="btn btn-xs"><i class="hi hi-share-alt"></i>查看栏目内容</a>
                    </div><?php endif; ?>
                <form action="<?php echo U('category/save');?>" method="post" class="form-horizontal post_ajax_form">
                    <table class="table table-noborder">
                        <?php if(is_array($model_fields)): foreach($model_fields as $key=>$field): switch($key): case "models": case "children_models": ?><tr id="tr<?php echo ($key); ?>">
                                    <td class="item-label"><?php echo ($field["title"]); ?></td>
                                    <td>
                                        <?php
 $models = D("Model")->getModels(); $exist_ids = array_keys($models); $current_models = array(); if($key=='children_models') { $current_models = $category['children_models']; $name_id = 'children_model_ids'; $name_name = 'children_model_templates'; } else { $current_models = $category['models']; $name_id = 'model_ids'; $name_name = 'model_templates'; } if($current_models) { $exist_ids = array_keys($current_models); } ?>
<div style="padding: 0px 5px;border-left: 3px solid #eee;">
    <table class="table table-noborder table-vcenter">
        <tr><th style="width:44px" nowrap>允许</th><th style="width:50px" nowrap>模型</th><th>内容页模板</th></tr>
        <?php if(is_array($models)): foreach($models as $key=>$one): ?><tr>
                <td class="text-center">
                    <input type="checkbox" name="<?php echo ($name_id); echo ($one['id']); ?>" value="<?php echo ($one['id']); ?>" 
                      <?php if(in_array($one['id'], $exist_ids)): ?>checked<?php endif; ?>  />
                </td>
                <td><?php echo ($one['name']); ?></td>
                <td>
                    <?php if($one['template']): ?><input type="text" name="<?php echo ($name_name); echo ($one['id']); ?>" class="span3 form-control input-sm" 
                            value="<?php echo ($current_models[$one['id']]?$current_models[$one['id']]:$one['template']); ?>" />
                    <?php else: ?>
                        -<?php endif; ?>
                </td>
            </tr><?php endforeach; endif; ?>
    </table>
</div>
                                    </td>
                                </tr><?php break;?>
                              <?php default: ?>
                                <?php echo form_block($key, $field, $category[$key]); endswitch; endforeach; endif; ?>
                    </table>
                    
                    <div class="form-group form-actions">
                        <input type="hidden" name="id" value="<?php echo ($category['id']); ?>">
                        <input type="hidden" name="pid" value="<?php echo ($pid); ?>">
                        <div class="col-md-9 col-md-offset-2">
                            <button type="submit" class="btn btn-sm btn-success" data-loading-text="保存中..."><i class="hi hi-ok"></i>保存</button>
                        </div>
                    </div>
                </form> 
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>

<script type="text/javascript">
    // TODO to be optimized
    var trSingle = $("tr").not("#trparent_title,#trtitle,#trname,#trtype,#trtemplate_single,#trcontent,#trsort,#tris_menu,#trlink,#trthumb,#trbanner");
    var trExtralink = $('#trparent_title,#trtitle,#trname,#trtype,#trextralink,#trsort,#tris_menu,#trthumb,#trbanner');
    <?php if($category['type'] == 4): ?>trSingle.hide();
    <?php elseif($category['type'] == 3): ?>
        $('tr').hide();
        trExtralink.show();
    <?php else: ?>
        $('#trtemplate_single,#trextralink').hide();<?php endif; ?>

    <?php if($category['enable_children']): ?>$("#trchildren_models").show();
    <?php else: ?>
        $("#trchildren_models").hide();<?php endif; ?>

    $(document).ready(function() {
        var type = $('.type_select').eq(0);
        type.change(function() {
            if($(this).val()==4) {
                $("tr").show();
                trSingle.hide();
            }else if($(this).val() ==3){
                $('tr').hide();
                trExtralink.show();
            }else {
                $('tr').show();
                $('#trtemplate_single,#trextralink,#trsubtitle').hide();
            }
        });


        $('input:radio[name="enable_children"]').click(function() {
            var res = parseInt($(this).val());
            if(res==1) {
                $("#trchildren_models").show();
            } else {
                $("#trchildren_models").hide();
            }
        });

        // 默认全是开着的，enable当前的，或者没有当前的，默认显示第一个
        // $(".category-select div").each(function(){
        //     if($(this).attr('pid') == 0) {
        //         toggle_subcategory($(this).attr('id'));
        //     }
        // });
    });

    function select_category(cid) {
         var href = "<?php echo U('Category/index');?>";
         window.location.href = href + '?id=' + cid;
    }

    // 折叠窗口，还没做完...
    // function toggle_subcategory(cid) {
    //     $(".category-select div").each(function(){
    //         if($(this).attr('pid') == cid) {
    //             $(this).toggle();

    //             //递归Toggle
    //             toggle_subcategory($(this).attr('id'));
    //         }
    //     });
    // }

    <?php if($category['subtitle']): ?>$('#trsubtitle').show();<?php endif; ?>

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