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
    <?php
 $bread = D('Category')->getParents($category['id']); $bread = array_reverse($bread); if($info['parent_id']) { $bread[] = array('title'=>$info['parent']['title'], 'link'=>$info['parent']['link']); } if($info) { $bread[] = array('title'=>'正文'); } $br_count = count($bread); ?>

<ul class="breadcrumb">
    <li><a href="/">首页</a><span class="divider">/</span></li>
    <?php if(is_array($bread)): foreach($bread as $k=>$one): if($k == $br_count-1): ?><li class="active"><?php echo ($one['title']); ?></li>
        <?php else: ?>
            <li><a href="<?php echo ($one['link']); ?>"><?php echo ($one['title']); ?></a><span class="divider">/</span></li><?php endif; endforeach; endif; ?>
</ul>
    <div class="listleft">
        <?php
 $cat_ids = D("Category")->getChildrenId($category['id']); $cat_ids[] = $category['id']; $tags = D('Tag')->getTagsWeight($cat_ids); $stid = intval($_GET['stid']); ?>

<?php if($tags): ?><form action="/category/<?php echo ($category['id']); ?>" method="get">
        <a class="label label-tag <?php echo ($stid?'':'label-select'); ?>" href="?stid=0">全部标签</a>
        <?php if(is_array($tags)): foreach($tags as $key=>$one): ?><a class="label label-tag <?php echo ($stid==$one['tag_id']?'label-select':''); ?>" href="?stid=<?php echo ($one['tag_id']); ?>">
                <?php echo ($one['name']); ?>&nbsp;<b>[<span title="对应文章数"><?php echo ($one['count']); ?></span>]</b>
            </a><?php endforeach; endif; ?>
    </form><?php endif; ?>
<div class="clear"></div>

<?php if($category['banner']): ?><div style="margin-bottom: 20px"><img src="<?php echo thumb($category['banner'],740,0);?>" /></div><?php endif; ?>
        <ul class="newsblock">
            <?php if( $category['id'] ) { $child=D('Category')->getChildrenId($category['id'],true); }else { $child=D('Category')->getField('id',true); };if(false)$filter['weight']=false;if($_GET['stid'])$filter['tag_id']=$_GET['stid'];if(true)$count = D('Content')->getPagesByTypeId($child, 0, 0,$filter, true);if(true)list($pagesize, $page_num, $pagestring) = pagestring($count, 10);if(true)$pages = D('Content')->getPagesByTypeId($child, $page_num, $pagesize,$filter,false,false,true);else $pages = D('Content')->getPagesByTypeId($child, 1, 10,$filter,false,false,true,false);if(false)var_dump($pages); if(is_array($pages)): $i = 0; $__LIST__ = $pages;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$one): $mod = ($i % 2 );++$i; if(!$key++): ?><li class="firstline">
                        <div class="l">
                            <a href="<?php echo ($one['link']); ?>"><img src="<?php echo thumb($one['thumb'],358,240);?>" /></a></div>
                        <div class="r">
                            <p class="date"><?php echo str_replace('-', ' / ', substr($one['publish_time'],5,5)) ;?></p>
                            <h5><a href="<?php echo ($one['link']); ?>"><?php echo ($one['title']); ?></a></h5>
                            <p class="summary"><?php echo ($one['summary']?get_short($one['summary'], 150):get_short(strip_tags($one['content']),150)); ?></p>
                            <?php if($one['tags']): ?><b>标签：</b>
                                <?php if(is_array($one['tags'])): foreach($one['tags'] as $key=>$t): ?><a style="color: #FFF" href="/category/<?php echo ($category['id']); ?>?stid=<?php echo ($t['tag_id']); ?>"><?php echo ($t['name']); ?></a>&nbsp;&nbsp;<?php endforeach; endif; endif; ?>
                        </div>
                    </li>
                <?php else: ?>
                    <li class="twocolumn" <?php if(($key+1)%2 == 0): ?>style="margin-right:0"<?php endif; ?> onclick="location='<?php echo ($one['link']); ?>'">
                        <p class="date"><?php echo str_replace('-', ' / ', substr($one['publish_time'],5,5)) ;?></p>
                        <h5><a href="<?php echo ($one['link']); ?>"><?php echo ($one['title']); ?></a></h5>
                        <p class="summary"><?php echo ($one['summary']?get_short($one['summary'], 130):get_short(strip_tags($one['content']),130)); ?></p>
                        <?php if($one['tags']): ?><b>标签：</b>
                            <?php if(is_array($one['tags'])): foreach($one['tags'] as $key=>$t): ?><a href="/category/<?php echo ($category['id']); ?>?stid=<?php echo ($t['tag_id']); ?>"><?php echo ($t['name']); ?></a>&nbsp;&nbsp;<?php endforeach; endif; endif; ?>                        
                    </li><?php endif; endforeach; endif; else: echo "" ;endif; ?>
        </ul>
        <div class="pagestring"><?php echo ($pagestring); ?></div>
        <div class="clearfix"></div>
    </div>

    <div class="listright">
        <div class="list-box">
    <div class="list-box-head"><?php echo ($category['parent_title']?$category['parent_title']:$category['title']); ?></div>
    <?php
 $childs = D('Category')->getChildren($category['parent']?$category['parent']['id']:$category['id']); ?>
    <?php if(is_array($childs)): foreach($childs as $key=>$one): ?><a href="/category/<?php echo ($one['id']); ?>">
            <div class="list-content <?php echo ($one['id']==$category['id']?'list-content-selected':''); ?>">
                <?php echo ($one['title']); ?>
            </div>
        </a><?php endforeach; endif; ?>
</div>

        <div class="list-box" style="text-align:center">
  <?php $ads = D('Banner')->getBannerByName('side_ads'); ?>
  <?php if(is_array($ads)): foreach($ads as $key=>$one): ?><div>
        <a href="<?php echo ($one['link']); ?>" target="_blank">
          <img src="<?php echo thumb($one['path'],225,0);?>" alt="<?php echo ($one['title']); ?>" style="margin-top: 15px; max-width: 225px;">
        </a>
      </div><?php endforeach; endif; ?>
</div>

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