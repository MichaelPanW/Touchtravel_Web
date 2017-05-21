<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body onload="initial();">
	
<p>倒數時間:</p>
<div id="countdown"> </div> 
<div id="box"></div>
</body>
<script src="/Public/Dcard/js/jquery/jquery-1.12.4.js"></script>
<script type="text/javascript">
var time=1800;
var countdownnumber=time;
var countdownid,x;
function initial(){
  x=document.getElementById("countdown");
  x.innerHTML=countdownnumber;
  countdownnumber--;
  countdownid=window.setInterval(countdownfunc,1000);
}
function countdownfunc(){ 
  x.innerHTML=countdownnumber;
  if (countdownnumber==0){
  	 oneturn();
    countdownnumber=time;
  }
  countdownnumber--;
}
oneturn();
	function oneturn(){
        $.ajax({
            method: 'get',
            data: {
            },
            url: "<?php echo u('Ajax/article');?>",
            success: function(res) {
                //alert(res);
                $("<span>"+res+"<span>").insertAfter("#box");
            },
            error: function(request, error) {
                console.log(arguments);
                console.log(request);
            }

        });
        $.ajax({
            method: 'get',
            data: {
            },
            url: "<?php echo u('Ajax/hiddcheck');?>",
            success: function(res) {
            },
            error: function(request, error) {
                console.log(arguments);
                console.log(request);
            }

        });
<?php if(is_array($classif)): foreach($classif as $key=>$vo): ?>$.ajax({
            method: 'get',
            data: {
                class: "<?php echo ($vo[tag]); ?>"
            },
            url: "<?php echo u('Ajax/content');?>",
            success: function(res) {
                //alert(res);
                $("<span>"+res+"<span>").insertAfter("#box");
            },
            error: function(request, error) {
                console.log(arguments);
                console.log(request);
            }

        });<?php endforeach; endif; ?>
}
</script>
</html>