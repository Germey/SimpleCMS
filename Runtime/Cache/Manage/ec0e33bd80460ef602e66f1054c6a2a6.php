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
            <div id="content-edit">
  <?php
 $breads[U('index')] = '内容'; foreach ($breadcrumb_info as $key => $value) { $breads[U('index?cid='.$value['id'])] = $value['title']; } ?>
<ul class="breadcrumb breadcrumb-top">
    <?php if(is_array($breads)): foreach($breads as $key=>$one): ?><li><a href="<?php echo ($key); ?>"><?php echo ($one); ?></a></li><?php endforeach; endif; ?>
    <?php if($content): ?><li class="text-muted"><?php echo ($content['title']); ?></li><?php endif; ?>
</ul>


  <div class="block">
    <form action="<?php echo U('content/save');?>" method="post" class="form-horizontal post_ajax_form">
      <table class="table table-noborder">
        <tr>
          <td class="item-label"><span class="text-danger">*</span> 栏目</td>
          <td>
            <input type="text" id="category_name" class="pull-left form-control input-sm span1" placeholder="请选择" value="<?php echo ($category['title']); ?>" readonly="readonly" style="cursor: pointer;" />
            <div id="category-select-wrapper">
              <input type="hidden" name="category_id" id="category_id" value="<?php echo ($category_id); ?>" />
              <div class="category-select"><?php echo content_category_select($category_tree, '',0, $category_id);?></div>
            </div>
            <?php if($category['enable_children']): ?><label class="item-label">所属内容</label>
              <select id="status" name="parent_id" class="pull-left span3 form-control input-sm" style="width:550px">
                <option vlaue="0">&nbsp;-无-</option>
                <?php echo select_option($parent_contents, $content['parent_id']);?>
              </select><?php endif; ?>
          </td>
        </tr>
        <?php if(is_array($model_fields)): foreach($model_fields as $key=>$field): switch($field["type"]): case "pictures": ?><tr>
                <?php  $object_id = $content['id']; $object_type = 'content'; $pictures = $content['pictures']; $picture_tip = '点击图片拖拽可排序；在文章中添加组图，默认滚动方式显示在摘要和文章内容中间'; ?>
                <td class="item-label"><?php echo ($field["title"]); ?></td>
                <td><div class="clear box">
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
</td>
              </tr><?php break;?>
            <?php case "address": ?><td class="item-label"><?php echo ($field["title"]); ?></td>
              <td>
                <!-- 初始化位置信息 -->
                <table class="table-address span6">
                  <tr>
                    <td class="address-baseinfo">
                      <select id="province" class="address-select form-control input-sm" style="margin-left: 0px" name="address[]">
                        <option value="<?php echo ($content['address'][0]); ?>"></option>
                      </select>
                      <select id="city" class="address-select form-control input-sm" name="address[]">
                        <option value="<?php echo ($content['address'][1]); ?>"></option>
                      </select>
                      <select id="street" class="address-select form-control input-sm" name="address[]">
                        <option value="<?php echo ($content['address'][2]); ?>"></option>
                      </select>
                    </td>
                    <td>
                      <input type="text" class="form-control input-sm address-detaill" name="address[]" placeholder="请输入详细地址" value="<?php echo ($content['address'][3]); ?>">
                    </td>
                  </tr>
                </table>
                <script type="text/javascript">
                  $(function(){
                    setupcity();
                  })
                </script>
              </td><?php break;?>
            <?php case "files": ?><tr>
                <?php  $object_id = $content['id']; $object_type = 'content'; $files = $content['files']; ?>
                <td class="item-label"><?php echo ($field["title"]); ?></td>
                <td><div class="clear box">
    <?php if($file_tip): ?><div class="text-muted"><i class=""></i><?php echo ($files_tip); ?></div><?php endif; ?>

    <input type="file" id="file-upload" class="f-input" style="width:400px"/>
    <div id="file-custom-queue"></div>
    <div class="file-wrapper">
      <table id="file-table" class="table table-dashed file-upload">
        <?php if($files): if(is_array($files)): foreach($files as $key=>$one): ?><tr class="filecouldsort" id="trfile<?php echo ($one['file_id']); ?>">
              <td class="first"><i class="fi fi-<?php echo ($one['ext']); ?> fa-5x"></i></td><input type="hidden" name="file_ids[]" value="<?php echo ($one['file_id']); ?>">
              <td>
                <input type="hidden" name="file_ids[]" value="<?php echo ($one['file_id']); ?>" />
                <div class="form-inline"><label class="control-label">名称</label> <input type="text" class="form-control input-sm" name="file_title<?php echo ($one['file_id']); ?>" value="<?php echo ($one['title']); ?>"></div>
                <div class="form-inline"><label class="control-label">备注</label> <textarea name="file_summary<?php echo ($one['file_id']); ?>" type="text" class="form-control input-sm"><?php echo ($one['summary']); ?></textarea>
              </td>
              <td>
                <a href="javascript:void(0);" onclick="remove_file(<?php echo ($one['file_id']); ?>);"><i class="fa fa-times fa-2x text-danger"></i></a>
              </td>
            </tr><?php endforeach; endif; endif; ?>
      </table>
    </div>
