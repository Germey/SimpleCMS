<?php if (!defined('THINK_PATH')) exit();?><meta charset="UTF-8">
<?php if($info): ?><title><?php echo ($info['title']); ?>-<?php echo C('site_title');?></title>
<?php elseif($category): ?>
    <title><?php echo ($category['title']); ?>-<?php echo C('site_title');?></title>
<?php else: ?>
    <title><?php echo C('site_title');?></title><?php endif; ?>
<?php if($info): ?><meta name="description" content="<?php echo ($info['title']); ?>" />
<meta name="keywords" content="<?php echo ($info['title']); ?>" />
<?php elseif($category): ?>
    <?php if($category['keywords']): ?><meta name="description" content="<?php echo ($category['keywords']); ?>" />
    <?php else: ?>
    <meta name="description" content="<?php echo ($category['title']); ?>" /><?php endif; ?>

    <?php if($category['description']): ?><meta name="description" content="<?php echo ($category['description']); ?>" />
    <?php else: ?>
    <meta name="description" content="<?php echo ($category['title']); ?>" /><?php endif; ?>
<?php else: ?>
<meta name="description" content="<?php echo C('site_description');?>" />
<meta name="keywords" content="<?php echo C('site_keyword');?>" /><?php endif; ?>

<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<link rel="shortcut icon" href="/Application/Home/View/bnu1eastwest/styles/css/images/favicon.ico" />
<link href="/Public/Static/bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="/Application/Home/View/bnu1eastwest/styles/css/main.css" rel="stylesheet">
<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
<script src="/Public/Static/bootstrap/js/html5shiv.js"></script>
<![endif]-->

<!--[if lt IE 9]>
<script type="text/javascript" src="/Public/Static/jquery-1.10.2.min.js"></script>
<![endif]-->
<!--[if gte IE 9]><!-->
<script type="text/javascript" src="/Public/Static/jquery-2.0.3.min.js"></script>
<script type="text/javascript" src="/Public/Static/bootstrap/js/bootstrap.min.js"></script>
<!--<![endif]-->
<!-- 页面header钩子，一般用于加载插件CSS文件和代码 -->


    <div class="top">
        <div class="head_bg">
            <div class="container" style="position:relative">
                <a class="logo" href="/"><img src="/Application/Home/View/bnu1eastwest/styles/css/images/logo.png" alt="<?php echo C('site_title');?>"/></a>
                <div class="pull-right quicklink">
                    <p><a href="/category/about">关于论坛</a></p>
                    <p><a href="/category/contact">联系我们</a></p>
                    <p><a href="/category/english">English</a></p>
                </div>
            </div>
        </div>
        <div class="top_nav">
            <div class="container">
                <div class="pull-left"><?php $menu = D('Category')->getTree(0,'',array('is_menu'=>1));if(false)var_dump($menu);echo '<ul class="ul_level1 nav nav-pills nav_ul dropdown">';?><li class="menu-home <?php if($index): ?>active<?php endif; ?>"  ><a href="/" >首页</a></li><?php if(is_array($menu)): $i = 0; $__LIST__ = $menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$lev1): $mod = ($i % 2 );++$i;?><li <?php if( $root_navbar['id'] == $lev1["id"] ): ?>class="active"<?php endif; ?> id="menu-cat-<?php echo ($lev1["id"]); ?>"><?php if($lev1["type"] == 3): ?><a href="<?php echo ($lev1["extralink"]); ?>" <?php if($lev1['link_target']): ?>target='_blank'<?php endif; ?> ><?php echo ($lev1["title"]); ?></a><?php else: ?><a href="<?php echo ($lev1['link']); ?>" <?php if($lev1['link_target']): ?>target='_blank'<?php endif; ?> ><?php echo ($lev1["title"]); ?></a><?php endif; ?></li><?php endforeach; endif; else: echo "" ;endif; echo "</ul>"; ?></div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        // make the last nav without margin-right
        jQuery(document).ready(function() {
            $('.top_nav .pull-left ul li:last-child').css({"margin-right":0});
        });
    </script>
 
    <script type="text/javascript" src="/Application/Home/View/bnu1eastwest/styles/js/tab.js"></script>
<script type="text/javascript" src="/Public/Static/jquery.jcarousel/jquery.jcarousel.min.js"></script>
<link rel="stylesheet" type="text/css" href="/Public/Static/jquery.jcarousel/skin.css" />

