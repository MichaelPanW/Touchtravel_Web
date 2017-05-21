<?php /* Smarty version Smarty-3.0.6, created on 2015-11-28 06:01:08
         compiled from "C:\xampp\htdocs\qhand\anysis/tpl\header.html" */ ?>
<?php /*%%SmartyHeaderCode:2325656593514eee535-21416785%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd18e385032a8332696ede841cd1c70e32e8e04da' => 
    array (
      0 => 'C:\\xampp\\htdocs\\qhand\\anysis/tpl\\header.html',
      1 => 1416800498,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2325656593514eee535-21416785',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>業務週分析系統</title>
<link type="text/css" href="./css/tab.css"  rel="stylesheet">
<style type="text/css">
*{margin:0;padding:0;}
a{text-decoration:none;color:#06c;}
body{background:url(img/411bg.gif) left top repeat-y;color:#666;font-size:12px;font-family:"新細明體",arial,sans-serif}
.leftmenu{position:absolute;left:0;top:0;width:124px;float:left;margin-top:80px;}
.leftmenu li{list-style:none;margin-left:7px;margin-top:5px;width:110px;height:30px;line-height:30px;background:url(img/411menu_bg.gif);text-align:center;font-size:14px;}
.leftmenu li.current{font-weight:bold;width:117px;background:url(img/411menu_bg_current.gif);}

.content{padding:2px;padding-left:126px;width:auto;}
.content_body{border:1px solid #dcdcdc;padding:2px;background:#f5f5f5;}
.content_menu{background:url(img/dot.gif) bottom repeat-x;}
.content_menu a{border:1px solid #dcdcdc;background:#dedede;display:inline-block;height:24px;line-height:24px;padding-left:8px;padding-right:8px;}
.content_menu a.current{border-bottom:1px solid #fff;font-weight:bold;color:#f00;background:#fff;}

.cont{background:#fff;border:1px solid #dcdcdc;border-top:none;height:auto!important;min-height:500px;_height:500px;}
.t{ cursor:pointer;}

.table {
    border-collapse: collapse;
    text-align: center;
    width: 100%;
}
.table th {
    background: none repeat scroll 0 0 #C5ECFF;
    color: #000;
}

.table th, .table td {
    border: 1px solid #FFFFFF;
    height: 25px;
    line-height: 25px;
    padding: 2px 5px;
}
.gray  {
	background-color: #81D9FF;
}
.color1 {
	background-color: #E4E4E4;
}
td.gray.sp1{
	background-color:#DCF6EE;
}
td.gray.sp2{
	background-color:#E6F4D4;
}
</style>
<script language="javascript" src="./js/jquery.js"></script>
<script type="text/javascript" src="./js/tab.js"></script>
<script language="javascript" src="./My97DatePicker/WdatePicker.js" defer="defer"></script>
<script type="text/javascript">
  
  function gotocrm(id)
  {
	  window.open("../index.php?m=crm&a=getCums&id="+id);
  }
</script>
</head>

<body>
<style type="text/css">
#webim {position:fixed; right:10px; top:200px; z-index:99999;}
</style>
<!--[if IE 6]>
<style type="text/css">
	html{overflow:hidden;}
	body{height:100%;overflow:auto;}
	#webim {position:absolute;}
</style>
<![endif]-->
<!-- webim button --><!--<div id="webim"><a href="/webim/client.php?locale=zh-tw" target="_blank" onclick="if(navigator.userAgent.toLowerCase().indexOf('opera') != -1 &amp;&amp; window.event.preventDefault) window.event.preventDefault();this.newWindow = window.open('/webim/client.php?locale=zh-tw&amp;url='+escape(document.location.href)+'&amp;referrer='+escape(document.referrer), 'webim', 'toolbar=0,scrollbars=0,location=0,status=1,menubar=0,width=640,height=480,resizable=1');this.newWindow.focus();this.newWindow.opener=window;return false;"><img src="/webim/button.php?i=webim&amp;lang=zh-tw" border="0" alt=""/></a></div>--><!-- / webim button -->

<ul class="leftmenu">
<li><a href="../index.php">回首頁</a></li>
<li <?php echo $_smarty_tpl->getVariable('sdata')->value;?>
><a href="index.php">開發數據</a></li>
<li <?php echo $_smarty_tpl->getVariable('quality')->value;?>
><a href="index.php?c=qality" >訪談品質</a></li>
<li <?php echo $_smarty_tpl->getVariable('appm')->value;?>
><a href="index.php?c=appm">約訪記錄</a></li>
<li <?php echo $_smarty_tpl->getVariable('res')->value;?>
><a href="index.php?c=res">績效分析</a></li>
</ul>
<!--<div class="content">
<div class="content_body">
<div class="content_menu">

  <h1 class="t" id='1'>Tab 1 关键词</h1>
  <div>Tab 1 的内容。</div>
  <h2 class="t" id='2'>Tab 2 关键词</h2>
  <div>Tab 2 的内容。</div>
  <div class="tip">2011年3月</div>
  <div class="tip detalis"></div>
</div>
</div>
</div>
-->