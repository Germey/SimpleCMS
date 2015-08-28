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

    <div class="main margin-nav">
    <?php  $carousel = D('Banner')->getBannerByName('index_carsouels'); $size = count($carousel); ?>
    <!-- carousel -->
    <div id="carousel" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <?php if(is_array($carousel)): foreach($carousel as $num=>$one): ?><li data-target="#carousel" data-slide-to="<?php echo ($num); ?>" <?php if ($num == 0) echo 'class="active"' ?>></li><?php endforeach; endif; ?>
        </ol>
        <div class="carousel-inner">
            <?php if(is_array($carousel)): foreach($carousel as $num=>$one): ?><div class="item <?php if ($num == 0) echo 'active'?>" style="background-image:url(<?php echo thumb($one['path'], 0, 550);?>)">
                    <?php if($one['link']): ?><a class="banner-link" target="_blank" href="<?php echo ($one['link']); ?>"></a><?php endif; ?>
                    <img class="banner-bottom" src="/Application/Home/View/lingshan/styles/css/images/banner-bottom.png">
                </div><?php endforeach; endif; ?>
        </div>
        <?php if(($size > 1)): ?><a class="left carousel-control" href="#carousel" data-slide="prev"><</a>
            <a class="right carousel-control" href="#carousel" data-slide="next">></a><?php endif; ?>
    </div>
    <!-- carousel end -->
    <!-- about start -->
    <div class="about">
        <div class="container">
            <?php  $about = D("Category")->getCategoryById('about'); ?>
            <div class="title">
                <span class="eng"><?php echo ($about['subtitle']); ?></span><span class="mid">|</span><span class="zh"><?php echo ($about['title']); ?></span>
            </div>
            <div class="content">
                <?php echo get_short($about['content'], 500);?>
            </div>
            <div class="more">
                <a target="_blank" class="btn btn-primary" href="<?php echo ($about['link']); ?>">了解更多</a>
            </div>
        </div>
    </div>
    <!-- about end -->  
    <!-- lingshan start -->
    <div class="lingshan">
        <div class="lingshan-container">
            <?php  $lingshan = D("Category")->getCategoryById(53); $cats = D("Category")->getChildren(53); ?>
            <div class="title">
                <span class="eng"><?php echo ($lingshan['subtitle']); ?></span><span class="mid">|</span><span class="zh"><?php echo ($lingshan['title']); ?></span>
            </div>
            <div class="content">
                <div class="cat-nav">
                    <?php $first = 1;?>
                    <?php if(is_array($cats)): foreach($cats as $key=>$cat): ?><div class="cat-name <?php echo $first==1?"active":"";$first=0;?>" href="<?php echo ($cat['id']); ?>">
                            <?php echo ($cat['title']); ?>
                        </div><?php endforeach; endif; ?>
                </div>
                <div class="summary">
                    <?php if(is_array($cats)): foreach($cats as $key=>$cat): $pages = D("Content")->getPagesByTypeId($cat['id'],1,6); if(!$pages) { $pages = D("Content")->getPagesByTypeId($cat['id'],1,6, array('is_getting_childrens'=>true)); } ?>
                        <div id="dg-container" class="wrap dg-container" name="<?php echo ($cat['id']); ?>">
                            <div class="dg-wrapper">
                                <?php if(is_array($pages)): foreach($pages as $key=>$page): ?><div class="page">
                                        <div class="title">
                                            <?php echo ($page['title']); ?>
                                        </div>
                                        <div class="thumb">
                                            <img src="<?php echo thumb($page['thumb'], 420, 280);?>">
                                        </div>
                                        <div class="brief">
                                            <?php echo get_short($page['summary'], 140);?>
                                        </div>
                                        <div class="more">
                                            <a target="_blank" href="<?php echo ($page['link']); ?>" class="btn btn-primary btn-primary-alt">查看详情</a>
                                        </div>
                                    </div><?php endforeach; endif; ?>
                            </div>
                            <nav>   
                                <span class="dg-prev">&lt;</span>
                                <span class="dg-next">&gt;</span>
                            </nav>
                        </div><?php endforeach; endif; ?>
                </div>
            </div>
        </div>
    </div>
    <!-- lingshan end -->
    <script type="text/javascript">
        $(function() {
            $('.dg-container').gallery();
        });
    </script>
    <!-- donate start -->
    <div class="donate">
        <div class="container content">
            <div class="row">
                <div class="col-lg-4">
                    <div class="item disclosure">
                        <div class="title">
                            <span class="eng">Disclosure</span><span class="mid">|</span><span class="zh">信息公开</span>
                        </div>
                        <?php  $total_all = 1.4571; $total_month = 8762; ?>

<div class="donate-summary-block">
    <table class="table table-noborder">
        <tr>
            <td class="l"><?php echo ($total_all); ?></td>
            <td class="r">
                <div class="sign">亿元</div>
                <div>上一年募资总额</div>
            </td>
        </tr>
        <tr>
            <td class="l"><?php echo ($total_month); ?></td>
            <td class="r">
                <div class="sign">元</div>
                <div>上一月募资总额</div>
            </td>
        </tr>
    </table>

    <div class="text-center">
        <a class="btn btn-danger" target="_blank" href="<?php echo C('custom_goto_donate_link');?>">
            <span class="glyphicon glyphicon-heart"></span> 
            我要捐赠
        </a>
    </div>
