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
<link rel="shortcut icon" href="/Application/Home/View/lingshan/styles/css/images/favicon.ico" />
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
        <div class="logo"><a href="/"><img src="/Application/Home/View/lingshan/styles/css/images/logo.png" alt="<?php echo C('site_title');?>"/></a></div>
        <div class="logo_small"><a href="/"><img src="/Application/Home/View/lingshan/styles/css/images/logo_small.png" alt="<?php echo C('site_title');?>"/></a></div>
        <div class="top_nav">
            <div class="list">
                <?php $menu = D('Category')->getTree(0,'',array('is_menu'=>1));if(false)var_dump($menu);echo '<ul class="ul_level1 nav nav-pills nav_ul dropdown">';?><li class="banner_index <?php if($index): ?>active<?php endif; ?>" ><a href="/" >首页</a></li><?php if(is_array($menu)): $i = 0; $__LIST__ = $menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$lev1): $mod = ($i % 2 );++$i;?><li class="dropdown <?php if( $root_navbar['id'] == $lev1["id"] ): ?>active<?php endif; ?> banner_<?php echo ($lev1["name"]); ?>"><?php if($lev1["type"] == 3): ?><a href="<?php echo ($lev1["extralink"]); ?>" <?php if($lev1['link_target']): ?>target='_blank'<?php endif; ?> ><?php echo ($lev1["title"]); ?></a><?php else: ?><a href="#" <?php if($lev1['link_target']): ?>onclick="window.open('<?php echo ($lev1["link"]); ?>')" <?php else: ?> onclick="window.location.href='<?php echo ($lev1["link"]); ?>'"<?php endif; ?>  class="dropdown-toggle" data-toggle="dropdown" id="drop<?php echo ($lev1['id']); ?>"><?php echo ($lev1["title"]); ?></a><?php endif; if($lev1['_']): ?><ul class="dropdown-menu" role="menu" aria-labelledby="drop<?php echo ($lev1['id']); ?>"><?php if(is_array($lev1['_'])): foreach($lev1['_'] as $key=>$lev2): ?><li><?php if($lev2["type"] == 3): ?><a href="<?php echo ($lev2["extralink"]); ?>" <?php if($lev1['link_target']): ?>target='_blank'<?php endif; ?>><?php echo ($lev2["title"]); ?></a><?php else: ?><a href="<?php echo ($lev2["link"]); ?>" <?php if($lev2['link_target']): ?>target='_blank'<?php endif; ?> ><?php echo ($lev2["title"]); ?></a><?php endif; ?></li><?php endforeach; endif; ?></ul><?php endif; ?></li><?php endforeach; endif; else: echo "" ;endif; echo "</ul>"; ?>
            </div>
        </div>
        <form class="search" action="/search/index">
            <div class="input"><input name="skey" id="search"  class="span6" type="text" value="<?php echo ($skey); ?>"></div>
            <div class="bt"><input type="image" class="sicon" title="搜索" alt="搜索" src="/Application/Home/View/lingshan/styles/css/images/search.png"></div>
            <div class="clear"></div>
        </form>
    </div>
</div>

    <div class="blocklist margin-nav">
    <?php  $default_banner = D('Banner')->getBannerByName('default_banner'); $rand = rand(0,count($default_banner)-1); ?>
<?php if($category['banner']): ?><div class="banner" style="background-image:url('<?php echo thumb($category['banner'],0, 400);?>')">
    </div>
<?php elseif($category['parent']['thumb']): ?>
    <div class="banner" style="background-image:url('<?php echo thumb($category['parent']['thumb'], 0, 400);?>')">
    </div>
<?php elseif($default_banner): ?>
    <div class="banner" style="background-image:url('<?php echo thumb($default_banner[$rand]['path'], 0, 400);?>')">
    </div><?php endif; ?>
    <div class="container inner-container">
        <?php
 $bread = D('Category')->getParents($category['id']); $bread = array_reverse($bread); if($info['parent_id']) { $bread[] = array('title'=>$info['parent']['title'], 'link'=>$info['parent']['link']); } if($info) { $bread[] = array('title'=>'正文'); } $br_count = count($bread); ?>

<ul class="breadcrumb">
    <li><a href="/"><span class="glyphicon glyphicon-home"></span> 首页</a></li>
    <?php if(is_array($bread)): foreach($bread as $k=>$one): if($k == $br_count-1): ?><li class="active"><?php echo ($one['title']); ?></li>
        <?php else: ?>
            <li><a href="<?php echo ($one['link']); ?>"><?php echo ($one['title']); ?></a></li><?php endif; endforeach; endif; ?>
</ul>
        <div class="navigation">
    <?php
 $subchildren = D('Category')->getChildren($category['id']); if (!$subchildren) { $subchildren = D('Category')->getChildren(D('Category')->getParentId($category['id'])); } ?>
    <?php if($subchildren): ?><ul class="list">
            <?php if(is_array($subchildren)): foreach($subchildren as $key=>$one): ?><li <?php if ($one['title'] == $category['title']) echo 'class="active"'?>><a href="<?php echo ($one['link']); ?>"><?php echo ($one['title']); ?></a></li><?php endforeach; endif; ?>
        </ul><?php endif; ?>
