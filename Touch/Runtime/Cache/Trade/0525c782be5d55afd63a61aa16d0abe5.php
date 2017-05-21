<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?php echo ($title); ?></title>
    <link rel="stylesheet" href="/Public/Dcard/css/bootstrap.min.css">
    <link rel="stylesheet" href="/Public/Dcard/css/style.css">
        <!--1280以下--><!--ipad 橫放/電腦螢幕-->
        <link href="/Public/Dcard/css/style-large.css" rel="stylesheet" type="text/css" media="only screen and (min-width: 770px) and (max-width: 1280px)"  />
        
        <!--手機直立/手機橫放/ipad直立-->
        <link href="/Public/Dcard/css/style-small.css" rel="stylesheet" type="text/css" media="only screen and (min-width: 0px) and (max-width: 769px)" />
    <LINK REL="SHORTCUT ICON" HREF="/Public/Dcard/image/logo.png">
    <meta name="keywords" content="Dcard,Ccard,消失,文章,西斯,
                            <?php if(is_array($classif)): foreach($classif as $key=>$vo): echo ($vo[title]); ?>,<?php endforeach; endif; ?>" />
    <meta data-react-helmet="true" name="twitter:title" content="Ccard" />
    <meta data-react-helmet="true" name="description" content="不想錯過任何有趣的文章嗎？趕快加入我們吧！" />
    <meta data-react-helmet="true" property="og:description" content="不想錯過任何有趣的文章嗎？趕快加入我們吧！" />
    <meta data-react-helmet="true" name="twitter:description" content="不想錯過任何有趣的文章嗎？趕快加入我們吧！" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="msvalidate.01" content="6E4D4E75083A861C9474E10BF25DC888" />
</head>

<body>
<div class="fix_head navbar-fixed-top">
    <div class="container  ">
        <div class="navbar-header">
            <a href="<?php echo u('Index/index');?>">
                <p class="logo">
                    <img src="/Public/Dcard/image/face.png" /></p>
            </a>
            		<a href="<?php echo u('Ajax/index');?>"><input type="button" class="btn btn-danger" value="爬蟲區" ></a>
        </div>

        <div id="navbar" class="navbar-collapse  navbar-right">
            <form action="<?php echo u('Index/index');?>" class="navbar-form form-inline " method="get" role="form">
                <ul class="nav navbar-nav search_ul " style="padding-left: 50px ">

                    <li class="form-group">
                        <input type="text" name="title" class="form-inline form-control" placeholder="搜尋" value="<?php echo ($_GET['title']); ?>">
                    </li>
                    <li class="form-group">
                        <select name="class" id="" class="form-inline form-control">
                            <option value="">分類</option>
                            <?php if(is_array($classif)): foreach($classif as $key=>$vo): if($_GET['class'] == $vo[title]): ?><option value="<?php echo ($vo[title]); ?>" selected><?php echo ($vo[title]); ?></option>
                                    <?php else: ?>
                                    <option value="<?php echo ($vo[title]); ?>"><?php echo ($vo[title]); ?></option><?php endif; endforeach; endif; ?>
                        </select>
                    </li>
                    <li class="form-group">
                        <input type="submit" class="btn btn-default" value="搜尋">
                    </li> 
                    <li class="">

                </li>
                </ul>
                <br>
                <div class="checkbox form-group" style="color:#fff;float:right">
                    <label>
                        <?php if($_GET['hidd'] == 1): ?><input type="checkbox" name="hidd" value="1" checked>
                            <?php else: ?>
                            <input type="checkbox" name="hidd" value="1"><?php endif; ?>
                        已消失
                    </label>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="fix_content">
    <div class="container ">
        <div class="btn-group page_div">
            <?php echo ($pageShowA); ?></div>
        <ul class="nav nav-sidebar">
            <?php if(is_array($article)): foreach($article as $key=>$vo): ?><li>
                    <a href="<?php echo u('Index/show');?>?id=<?php echo ($vo["id"]); ?>">
                        <h4>
                        <span class="label label-warning"><?php echo ($vo["classif"]); ?></span>
                    <?php if($vo[hidd] == 1): ?><span class="label label-danger">已消失</span><?php endif; ?>
            <?php echo ($vo[title]); ?>
            </h4>
                        <p><?php echo (mb_substr($vo['content'],0,100,'utf-8')); ?></p>
                    </a>
                </li><?php endforeach; endif; ?>
        </ul>
        <div class="btn-group pull-right page_div">
            <?php echo ($pageShowA); ?></div>
        <br>
    </div>
</div>
<script src="/Public/Dcard/js/jquery/jquery-1.12.4.js">
</script>
<script src="/Public/Dcard/js/bootstrap.min.js"></script>
<script src="/Public/Dcard/js/facebook.js"></script>
<div class="container">
    <script>
    show_fb_talks("talksfb", $(".container").width(), "", "<?php echo ($article[url]); ?>");
    </script>
</div>
<footer>
    <div class="container">
        <br>
        <div class="copyright-r">
            <p>©Ccard</p>
            E-mail:<a href="mailto:micwings@gmail.com">micwings@gmail.com</a></p>
        </div>
    </div>
</footer>
</body>

</html>

<script>
</script>