</div>

<script type="text/javascript">

    $(document).ready(function() {

      //初始化 因为要和下面一个一个增加的方式配合，不能一齐用class触发
      <?php if(is_array($files)): foreach($files as $key=>$file): ?>trigger_sort(<?php echo ($file['file_id']); ?>);<?php endforeach; endif; ?>

      var max_up_size = parseInt(("<?php echo C('DOWNLOAD_UPLOAD.maxSize');?>" / 1024/1014));
      setTimeout(function () {
        $('#file-upload').uploadify({
            'swf' : "/Public/Static/uploadify/uploadify.swf",
            "uploader"        : "<?php echo U('File/upload',array('session_id'=>session_id()));?>",
            "buttonText"      : "上传文件(可多选，单个文件最大"+max_up_size+"M)",
            'queueID'         : 'file-custom-queue',
            "fileObjName"     : "download",
            "width"           : 234,
            'multi' : true,
            'onUploadSuccess' : function(file, data) {
              var data = $.parseJSON(data);

              if(data.status){

                  var idx = data.id;
                  var str = '<tr class="filecouldsort" id="trfile'+idx+'">';
                  str += '<td class="first"><i class="fi fi-'+data.ext+' fa-5x"></i></td><input type="hidden" name="file_ids[]" value="'+idx+'">';
                  str += '<td class="infos"><div class="form-inline"><label class="control-label">标题</label> <input type="text" class="form-control input-sm" name="file_title'+idx+'" value="'+data.info+'"></div>';
                  str += '<div class="form-inline"><label class="control-label">备注</label> <textarea name="file_summary'+idx+'" type="text" class="form-control input-sm"></textarea></td>';
                  str += '<td><a href="javascript:void(0);" onclick="remove_file('+ idx +');"><i class="fa fa-times fa-2x text-danger"></i></a></td></tr>';

                  $("#file-table").prepend(str);

                  // 触发新文件和原来文件的排序
                  trigger_sort(idx);

              } else {
                  alert('上传有误，请联系管理员：');
              }
            },
        });
      },0);
  });

  function remove_file(id) {
      if(!id) return;
      if(window.confirm("是否确认删除该文件？")) {
          $("#trfile" + id).remove();
      }
  }

  function trigger_sort(id) {
      if(!id) return;
      sort_selector = 'id="trfile'+id+'"';
      // $("#gallery-table").dragsort("destroy");
      $("#file-table").dragsort({ dragSelector: 'tr['+sort_selector+']', placeHolderTemplate: '<table id="gallery-table"><tr class="filecouldsort"></tr>' });
  }

</script>
 </td>
              </tr><?php break;?>
            <?php case "latlng": ?><tr>
                <td class="item-label"><?php echo ($field["title"]); ?></td>
                <td><script src="http://api.map.baidu.com/api?v=1.4" type="text/javascript"></script>
<div class="">
    <input type="text" onclick="map_show();" id="position" class="form-control span2 input-sm" name="latlng" value="<?php echo ($content['latlng']); ?>" placeholder="填写完地址后，位置会自动标注在地图上">
</div>

<script type="text/javascript">
    function map_show(){
        X.post("/Manage/Content/ajax_dialog_map_position");
    }
