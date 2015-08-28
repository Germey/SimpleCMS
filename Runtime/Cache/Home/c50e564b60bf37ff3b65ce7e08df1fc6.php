<?php if (!defined('THINK_PATH')) exit();?><!Doctype html><html xmlns=http://www.w3.org/1999/xhtml>
<head>
<meta charset="UTF-8">
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
<link rel="shortcut icon" href="/Application/Home/View/wuhandr/styles/css/images/favicon.ico" />
<link href="/Public/Static/bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="/Application/Home/View/wuhandr/styles/css/main.css" rel="stylesheet">
<script type="text/javascript" src="/Application/Home/View/wuhandr/styles/js/jquery.js"></script>
<script type="text/javascript" src="/Public/Static/bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
<div class="top">
    <div class="container text-center">
        <a class="logo" href="/"><img src="/Application/Home/View/wuhandr/styles/css/images/logo.png" alt="<?php echo C('site_title');?>"/></a>
        <div class="right-social">
          <a href="/category/english" class="efont" style="font-size: 15px;">English</a>&nbsp;&nbsp;
          <?php $socials = D('Banner')->getBannerByName('top_socials'); ?>
          <?php if(is_array($socials)): foreach($socials as $key=>$one): ?><a href="<?php echo ($one['link']); ?>" target="_blank" title="<?php echo ($one['title']); ?>">
                  <img src="<?php echo thumb($one['path']);?>" alt="<?php echo ($one['title']); ?>">&nbsp;
                </a><?php endforeach; endif; ?>
        </div>
        <form class="search" action="/search/index">
            <input name="skey" id="search"  class="span6" type="text" value="<?php echo ($skey); ?>" placeholder="搜索资源">
            <input type="image" class="sicon" title="搜索" alt="搜索" src="/Application/Home/View/wuhandr/styles/css/images/search.png">
            <div class="clear"></div>
        </form>
        <div class="span6 text-right" style="margin-left: 275px;">
            <?php $tops = D('Search')->getTopSearchKeys(5); ?>
            热搜词：<?php if(is_array($tops)): foreach($tops as $key=>$t): if($t['skey']): ?>&nbsp;&nbsp;<a class="searchtop" title="热搜词：<?php echo ($t['skey']); ?>" href="/search/index?skey=<?php echo ($t['skey']); ?>"><?php echo ($t['skey']); ?></a><?php endif; endforeach; endif; ?>
        </div>
    </div>
</div>
<div class="top_nav">
    <div class="container">
        <?php $menu = D('Category')->getTree(0,'',array('is_menu'=>1));if(false)var_dump($menu);echo '<ul class="ul_level1 nav nav-pills nav_ul dropdown">';?><li class="banner_index <?php if($index): ?>active<?php endif; ?>" ><a href="/" >首页</a></li><?php if(is_array($menu)): $i = 0; $__LIST__ = $menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$lev1): $mod = ($i % 2 );++$i;?><li class="dropdown <?php if( $root_navbar['id'] == $lev1["id"] ): ?>active<?php endif; ?> banner_<?php echo ($lev1["name"]); ?>"><?php if($lev1["type"] == 3): ?><a href="<?php echo ($lev1["extralink"]); ?>" target="_blank"><?php echo ($lev1["title"]); ?></a><?php else: ?><a href="#" <?php if($lev1['link_target']): ?>onclick="window.open('<?php echo ($lev1["link"]); ?>')" <?php else: ?> onclick="window.location.href='<?php echo ($lev1["link"]); ?>'"<?php endif; ?>  class="dropdown-toggle" data-toggle="dropdown" id="drop<?php echo ($lev1['id']); ?>"><?php echo ($lev1["title"]); ?></a><?php endif; if($lev1['_']): ?><ul class="dropdown-menu" role="menu" aria-labelledby="drop<?php echo ($lev1['id']); ?>"><?php if(is_array($lev1['_'])): foreach($lev1['_'] as $key=>$lev2): ?><li><?php if($lev2["type"] == 3): ?><a href="<?php echo ($lev2["extralink"]); ?>" target="_blank"><?php echo ($lev2["title"]); ?></a><?php else: ?><a href="<?php echo ($lev2["link"]); ?>" <?php if($lev2['link_target']): ?>target='_blank'<?php endif; ?> ><?php echo ($lev2["title"]); ?></a><?php endif; ?></li><?php endforeach; endif; ?></ul><?php endif; ?></li><?php endforeach; endif; else: echo "" ;endif; echo "</ul>"; ?>
    </div>