</div>

                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="item donate-list">
                        <div class="title">
                            <span class="eng">Donation list</span><span class="mid">|</span><span class="zh">最新捐赠</span>
                        </div>
                        <?php  $latest_donates = array( array('name' => '周芸', 'amount' => '500.00  ', 'donate_time' => '2015-06-25', ), array('name' => '李永', 'amount' => '300.00', 'donate_time' => '2015-06-22' ), array('name' => '李永', 'amount' => '300.00', 'donate_time' => '2015-06-22' ), array('name' => '吴卉（放生款）', 'amount' => '500.00', 'donate_time' => '2015-06-22'), array('name' => '彭振', 'amount' => '1620.00', 'donate_time' => '2015-06-15' ), array('name' => '施佳豪', 'amount' => '50.00', 'donate_time' => '2015-06-13' ), array('name' => '彭振', 'amount' => '1620.00', 'donate_time' => '2015-06-15' ), array('name' => '施佳豪', 'amount' => '50.00', 'donate_time' => '2015-06-13' ), array('name' => '梁晶晶', 'amount' => '50.00', 'donate_time' => '2015-06-13' ), ); ?>


<div class="donate-latest-block">
    <div id="scrollup" class="scrollup">
        <table class="table table-noborder table-striped table-condensed">
            <?php if(is_array($latest_donates)): foreach($latest_donates as $key=>$one): ?><tr>
                    <td><?php echo ($one['name']); ?></td>
                    <td><?php echo moneyit($one['amount']);?></td>
                    <td><?php echo substr($one['donate_time'],0,10);?></td>
                </tr><?php endforeach; endif; ?>
        </table>
    </div>
    <div class="text-center">
        <a class="btn btn-primary" target="_blank" href="/category/donate_list">
            <span class="glyphicon glyphicon-paperclip" aria-hidden="true"></span>
            查看更多
        </a>
    </div>    
</div>



<script type="text/javascript">


// JavaScript Document
$(document).ready(function(){
    scrollUpDown($('#scrollup table'));


    function scrollUpDown(obj) {
        var _height = obj.outerHeight();
        var _html = obj.html();
        obj.html(_html + _html);
        function scroll() {
            return setInterval(function() {
                if (parseFloat(obj.css('margin-top')) > -(_height)) {
                    obj.css({ 'margin-top': parseFloat(obj.css('margin-top')) - 1 });
                } else {
                    obj.css({ 'margin-top': 0 });
                }
            }, 60);
        }
        var _interval = scroll();
        obj.hover(function() {
            _interval = clearInterval(_interval);
        }, function() {
            _interval = scroll();
        });
    }
});

</script>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="item support">
                        <div class="title">
                            <span class="eng">Support us</span><span class="mid">|</span><span class="zh">支持灵山</span>
                        </div>
                        <div class="details">
                            <div class="one">
                                <img src="/Application/Home/View/lingshan/styles/css/images/donate-icon1.png"><a target="_blank" class="btn btn-primary btn-primary-alt" href="/category/donate">我要捐赠</a>
                            </div>
                            <div class="one">
                                <img src="/Application/Home/View/lingshan/styles/css/images/donate-icon2.png"><a target="_blank" class="btn btn-primary btn-primary-alt" href="<?php echo C('custom_addto_link');?>">成为志愿者</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- donate end -->

    <!-- news start -->
    <div class="news">
        <div class="container">
            <?php  $news = D("Category")->getCategoryById(45); $pages = D("Content")->getPagesByTypeId(45,1,3, array('is_getting_childrens'=>true)); ?>
            <div class="title">
                <span class="eng"><?php echo ($news['subtitle']); ?></span><span class="mid">|</span><span class="zh"><?php echo ($news['title']); ?></span>
            </div>
            <div class="content-block row">
                <?php if(is_array($pages)): foreach($pages as $key=>$page): ?><div class="col-sm-4">
                        <a target="_blank" href="<?php echo ($page['link']); ?>">
                            <div class="block">
                                <div class="thumb">
                                    <img src="<?php echo thumb($page['thumb'], 330 , 220);?>">
                                </div>
                                <div class="title">
                                    <?php echo ($page['title']); ?>
                                </div>
                                <div class="date">
                                    <?php echo substr($page['publish_time'], 0, 10);?>
                                </div>
                                <div class="brief">
                                    <?php echo trim($page['summary']?get_short($page['summary'], 90):get_short(trim(strip_tags($page['content'])),90));?>
                                </div>
                            </div>
                        </a>
                    </div><?php endforeach; endif; ?>
            </div>
            <div class="more">
                <a href="<?php echo ($news['link']); ?>" target="_blank" class="btn btn-primary">查看更多</a>
            </div>
        </div>
    </div>
    <!-- news end -->
    <!-- subscribe start -->
    <div class="extra">
        <h4 class="msg">如果您希望及时了解基金会的动向，欢迎邮件订阅/下载基金会期刊。</h4>
        <div class="subscribe">
            <button class="btn btn-danger" data-toggle="modal" data-target="#myModal">
                <span class="glyphicon glyphicon-send" ></span> 订阅 | Subscribe
            </button>
            <a href="/category/edownload" target="_blank" class="btn btn-primary">
                <span class="glyphicon glyphicon-download-alt"></span> 下载电子期刊 | Download
            </a>
        </div>
    </div>
    <!-- subscribe end -->
</div>


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="margin-top: 0">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">订阅基金会期刊</h4>
      </div>
      <div class="modal-body">
        <?php echo C("custom_subscribe_code");?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
      </div>
    </div>
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