</div>
        <?php
 $cat_ids = D("Category")->getChildrenId($category['id']); $cat_ids[] = $category['id']; $tags = D('Tag')->getTagsWeight($cat_ids); $stid = intval($_GET['stid']); ?>
<div class="top-tags">
    <?php if($tags): ?><form action="/category/<?php echo ($category['id']); ?>" method="get">
            <a class="label label-tag <?php echo ($stid?'':'label-select'); ?>" href="?stid=0">全部标签</a>
            <?php if(is_array($tags)): foreach($tags as $key=>$one): ?><a class="label label-tag <?php echo ($stid==$one['tag_id']?'label-select':''); ?>" href="?stid=<?php echo ($one['tag_id']); ?>"><?php echo ($one['name']); ?>&nbsp;<b>[<span title="对应文章数"><?php echo ($one['count']); ?></span>]</b>
                </a><?php endforeach; endif; ?>
        </form><?php endif; ?>
</div>
<div class="clear"></div>

        <div class="content-block row">
            <?php if( $category['id'] ) { $child=D('Category')->getChildrenId($category['id'],true); }else { $child=D('Category')->getField('id',true); };if(false)$filter['weight']=false;if($_GET['stid'])$filter['tag_id']=$_GET['stid'];if(true)$count = D('Content')->getPagesByTypeId($child, 0, 0,$filter, true);if(true)list($pagesize, $page_num, $pagestring) = pagestring($count, 6);if(true)$pages = D('Content')->getPagesByTypeId($child, $page_num, $pagesize,$filter,false,false,true);else $pages = D('Content')->getPagesByTypeId($child, 1, 6,$filter,false,false,true,false);if(false)var_dump($pages); if(is_array($pages)): $i = 0; $__LIST__ = $pages;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$page): $mod = ($i % 2 );++$i;?><div class="col-lg-4 col-md-6">
                    <a href="<?php echo ($page['link']); ?>">
                        <div class="block">
                            <div class="thumb">
                                <img src="<?php echo thumb($page['thumb'], 330 , 220);?>">
                            </div>
                            <div class="title">
                                <?php echo ($page['title']); ?>
                            </div>
                            <?php if($page['tags']): ?><div class="tags">
                                    <span class="glyphicon glyphicon-tag icon-tag" aria-hidden="true"></span>
                                    <?php if(is_array($page['tags'])): foreach($page['tags'] as $key=>$tag): ?><a href="/category/<?php echo ($page['category_id']); ?>?stid=<?php echo ($tag['tag_id']); ?>"><?php echo ($tag['name']); ?></a><?php endforeach; endif; ?>
                                </div><?php endif; ?>
                            <div class="date">
                                <?php echo substr($page['publish_time'], 0, 10);?>
                            </div>
                            <div class="brief">
                                <?php echo trim($page['summary']?get_short($page['summary'], 90):get_short(trim(strip_tags($page['content'])),90));?>
                            </div>
                        </div>
                    </a>
                </div><?php endforeach; endif; else: echo "" ;endif; ?>
        </div>
        <div class="pagestring"><?php echo ($pagestring); ?></div>
        <div class="clearfix"></div>
    </div>
</div>
<link rel="stylesheet" type="text/css" href="/Application/Home/View/lingshan/styles/css/lrtk.css" />
<div id="code"></div>
<a href="http://weibo.com/lingshanfoundation" target="_blank">
  <div id="code_weibo"></div>
</a>
<div id="code_img"></div>
<a id="gotop" href="javascript:void(0)"></a>
<script type="text/javascript">
  function b(){
      h = $(window).height();
      t = $(document).scrollTop();
      if(t > h){
          $('#gotop').show();
      }else{
          $('#gotop').hide();
      }
  }
  $(document).ready(function(e) {
      b();
      $('#gotop').click(function(){
          $(document).scrollTop(0);   
      })
      $('#code').hover(function(){
              $(this).attr('id','code_hover');
              $('#code_img').show();
          },function(){
              $(this).attr('id','code');
              $('#code_img').hide();
      })
      
  });

  $(window).scroll(function(e){
      b();        
  });
</script>

<div id="footer">
    <div class="container">
        <div class="logo">
            <img src="/Application/Home/View/lingshan/styles/css/images/logo-w.png" />
        </div>
        <div class="friend-link">
            <p>友情链接：<a target="_blank" href="http://www.chinalingshan.com/index.aspx">灵山胜境</a></p>
        </div>
        <div class="copyright">
            <p>Copyright © <?php echo C('site_copyright');?> <?php echo C('site_link');?> All Rights Reserved</p>
        </div>
    </div>
</div>
<?php echo D('Config')->getConfigValue('analytics');?>
<body>
</html>