</div>
    <div class="main container">

  <?php  $carousels = D('Banner')->getBannerByName('home_carousels'); $carousel_rights = D('Banner')->getBannerByName('home_carousel_right'); ?>
  <table style="width: 100%">
    <tr>
      <td style="width:700px">
        <div id="myCarousel" class="carousel slide">
            <div class="carousel-inner">
              <?php if(is_array($carousels)): foreach($carousels as $key=>$one): ?><div class="item <?php if($key==0): ?>active<?php endif; ?>">
                  <div>
                    <a <?php if($one['link']): ?>href="<?php echo ($one['link']); ?>"<?php endif; ?> target="_blank"><img src="<?php echo thumb($one['path'],700, 360);?>"></a>
                    <?php if($one['title'] OR $one['summary']): ?><div class="carousel-caption">
                          <?php if($one['title']): ?><h4><?php echo ($one['title']); ?></h4><?php endif; ?>
                          <p><?php echo ($one['summary'] ? get_short($one['summary'],240) : get_short(strip_tags($one['content']),240)); ?></p>
                      </div><?php endif; ?>
                  </div>
              </div><?php endforeach; endif; ?>
            </div>
          <?php if(count($carousels)==1): else: ?>
            <a class="carousel-control left" href="#myCarousel" data-slide="prev">&lsaquo;</a>
            <a class="carousel-control right" href="#myCarousel" data-slide="next">&rsaquo;</a><?php endif; ?>
        </div>
      </td>
      <td class="carousel_right">
          <div class="block">
            <img src="<?php echo ($carousel_rights[0]['path']); ?>" />
            <div class="text-center">
              <p class="slogan"><?php echo nl2br($carousel_rights[1]['summary']);?><p>
              <p><a target="_blank" href="<?php echo ($carousel_rights[2]['link']); ?>" class="btn btn-primary"><?php echo ($carousel_rights[2]['title']); ?></a></p>
            </div>
          </div>
      </td>
    </tr>
  </table>

  <!-- home_style -->
  <?php  $home_style = C('custom_home_style'); $home_style = 0; ?>
  <?php if($home_style): ?><br />
    <?php $project_hints = D('Banner')->getBannerByName('project_hints'); ?>
    <ul class="modules_tab">
        <?php if(is_array($project_hints)): foreach($project_hints as $key=>$one): ?><li <?php if(($key+1)%4==0): ?>class="last"<?php endif; ?>>
            <a href="<?php echo ($one['link']); ?>">
              <div class="h"><?php echo ($one['title']); ?></div>
              <img title="<?php echo ($one['title']); ?>" alt="<?php echo ($one['title']); ?>" src="<?php echo thumb($one['path'],220,130);?>" />
            </a>
          </li><?php endforeach; endif; ?>
        <div class="clear"></div>
    </ul>  
  <?php else: ?>
    <?php  $cats = array(45, 53); ?>
    <?php if(is_array($cats)): foreach($cats as $key=>$cid): $cat = D("Category")->getById($cid); var_dump($cat); $child_ids = D("Category")->getChildrenId($cid); $pages = D("Content")->getPagesByTypeId($child_ids,1,8); ?>
      <br />
        <div class="box-title">
          <a href="/category/<?php echo ($cat['id']); ?>" title="查看更多<?php echo ($cat['title']); ?>"><?php echo ($cat['title']); ?> | <span class="efont"><?php echo ucfirst($cat['name']);?></span></a>
          </div>
      <ul class="simple">
        <?php if(is_array($pages)): foreach($pages as $key=>$one): ?><li><a href="/category/<?php echo ($one['category_id']); ?>"><b>[<?php echo ($one['category_name']); ?>]</b></a>&nbsp;<a href="<?php echo ($one['link']); ?>"><?php echo ($one['title']); ?></a></li><?php endforeach; endif; ?>
      </ul>
      <div class="clear"></div><?php endforeach; endif; ?>
    <div style="margin: 10px;"></div>
    <?php  $cats = array(188 => array('size'=>5, 'width'=>0, 'height'=>0), 231 => array('size'=>5, 'width'=>140, 'height'=>140), ); ?>
    <?php if(is_array($cats)): foreach($cats as $cid=>$attr): $cat = D("Category")->getById($cid); $child_ids = D("Category")->getChildrenId($cid); $pages = D("Content")->getPagesByTypeId($child_ids,1,$attr['size']); ?>
      <br /><div class="box-title"><a href="/category/<?php echo ($cat['name']); ?>" title="查看更多<?php echo ($cat['title']); ?>"><?php echo ($cat['title']); ?> | <span class="efont"><?php echo ucfirst($cat['name']);?></span></a></div>
      <table style="width:100%"><tr>
        <?php if(is_array($pages)): foreach($pages as $key=>$one): ?><td style="vertical-align: middle; text-align: center; padding: 0 15px;">
              <a target="_blank" href="<?php echo ($one['link']); ?>">
                <p><img src="<?php echo thumb($one['thumb'], $attr['width'], $attr['height']);?>" alt="<?php echo ($one['title']); ?>" style="max-height: 180px;" /></p> 
                <p><?php echo get_short($one['title'],16);?></p>
              </a>
            </td><?php endforeach; endif; ?>
      </tr></table><?php endforeach; endif; endif; ?>
</div>

<div id="footer">
    <div class="container">
        <div style="float: left; width: 400px;">        
            <p class='footer-nav'><?php echo C('custom_footer_navs');?></p>
            <p>Copyright ©<?php echo date('Y');?> <?php echo C('site_copyright');?></p>
            <p><?php echo C('site_icp');?> &nbsp;&nbsp;技术支持：<a href="http://justering.com" target="_blank">佳信德润</a>
            </p>
        </div>
        <div style="float:right; width: 600px;text-align: right;">
          <?php $links = D('Banner')->getBannerByName('friend_links'); ?>
          <?php if(is_array($links)): foreach($links as $key=>$one): ?><a href="<?php echo ($one['link']); ?>" target="_blank"><img src="<?php echo thumb($one['path'],0,100);?>" alt="<?php echo ($one['title']); ?>" /></a>&nbsp;&nbsp;<?php endforeach; endif; ?>
        </div>
    </div>
</div>
<?php echo D('Config')->getConfigValue('analytics');?>
<body>
</html>