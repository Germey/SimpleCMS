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
<link rel="shortcut icon" href="/Application/Home/View/lingshan/styles/images/favicon.ico" />
<link href="/Public/Static/bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="/Application/Home/View/lingshan/styles/css/style.css" rel="stylesheet">
<link href="/Application/Home/View/lingshan/styles/css/gallery.css" rel="stylesheet">
<script type="text/javascript" src="/Application/Home/View/lingshan/styles/js/jquery.js"></script>
<script type="text/javascript" src="/Application/Home/View/lingshan/styles/js/jquery.gallery.js"></script>
<script type="text/javascript" src="/Application/Home/View/lingshan/styles/js/modernizr.custom..js"></script>
<script type="text/javascript" src="/Application/Home/View/lingshan/styles/js/main.js"></script>
<script type="text/javascript" src="/Public/Static/bootstrap/js/bootstrap.min.js"></script>
</head>
<body>

<div class="top">
    <div class="container">
        <div class="logo"><a href="/"><img src="/Application/Home/View/lingshan/styles/images/logo.png" alt="<?php echo C('site_title');?>"/></a></div>
        <div class="top_nav">
            <div class="list">
                <?php $menu = D('Category')->getTree(0,'',array('is_menu'=>1));if(false)var_dump($menu);echo '<ul class="ul_level1 nav nav-pills nav_ul dropdown">';?><li class="banner_index <?php if($index): ?>active<?php endif; ?>" ><a href="/" >首页</a></li><?php if(is_array($menu)): $i = 0; $__LIST__ = $menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$lev1): $mod = ($i % 2 );++$i;?><li class="dropdown <?php if( $root_navbar['id'] == $lev1["id"] ): ?>active<?php endif; ?> banner_<?php echo ($lev1["name"]); ?>"><?php if($lev1["type"] == 3): ?><a href="<?php echo ($lev1["extralink"]); ?>" target="_blank"><?php echo ($lev1["title"]); ?></a><?php else: ?><a href="#" <?php if($lev1['link_target']): ?>onclick="window.open('<?php echo ($lev1["link"]); ?>')" <?php else: ?> onclick="window.location.href='<?php echo ($lev1["link"]); ?>'"<?php endif; ?>  class="dropdown-toggle" data-toggle="dropdown" id="drop<?php echo ($lev1['id']); ?>"><?php echo ($lev1["title"]); ?></a><?php endif; if($lev1['_']): ?><ul class="dropdown-menu" role="menu" aria-labelledby="drop<?php echo ($lev1['id']); ?>"><?php if(is_array($lev1['_'])): foreach($lev1['_'] as $key=>$lev2): ?><li><?php if($lev2["type"] == 3): ?><a href="<?php echo ($lev2["extralink"]); ?>" target="_blank"><?php echo ($lev2["title"]); ?></a><?php else: ?><a href="<?php echo ($lev2["link"]); ?>" <?php if($lev2['link_target']): ?>target='_blank'<?php endif; ?> ><?php echo ($lev2["title"]); ?></a><?php endif; ?></li><?php endforeach; endif; ?></ul><?php endif; ?></li><?php endforeach; endif; else: echo "" ;endif; echo "</ul>"; ?>
            </div>
        </div>
    </div>
</div>

    <div class="cat-title-block">
    <div class="container" >
        <?php echo ($category['title']); ?>
    </div>
</div>


<div class="container detail">
    <div class="listleft">
        <?php
 $bread = D('Category')->getParents($category['id']); $bread = array_reverse($bread); if($info['parent_id']) { $bread[] = array('title'=>$info['parent']['title'], 'link'=>$info['parent']['link']); } if($info) { $bread[] = array('title'=>'正文'); } $br_count = count($bread); ?>

<ul class="breadcrumb">
    <li><a href="/">首页</a><span class="divider">/</span></li>
    <?php if(is_array($bread)): foreach($bread as $k=>$one): if($k == $br_count-1): ?><li class="active"><?php echo ($one['title']); ?></li>
        <?php else: ?>
            <li><a href="<?php echo ($one['link']); ?>"><?php echo ($one['title']); ?></a><span class="divider">/</span></li><?php endif; endforeach; endif; ?>
</ul>

        <div class="main-content">
            <div class="info-head text-center">
                <h4><?php echo ($info['title']); ?></h4>
            </div>

            <?php if($info['source_link']): ?><p><small>
                    <b>网站：</b>
                    <a href="<?php echo ($info['source_link']); ?>" target="_blank"><?php echo ($info['source_link']); ?></a>
                </small></p><?php endif; ?>
            <?php if($info['tags']): ?><p><small>
                    <b>标签：</b>
                    <?php if(is_array($info['tags'])): foreach($info['tags'] as $key=>$t): ?><a style="color: #3a87ad" href="/category/<?php echo ($info['category_id']); ?>?stid=<?php echo ($t['tag_id']); ?>"><?php echo ($t['name']); ?></a>&nbsp;&nbsp;<?php endforeach; endif; ?>
                </small></p><?php endif; ?>

            <?php if($info['summary']): ?><blockquote>
                  <?php echo nl2br($info['summary']);?>
              </blockquote><?php endif; ?>

            <div class="info-content">
                <?php echo ($info['content']); ?>
            </div>

        </div>
    </div>

    <div class="listright">
        <div class="list-box">
            <div class="list-box-head">相关文章</div>
            <ul class="simple">            
              <?php if( $category['id'] ) { $child=D('Category')->getChildrenId($category['id'],true); }else { $child=D('Category')->getField('id',true); };if(false)$filter['weight']=false;if(false)$filter['tag_id']=false;if(true)$count = D('Content')->getPagesByTypeId($child, 0, 0,$filter, true);if(true)list($pagesize, $page_num, $pagestring) = pagestring($count, 6);if(true)$pages = D('Content')->getPagesByTypeId($child, $page_num, $pagesize,$filter,false,false,true);else $pages = D('Content')->getPagesByTypeId($child, 1, 6,$filter,false,false,true,false);if(false)var_dump($pages); if(is_array($pages)): $i = 0; $__LIST__ = $pages;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$one): $mod = ($i % 2 );++$i;?><li><a href="<?php echo ($one['link']); ?>"><?php echo get_short($one['title'],28);?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
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
        <div class="logo">
            <img src="/Application/Home/View/lingshan/styles/images/logo-w.png" />
        </div>
        <div class="friend-link">
            <p>友情链接：<a>灵山胜境</a></p>
        </div>
        <div class="copyright">
            <p>Copyright © <?php echo C('site_copyright');?> <a href="<?php echo C('site_link');?>"><?php echo C('site_link');?></a> All Rights Reserved</p>
        </div>
    </div>
</div>
<?php echo D('Config')->getConfigValue('analytics');?>
<body>
</html>