<script type="text/javascript" src="/Public/Static/jquery.gallery/jquery.ad-gallery.js"></script>
<link rel="stylesheet" type="text/css" href="/Public/Static/jquery.gallery/jquery.ad-gallery.css" />


<script type="text/javascript">
  $(function(){
  new $.Tab({
    target: $('#js_banner_img li'),
    effect: 'slide3d',
    animateTime: 1000,
    stay: 13500,
    autoPlay: true,
    merge: true,
    prevBtn: $('#js_banner_pre'),
    nextBtn: $('#js_banner_next')
  });
  $('.fx_banner').hover(function(){
    $('.fx_banner_common').show();
  },function(){
    $('.fx_banner_common').hide();
  })
});
</script>    
<div class="main container">

    <div class="content-box">
        <div class="box-title">最新消息</div>
        <div id="js_banner" class="fx_banner">
          <ul  id="js_banner_img" class="fx_banner_img clear">
            <?php if( 45 ) { $child=D('Category')->getChildrenId(45,true); }else { $child=D('Category')->getField('id',true); };if(false)$filter['weight']=false;if(false)$filter['tag_id']=false;if(false)$count = D('Content')->getPagesByTypeId($child, 0, 0,$filter, true);if(false)list($pagesize, $page_num, $pagestring) = pagestring($count, 5);if(false)$pages = D('Content')->getPagesByTypeId($child, $page_num, $pagesize,$filter,false,false,true);else $pages = D('Content')->getPagesByTypeId($child, 1, 5,$filter,false,false,true,false);if(false)var_dump($pages); if(is_array($pages)): $i = 0; $__LIST__ = $pages;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$one): $mod = ($i % 2 );++$i;?><li>
                <div class="fx_banner_inner fx_grid_c1">
                  <div class="child child0 main-img" data-z="1">
                  <table>                  
                        <tr>
                            <td class="img"><a href="<?php echo ($one['link']); ?>" target="_blank"><img src="<?php echo thumb($one['thumb'],500,300);?>" alt="<?php echo ($one['title']); ?>"/></a></td>
                            <td class="text">
                                <h5><a href="<?php echo ($one['link']); ?>"><?php echo ($one['title']); ?></a></h5>
                                <div class="desc"><?php echo get_short($one['summary'],480);?></div>
                            </td>
                        </tr>
                  </table>
                  </div>
                </div>
              </li><?php endforeach; endif; else: echo "" ;endif; ?>
          </ul>
          <div class="fx_banner_common fx_grid_c1">
            <a ytag="30000" id="js_banner_pre" href="javascript:;" class="fx_banner_pre"></a>
            <a ytag="30010" id="js_banner_next" href="javascript:;" class="fx_banner_next"></a>
          </div>
        </div>
        <div class="more"><a href="/category/45">查看更多</a></div>
    </div>

    <div class="content-box home_guests">
        <div class="box-title">发言嘉宾</div>
        <ul class="jcarousel-skin-tango">
            <?php if( 188 ) { $child=D('Category')->getChildrenId(188,true); }else { $child=D('Category')->getField('id',true); };if(false)$filter['weight']=false;if(false)$filter['tag_id']=false;if(false)$count = D('Content')->getPagesByTypeId($child, 0, 0,$filter, true);if(false)list($pagesize, $page_num, $pagestring) = pagestring($count, 15);if(false)$pages = D('Content')->getPagesByTypeId($child, $page_num, $pagesize,$filter,false,false,true);else $pages = D('Content')->getPagesByTypeId($child, 1, 15,$filter,false,false,true,false);if(false)var_dump($pages); if(is_array($pages)): $i = 0; $__LIST__ = $pages;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$one): $mod = ($i % 2 );++$i;?><li>
                    <p><a href="<?php echo ($one['link']); ?>" title="<?php echo ($one['title']); ?>"><img src="<?php echo thumb($one['thumb'],170,130);?>" /></a></p>
                    <div><b><?php echo ($one['title']); ?></b></div>
                    <div><?php echo ($one['subtitle']); ?></div>
                </li><?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
        <div class="clearfix"></div>
        <div class="more"><a href="/category/188">查看更多</a></div>
    </div>


    <div class="content-box home_focus">
        <div class="box-title">论坛聚焦</div>
        <ul class="jcarousel-skin-tango">
            <?php if( 53 ) { $child=D('Category')->getChildrenId(53,true); }else { $child=D('Category')->getField('id',true); };if(false)$filter['weight']=false;if(false)$filter['tag_id']=false;if(false)$count = D('Content')->getPagesByTypeId($child, 0, 0,$filter, true);if(false)list($pagesize, $page_num, $pagestring) = pagestring($count, 9);if(false)$pages = D('Content')->getPagesByTypeId($child, $page_num, $pagesize,$filter,false,false,true);else $pages = D('Content')->getPagesByTypeId($child, 1, 9,$filter,false,false,true,false);if(false)var_dump($pages); if(is_array($pages)): $i = 0; $__LIST__ = $pages;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$one): $mod = ($i % 2 );++$i;?><li>
                    <p><a href="<?php echo ($one['link']); ?>" title="<?php echo ($one['title']); ?>"><img src="<?php echo thumb($one['thumb'],290,200);?>" /></a></p>
                    <div style="margin-bottom:4px"><b><?php echo ($one['title']); ?></b></div>
                    <div><?php echo get_short($one['summary'],120);?></div>
                </li><?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
        <div class="clearfix"></div>
        <div class="more"><a href="/category/53">查看更多</a></div>
    </div>

    <table><tr>
        <td style="width:380px;vertical-align: top;">
            <div class="content-box video-box">
                <div class="box-title">视 频</div>
                <?php if( 192 ) { $child=D('Category')->getChildrenId(192,true); }else { $child=D('Category')->getField('id',true); };if(false)$filter['weight']=false;if(false)$filter['tag_id']=false;if(false)$count = D('Content')->getPagesByTypeId($child, 0, 0,$filter, true);if(false)list($pagesize, $page_num, $pagestring) = pagestring($count, 1);if(false)$pages = D('Content')->getPagesByTypeId($child, $page_num, $pagesize,$filter,false,false,true);else $pages = D('Content')->getPagesByTypeId($child, 1, 1,$filter,false,false,true,false);if(false)var_dump($pages); if(is_array($pages)): $i = 0; $__LIST__ = $pages;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$video): $mod = ($i % 2 );++$i;?><img src="<?php echo thumb($video['thumb'],440,300);?>" alt="<?php echo ($video['title']); ?>"/>
                    <div data-toggle="modal" class="play" href="#video_model"></div>
                    <div class="des">
                        <h5><?php echo ($video['title']); ?></h5>
                        <p><?php echo get_short($video['summary'],180);?></p>
                    </div><?php endforeach; endif; else: echo "" ;endif; ?>
                <div class="more"><a href="/category/192">查看更多</a></div>
            </div>
        </td>
        <td style="padding-left:20px;width:600px;vertical-align: top;">
            <div class="content-box agenda-box">
                <div class="box-title">论坛议程</div>
                <?php $agenda = M('Category')->getByName('agenda-home');?>
                <div class="des">
                  <?php echo ($agenda['content']); ?>
                </div>
            </div>            
        </td>
    </tr></table>

    <div class="content-box">
      <div class="box-title">精彩瞬间</div>
      <?php $images = D('Banner')->getBannerByName('jingcai'); $myheight = C('custom_jingcai_height'); if(!$myheight) $myheight = 600; ?>
      <div class="ad-gallery">
        <div class="ad-image-wrapper" style="height:<?php echo ($myheight); ?>px">
        </div> 
        <div class="box-control">  
          <div class="ad-controls"></div>
          <div id="descriptions"></div>
          <div class="clear"></div>
        </div>
        <div class="ad-nav">   
          <div class="ad-thumbs">   
            <ul class="ad-thumb-list">   
              <?php if(is_array($images)): foreach($images as $k=>$one): ?><li><a href="<?php echo ($one['path']); ?>">
                    <img src="<?php echo thumb($one['path'],120,80);?>" class="image<?php echo ($one['id']); ?>" alt="<?php echo nl2br($one['summary']);?>" longdesc="<?php echo ($one['link']); ?>"/>   
                  </a>
                </li><?php endforeach; endif; ?>
            </ul>
          </div>
        </div> 
      </div>
    </div>


    <div class="content-box">
      <div class="box-title">主办机构</div>
      <?php if( 190 ) { $child=D('Category')->getChildrenId(190,true); }else { $child=D('Category')->getField('id',true); };if(false)$filter['weight']=false;if(false)$filter['tag_id']=false;if(false)$count = D('Content')->getPagesByTypeId($child, 0, 0,$filter, true);if(false)list($pagesize, $page_num, $pagestring) = pagestring($count, 6);if(false)$pages = D('Content')->getPagesByTypeId($child, $page_num, $pagesize,$filter,false,false,true);else $pages = D('Content')->getPagesByTypeId($child, 1, 6,$filter,false,false,true,false);if(false)var_dump($pages); if(is_array($pages)): $i = 0; $__LIST__ = $pages;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$one): $mod = ($i % 2 );++$i;?><a href="/category/190" title="<?php echo ($one['title']); ?>" style="margin:0 40px"><img src="<?php echo ($one['thumb']); ?>" style="height:120px" /></a><?php endforeach; endif; else: echo "" ;endif; ?>
    </div>

    <div class="content-box">
      <div class="box-title" style="width:175px">2014资助发起机构</div>
      <?php if( 191 ) { $child=D('Category')->getChildrenId(191,true); }else { $child=D('Category')->getField('id',true); };if(false)$filter['weight']=false;if(false)$filter['tag_id']=false;if(false)$count = D('Content')->getPagesByTypeId($child, 0, 0,$filter, true);if(false)list($pagesize, $page_num, $pagestring) = pagestring($count, 6);if(false)$pages = D('Content')->getPagesByTypeId($child, $page_num, $pagesize,$filter,false,false,true);else $pages = D('Content')->getPagesByTypeId($child, 1, 6,$filter,false,false,true,false);if(false)var_dump($pages); if(is_array($pages)): $i = 0; $__LIST__ = $pages;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$one): $mod = ($i % 2 );++$i;?><a href="/category/191" title="<?php echo ($one['title']); ?>" style="margin:0 40px"><img src="<?php echo ($one['thumb']); ?>" style="height:120px" /></a><?php endforeach; endif; else: echo "" ;endif; ?>      
    </div>