</script> </td>
              </tr><?php break;?>
            <?php default: ?>
            <?php echo form_block($key, $field, $content[$key]); endswitch; endforeach; endif; ?>

        <?php if($extend_fields): ?><tr class="info">
            <td colspan="2">
              <input type="hidden" name="extend_field_keys" value="<?php echo implode(',',array_keys($extend_fields));?>"/>
              <i class="fa fa-angle-double-right"></i>扩展字段（<?php echo ($category['extend']['title']); ?>）
              <?php if($category['extend']['description']): ?><div style="padding:10px 0 0 12px;" class="text-danger">扩展备注：<?php echo nl2br($category['extend']['description']);?></div><?php endif; ?>
            </td>
          </tr>
          <?php if(is_array($extend_fields)): foreach($extend_fields as $key=>$field): echo form_block('_extend_'.$key, $field, $content['extend'][$key]); endforeach; endif; endif; ?>
      </table>
      
      <div class="form-group form-actions">
        <input type="hidden" name="id" value="<?php echo ($content['id']); ?>">
        <input type="hidden" name="model_id" value="<?php echo ($model_id); ?>">
        <div class="col-md-9 col-md-offset-2">
          <button type="submit" class="btn btn-sm btn-success" data-loading-text="保存中..."><i class="hi hi-ok"></i>保存</button>
        </div>
      </div>
    </form>
  </div>
</div>
<script type="text/javascript" src="/Public/Static/js/location.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
      // 如果没有onclick没有的话，就不能在当前栏目下创建文章
      var current_cat_id = $("#category_id").val();
      if(current_cat_id) {
        var on = $("#"+current_cat_id).attr('onclick');
      }
      if(!current_cat_id || !on || on == undefined) {
        $('#category-select-wrapper').show();
      }

      // source link不能在循环中赋值，这里补充一下
      $('#source_link').val("<?php echo ($content['source_link']); ?>");
      <?php if($content['subtitle']): ?>$('#trsubtitle').show();<?php endif; ?>

      // video preview
      <?php if($content['video_url']): if(strpos($content['video_url'],'.swf') > 0): ?>var video_html = '<div><embed src="<?php echo ($content["video_url"]); ?>" quality="high" width="370" height="250" align="middle" allowScriptAccess="sameDomain" allowFullscreen="true" type="application/x-shockwave-flash"></embed></div>';
        <?php else: ?>
          var video_html = '<iframe frameborder="0" width="370px" height="250px" src="<?php echo ($content["video_url"]); ?>" allowfullscreen></iframe>';<?php endif; ?>
        $('#video_url').after(video_html);<?php endif; ?>

      // tags - typeahead
      $("#tags").tokenInput("<?php echo U('tag/ajax_search_for_input');?>", {
        max_size: 2,
        theme: "facebook",
        hintText: "请输入标签",
      });
      <?php if(is_array($content['tags'])): foreach($content['tags'] as $key=>$tag): ?>id = "<?php echo ($tag["tag_id"]); ?>";
        name = "<?php echo ($tag["name"]); ?>";
        $("#tags").tokenInput("add", {id : id, name : name});<?php endforeach; endif; ?>


      $('#author_name').typeahead({
        name: 'name',
        remote : '<?php echo U('author/ajax_search_for_input');?>?query=%QUERY',
      });
      $('#trauthor_name span.twitter-typeahead').css('float', 'left');

      // category select tree
      $('#category_name').click(function(e){
        $("#category-select-wrapper").toggle();
        e.stopPropagation();
      });

      // 配合上面的click函数，点击下拉框外面的时候关闭下拉框
      $(document).click(function(){
        $("#category-select-wrapper").hide();
      });


      // 定时发布
      var current_time = "<?php echo date('Y-m-d H:i');;?>";
      $('#publish_time').after('<div class="text-muted">默认不填为当前时间；选择当前时间之后的时间，则为定时发送</div>');
      $('#publish_time').blur(function(){
        if($('#publish_time').val()>current_time) {
          $('#status').val(3);
        }
      });

    });

    // 
    function select_category(category_id, category_name) {
      $("#category_id").val(category_id);
      $("#category_name").val(category_name);
      $("#category-select-wrapper").hide(); 
    }

    $('.is_menu').click(function() {
      $("#category_id").val('');
      $("#category_name").val('');
      alert('频道页不允许发布文档');
    })

    <?php if(!$content['id']): ?>$('#title').blur(function(){
        var title = $(this).val();
        $.post('<?php echo U("ajax_find_repeat");?>',{title:title},function(data) {
          if(data) {
            var titleTip = $('#title-tip');
            if(titleTip.length == 0) {
              $('#title').parent('td').append('<div id="title-tip" style="clear:both"></div>');
            }
            $('#title-tip').html('这个文章的标题已经存在，可能会重复发布。<a href="/content/'+data.id+'" target="_blank">查看文章</a>');
          } else {
            var titleTip = $('#title-tip');
            if(titleTip.length !=0) {
              titleTip.remove();
            }
          }
        },'json')
      })<?php endif; ?>    
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