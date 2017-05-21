<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link type="text/css" href="css/tab.css"  rel="stylesheet">
<style type="text/css">
.t{ cursor:pointer;}
</style>
<script language="javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/tab.js"></script>
<script type="text/javascript">
  $(function(){
    
    $("#test").KandyTabs({
		trigger:"click",
		except:".tip", 
		
		custom :function(b,c,t,d){
			alert($('#'+(t+ 1 )).html());
		},
		});
		
   

  })
</script>

</head>

<body>
<div id="box">
<div id="test">
  <h1 class="t" id='1'>Tab 1 关键词</h1>
  <div>Tab 1 的内容。</div>
  <h2 class="t" id='2'>Tab 2 关键词</h2>
  <div>Tab 2 的内容。</div>
  <div class="tip">2011年3月</div>
  <div class="tip detalis"></div>
  </div>

</div>
</body>
</html>