</div>

<script type="text/javascript"> 

    jQuery(document).ready(function() {

      $('.jcarousel-skin-tango').jcarousel({ auto: 4,
        wrap: 'last',
        initCallback: mycarousel_initCallback});
      
      function mycarousel_initCallback(carousel) {

          carousel.buttonNext.bind('click', function() {
              carousel.startAuto(0);
          });

          carousel.buttonPrev.bind('click', function() {
              carousel.startAuto(0);
          });

          carousel.clip.hover(function() {
              carousel.stopAuto();
          }, function() {
              carousel.startAuto();
          });
      };
    });


  $(function(){
    $('.ad-gallery').adGallery({description_wrapper: $('#descriptions'),update_window_hash:false});
    $('.ad-prev-image').hide();
    $('.ad-next-image').hide();
  });

</script> 


<div id="video_model" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 id="myModalLabel"><?php echo ($video['title']); ?></h4>
  </div>
  <div class="modal-body" style="padding:0">
    <embed src="<?php echo ($video['video_url']); ?>" quality="high" width="560" height="400" align="middle" allowScriptAccess="sameDomain" allowFullscreen="true" type="application/x-shockwave-flash"></embed></div>
  </div>
</div>

<?php $f = array('about','contact','copyright', 'disclaimer','agenda', 'mainowner', 'helpowner'); $bottom_menu = D('Category')->getCategoryById($f); ?>

<div id="footer">
    <div class="footer-nav container">
        <?php if(is_array($bottom_menu)): foreach($bottom_menu as $key=>$one): ?><a href="<?php echo ($one['link']); ?>" title="<?php echo ($one['title']); ?>"><?php echo ($one['title']); ?></a><?php endforeach; endif; ?>
    </div>
    <div class="footer-bg">
        <div class="container">
            <p>Copyright ©<?php echo date('Y');?> <a href="http://www.bnu1.org" target="_blank">北京师范大学中国公益研究院</a> 版权所有&nbsp;&nbsp;<?php echo C('site_icp');?></p>
            <p>
                邮箱: <a mailto="<?php echo C('site_contact_email');?>"><?php echo C('site_contact_email');?></a>&nbsp;&nbsp;
                联系电话：<?php echo C('site_contact_phone');?>&nbsp;&nbsp;
                技术支持：<a href="http://justering.com" target="_blank">佳信德润</a></p>
        </div>
    </div>
</div>

</body>
</html>