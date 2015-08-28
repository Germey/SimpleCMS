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
        <div class="header-section">
            <a href="/Manage/banner/render_edit" class="btn btn-sm btn-primary ajaxlink"><i class="fa fa-plus"></i>新建Banner/Ad</a>
        </div>
    </div>
    <div class="block">
        <div class="form-group">
            <div class="col-md-2" style="padding-left:0">
                <?php if($banners): ?><div class="category-select">
                        <?php if(is_array($banners)): foreach($banners as $key=>$one): ?><div class="pl0 <?php echo ($one['id']==$banner['id']?'active':''); ?>" onclick="select_category(<?php echo ($one['id']); ?>)">
                                <i class="fa fa-circle-o"></i>&nbsp;<?php echo ($one['title']); ?>
                            </div><?php endforeach; endif; ?>
                    </div><?php endif; ?>
            </div>
            <div class="col-md-10">
                <?php if($banner['id']): ?><div class="pull-right">
                        <?php  $del_link = 'javascript:void(0)'; $ask_text = '删除不了！需要删除完图片后才能删除方案'; if(!$banner['pictures']) { $del_link = U('Banner/delete?id='.$banner['id']); $ask_text = '你确认要删除该方案么？'; } ?>
                        <a href="<?php echo ($del_link); ?>" class="btn btn-xs btn-danger ajaxlink" ask="<?php echo ($ask_text); ?>"><i class="hi hi-remove"></i>删除当前方案</a>
                        <a href="/Manage/banner/render_edit?id=<?php echo ($banner['id']); ?>" class="btn btn-xs btn-primary ajaxlink"><i class="fa fa-pencil"></i>编辑方案名称</a>
                    </div>
                    <div class="clearfix"></div>
                    <div class="alert alert-info">
                        <div style="margin-bottom:10px">关键字：<span class="text-danger"><?php echo ($banner['name']); ?></span></div>
                        <div>备注：<?php echo nl2br($banner['description']);?></div>
                    </div>
                    <form action="<?php echo U('banner/save');?>" method="post" class="post_ajax_form">
                        <?php  $object_id = $banner['id']; $object_type = 'banner'; $pictures = $banner['pictures']; ?>
                        <div class="clear box">
  <?php if($picture_tip): ?><div class="text-muted"><i class=""></i><?php echo ($picture_tip); ?></div><?php endif; ?>

  <input type="file" id="picture-upload" class="f-input" style="width:400px"/>
  <div id="picture-custom-queue"></div>
  <div class="picture-wrapper">
    <table id="picture-table" class="table table-dashed picture-upload">
      <?php if($pictures): if(is_array($pictures)): foreach($pictures as $key=>$one): ?><tr class="couldsort" id="trimage<?php echo ($one['picture_id']); ?>">
            <td><span class="trimage<?php echo ($one['picture_id']); ?>" title="单击预览，拖拽排序"><img src="/Public/Manage/css/img/dragsort_flag.png"></span></td>
            <td>
              <input type="hidden" name="picture_ids[]" value="<?php echo ($one['picture_id']); ?>" />
              <a href="<?php echo ($one['path']); ?>" data-toggle="lightbox-image" ><img class="preview" src="<?php echo thumb($one['path'],160,120);?>" /></a>
            </td>
            <td>
              <div class="form-inline"><label class="control-label">链接</label> <input type="text" class="form-control input-sm" name="picture_link<?php echo ($one['picture_id']); ?>" placeholder="http://" value="<?php echo ($one['link']); ?>"></div>
              <div class="form-inline"><label class="control-label">标题</label> <input type="text" class="form-control input-sm" name="picture_title<?php echo ($one['picture_id']); ?>" value="<?php echo ($one['title']); ?>"></div>
              <div class="form-inline"><label class="control-label">简述</label> <textarea name="picture_summary<?php echo ($one['picture_id']); ?>" type="text" class="form-control input-sm"><?php echo ($one['summary']); ?></textarea>
              </td>
              <td>
                <a href="javascript:void(0);" onclick="remove_image(<?php echo ($one['picture_id']); ?>);"><i class="fa fa-times fa-2x text-danger"></i></a>
              </td>
            </tr><?php endforeach; endif; endif; ?>
      </table>
    </div>
  </div>

  <script type="text/javascript">

    $(document).ready(function() {

      //初始化 因为要和下面一个一个增加的方式配合，不能一齐用class触发
      <?php if(is_array($pictures)): foreach($pictures as $key=>$one): ?>trigger_sort(<?php echo ($one['picture_id']); ?>);<?php endforeach; endif; ?>

      var max_up_size = parseInt(("<?php echo C('PICTURE_UPLOAD.maxSize');?>" / 1024/1014));
      setTimeout(function () {
        $('#picture-upload').uploadify({
          'swf' : "/Public/Static/uploadify/uploadify.swf",
          "uploader"        : "<?php echo U('File/uploadPicture',array('session_id'=>session_id()));?>",
          "buttonText"      : "上传文件(可多选，单个文件最大"+max_up_size+"M)",
          'queueID'         : 'picture-custom-queue',
          "fileObjName"     : "download",
          'multi'           : true,
          "width"           : 234,
          'onUploadSuccess' : function(file, data) {
            var data = $.parseJSON(data);

            if(data.status){

              var idx = data.id;
              var str = '<tr class="couldsort" id="trimage'+idx+'"><td><span class="trimage'+idx+'"><img src="/Public/Manage/css/img/dragsort_flag.png"></span></td><td class="img"><div><input type="hidden" name="picture_ids[]" value="'+idx+'"/><img class="preview" src="'+data.path+'" /></td>';

              str += '<td><div class="form-inline"><label class="control-label">链接</label> <input type="text" class="form-control input-sm" name="picture_link'+idx+'" placeholder="http://"></div>';
              str += '<div class="form-inline"><label class="control-label">标题</label> <input type="text" class="form-control input-sm" name="picture_title'+idx+'"></div>';
              str += '<div class="form-inline"><label class="control-label">简述</label> <textarea name="picture_summary'+idx+'" type="text" class="form-control input-sm"></textarea></td>';
              str += '<td><a href="javascript:void(0);" onclick="remove_image('+ idx +');"><i class="fa fa-times fa-2x text-danger"></i></a></td></tr>';

              $("#picture-table").prepend(str);

                  // 触发新文件和原来文件的排序
                  trigger_sort(idx);

                } else {
                  alert('上传有误，请联系管理员：');
                }
              },
            });
      },0);
});

function remove_image(id) {
  if(!id) return;
  if(window.confirm("是否确认删除该图片？")) {
    $("#trimage" + id).remove();
  }
}

function trigger_sort(id) {
 if(!id) return;
 $("#picture-table").dragsort({
  itemSelector: "tr",
  dragSelector: ".trimage" + id ,
  dragBetween: true,
  dragEnd: pic_dragsort,
  placeHolderTemplate: "<tr ></tr>"
});

}


//注意：没有这个end 方法会报错
function pic_dragsort() {}
</script>


                        <div class="form-group form-actions">
                            <input type="hidden" name="id" value="<?php echo ($banner['id']); ?>">
                            <input type="hidden" name="banner_name" value="<?php echo ($banner['name']); ?>">
                            <div class="col-md-9 col-md-offset-1">
                                <button type="submit" class="btn btn-sm btn-success" data-loading-text="保存中..."><i class="hi hi-ok"></i>保存</button>
                            </div>
                        </div>
                    </form><?php endif; ?>
            </div>
            <br />
            <div class="clearfix"></div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {

    });

    function select_category(cid) {
         var href = "<?php echo U('Banner/index');?>";
         window.location.href = href + '?id=' + cid;
    }
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