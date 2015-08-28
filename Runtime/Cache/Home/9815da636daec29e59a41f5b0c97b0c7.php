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
    <div class="cat-title-block">
    <div class="container" >
        <?php echo ($category['title']); ?>
    </div>
</div>


<div class="container">
    <div class="listfull">
        <ul class="catblock">
            <?php  $childs = D("Category")->getChildren($category['id']); ?>
             <?php if(is_array($childs)): foreach($childs as $key=>$child): ?><li>
                    <h4>
                        <?php echo ($child['title']); ?>
                        <a href="/category/<?php echo ($child['id']); ?>" title="查看更多<?php echo ($child['title']); ?>" class="more">更多 ››</a>
                    </h4>
                    <?php $pages = D("Content")->getPagesByTypeId($child['id'],1,8); ?>
                    <ul class="simple">
                        <?php if(is_array($pages)): foreach($pages as $key=>$one): ?><li><a href="<?php echo ($one['link']); ?>"><?php echo ($one['title']); ?></a></li><?php endforeach; endif; ?>
                    </ul>
                </li><?php endforeach; endif; ?>
        </ul>
        <div class="clearfix"></div>
    </div>
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