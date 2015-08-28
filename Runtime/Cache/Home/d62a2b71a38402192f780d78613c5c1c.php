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
<link href="/Public/Static/bootstrap3/css/bootstrap.css" rel="stylesheet">
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
        <form class="search" action="/search/index">
            <div class="input"><input name="skey" id="search"  class="span6" type="text" value="<?php echo ($skey); ?>"></div>
            <div class="bt"><input type="image" class="sicon" title="搜索" alt="搜索" src="/Application/Home/View/lingshan/styles/images/search.png"></div>
            <div class="clear"></div>
        </form>
    </div>
</div>

    <div class="search-res margin-nav">
    <?php  $default_banner = D('Banner')->getBannerByName('default_banner'); $rand = rand(0,count($default_banner)-1); ?>
<?php if($category['banner']): ?><div class="banner" style="background-image:url('<?php echo thumb($category['banner'],500, 0);?>')">
    </div>
<?php elseif($category['parent']['thumb']): ?>
    <div class="banner" style="background-image:url('<?php echo thumb($category['parent']['thumb'], 500, 0);?>')">
    </div>
<?php elseif($default_banner): ?>
    <div class="banner" style="background-image:url('<?php echo thumb($default_banner[$rand]['path'], 500 ,0);?>')">
    </div>
<?php else: ?>
	<div class="banner" style="background-image:url('/Application/Home/View/lingshan/styles/images/default_banner.jpg')">
    </div><?php endif; ?>
    <div class="container">
        <div class="listfull">
            <div class="list-box">
                <div class="box-title">搜索关键字【<span class="a_color"><b><?php echo ($skey); ?></b></span>】结果有<?php echo ($all_count); ?>个</div>
                    <?php if($all_count): if(is_array($search_result)): foreach($search_result as $key=>$one): ?><div class="list-content">
                                <h4>
                                    <span title="栏目">【<?php echo ($one['category_name']); ?>】</span>
                                    <a href="<?php echo ($one['link']); ?>"><?php echo str_ireplace($skey,$replace,$one['title']);?></a>
                                    <span class="muted date"><?php echo substr($one['create_time'],0,10);?></span>
                                </h4>
                                <p>
                                    <?php if($one['tags']): ?><span>
                                            <i title="标签" class="icon icon-tag"></i>
                                            <?php if(is_array($one['tags'])): foreach($one['tags'] as $key=>$t): ?><a href="/category/<?php echo ($category['id']); ?>?stid=<?php echo ($t['tag_id']); ?>">
                                                    <?php echo str_ireplace($skey,$replace,$t['name']);?>
                                                </a><?php endforeach; endif; ?>
                                        </span><?php endif; ?>
                                </p>
                                <div class="muted summary_box">
                                    <?php if($one['summary']): echo str_ireplace($skey,$replace,get_short(nl2br($one['summary']),250)); else: echo str_ireplace($skey,$replace,get_short(strip_tags($one['content']),250)); endif; ?>
                                </div>
                                <div class="clear"></div>
                            </div><?php endforeach; endif; ?>
                        <div class="pagestring"><?php echo ($pagestring); ?></div>
                    <?php else: ?>
                    <blockquote>
                      <div>你搜索的 <span class="a_color"><b><?php echo ($skey); ?></b></span> 没找到相关搜索内容</div>
                      <div>建议换关键词重新搜索</div>
                    </blockquote><?php endif; ?>
            </div>
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