<?php /* Smarty version Smarty-3.0.6, created on 2015-11-28 06:01:08
         compiled from "C:\xampp\htdocs\qhand\anysis/tpl\saledata.html" */ ?>
<?php /*%%SmartyHeaderCode:17851565935148081f8-71924619%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9af5e242363631438e77ccc93334892d51d1132b' => 
    array (
      0 => 'C:\\xampp\\htdocs\\qhand\\anysis/tpl\\saledata.html',
      1 => 1426068006,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17851565935148081f8-71924619',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php $_template = new Smarty_Internal_Template("header.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
<div class="content">
<div class="content_body">
<div class="content_menu">

  <?php  $_smarty_tpl->tpl_vars['one'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('sales')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['one']->key => $_smarty_tpl->tpl_vars['one']->value){
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['one']->key;
?>
  <h1 class="t" id='<?php echo $_smarty_tpl->tpl_vars['one']->value['id'];?>
'><?php echo $_smarty_tpl->tpl_vars['one']->value['name'];?>
</h1>
  <div  id="t<?php echo $_smarty_tpl->tpl_vars['one']->value['id'];?>
">
  <?php if ($_smarty_tpl->tpl_vars['one']->value['id']==$_smarty_tpl->getVariable('id')->value){?>
  <table class="table">
     <tr class="gray">
     <th style="width:9%;"></th><th style="width:13%;">一</th><th style="width:13%;">二</th><th style="width:13%;">三</th><th style="width:13%;">四</th><th style="width:13%;">五</th><th style="width:13%; color:red;">六</th><th style="width:13%;color:red;">日</th></tr>
     <tbody class="result">
     <tr class="add color1" id="d1">
     <td>新進客戶</td>
      <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('newcm')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
?>
     <td><?php echo $_smarty_tpl->tpl_vars['item']->value['salescount'];?>
</td>
     <?php }} ?>
     </tr>
     
     <tr class="add" id="d2"><td>電話轉入</td>
     <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('precords')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
?>
     <td><?php echo $_smarty_tpl->tpl_vars['item']->value['phonecount'];?>
</td>
     <?php }} ?>
     </tr>
     <tr class="add color1" id="d3"><td>轉入潛在</td>
     
      <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('qiancm')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
?>
     <td><?php echo $_smarty_tpl->tpl_vars['item']->value['salescount'];?>
</td>
     <?php }} ?>
     
     </tr>
     <tr class="add" id="d4"><td>轉入現有</td> 
     <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('alreadcm')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
?>
     <td><?php echo $_smarty_tpl->tpl_vars['item']->value['salescount'];?>
</td>
     <?php }} ?>
     </tr>
     </tbody>
  </table>
  <?php }else{ ?>
  <span>加載中，請稍候...</span>
  <?php }?>
  
  </div>
  <?php }} ?>
  <h1 class="t" id='0'>總覽</h1>
  <div  id="t0">
  <span>加載中，請稍候...</span>
  </div>
  <div class="tip"><?php echo $_smarty_tpl->getVariable('thweeks')->value;?>
</div>
  <div class="tip detalis"></div>
</div>
<input type="hidden" value="<?php echo $_smarty_tpl->getVariable('id')->value;?>
" id="eid"  />
<div style="position:relative; margin-top:5px; padding:10px; height:40px;"> 
  <div style="float:left;"><a style="float:left; margin-top:5px;" href="./index.php">本週</a> &nbsp;&nbsp;&nbsp;&nbsp;<form action="./index.php" method="post" style="float:left; margin-left:10px;"><input type="text" name="d" id="cal" value="<?php echo $_smarty_tpl->getVariable('dates')->value;?>
" class="Wdate" onfocus="new WdatePicker()" /> <input type="submit" value="GO" name="calBtn" /></form></div>
  <div style="position:absolute; right:10px;"><a style="margin-top:5px;"  href="./index.php?w=<?php echo $_smarty_tpl->getVariable('ppreweek')->value;?>
">上一週</a>&nbsp;&nbsp;<a style="margin-top:5px;"  href="./index.php?w=<?php echo $_smarty_tpl->getVariable('nextweek')->value;?>
">下一週</a></div>
</div>
</div>
</div>
</body>
</html>
<script language="javascript">
$(function(){
    
    $(".content_menu").KandyTabs({
		trigger:"click",
		except:".tip", 
		current:<?php echo $_SESSION['index'];?>
,
		custom :function(b,c,t,d){
			//alert($('#'+(t+ 1 )).html());
			//alert($(b[t]).attr('id'));
			//alert($(c[t]).attr('id'));
			var a = $(c[t]).find('.table');
			//alert(a.length);
			var id = $(b[t]).attr('id');
			$('#eid').val(id)
			if(a.length==0){
			  var obj = new Object();
			  
			  obj.id=id;
			  obj.index = parseInt(t)+1;
			  if(id>0)
			  $.post('<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'ajax','a'=>'getsaledata'),$_smarty_tpl);?>
', obj, function(result){
				  
				  
				  $(c[t]).html(result);
			  })
			  else
			  $.post('<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'ajax','a'=>'getotal'),$_smarty_tpl);?>
', obj, function(result){
				  
				  
				  $(c[t]).html(result);
			  })
			}
			
		}
		});
		$('td').live('click',function(){
			var cl = $(this).parent().attr('class');
			var id = $('#eid').val();
			var newclass = $(this).parent().attr('id')+id;
			var phd = $(this).parent().attr('id');
			if(cl!='add')
			{
				
				return false;
			}
			if($('.'+newclass).length>0&&$('.'+newclass).is(':visible'))
			{
				$('.'+newclass).hide();
			}else if($('.'+newclass).length>0&&!$('.'+newclass).is(':visible'))
			{
				$('.'+newclass).show();
			}else{
				var obj = new Object();
				obj.id=id;
				obj.classname=newclass;
				obj.p=phd;
				obj.self = this;
				$.post('<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'ajax','a'=>'getcust'),$_smarty_tpl);?>
', obj, function(result){
				  $(obj.self).parent().after(result);
				  //alert(result);
				  //alert(obj.id);
				  //$('#'.phd).after(result);
			  })
			    //var str="<tr class='"+newclass+"' bgcolor='#cccccc'><td></td><td>$</td><td>$</td><td>$</td><td></td><td></td><td></td><td></td></tr><tr class='"+newclass+"' bgcolor='#cccccc'><td></td><td>$</td><td>$</td><td>$</td><td></td><td></td><td></td><td></td></tr>";
			    
			}
		})
   
		<?php if ($_smarty_tpl->getVariable('ttid')->value==0){?>
				$('.t').click();
		 <?php }?>
  })
function delHtmlTag(str)
   {
        return str.replace(/<[^>]+>/g,"");//去掉所有的html标记
   }
  function updateaim(ts){
		 if(!(/^[-]?\d+$/.test(delHtmlTag($(ts).html())))){
		   alert("輸入無效字符");
		   return false;
		 }else if($(ts).html()<0)
		 {
		   alert("輸入無效字符");
		   return false;
		 }
		 var id = $(ts).attr('sid')
		 var w =$(ts).attr('wid');
		 var t = $(ts).attr('t');

		 var value= delHtmlTag($(ts).html());
		 var obj = new Object();  
	     obj.id=id;
		 obj.w =w;
		 obj.v = value;
		 obj.t=t;
		 obj.self=ts;
		 $.post('<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'ajax','a'=>'updatedevaim'),$_smarty_tpl);?>
', obj, function(result){
				  var tdobjs = $(obj.self).parent().parent().children('td');
				  //alert(result);
				  var r = Math.round(value/5);
				  $(tdobjs[9]).html(r);
				  for(var i=0;i<10;i++)
				  {
					  if(i>0&&i<8)
					  {
						  if($(tdobjs[i]).html()<r)
						  {
							  $(tdobjs[i]).css('color','red');
						  }else{
							   $(tdobjs[i]).css('color','black');
						  }
					  }
					  if(i==8)
					  {
						  if(parseInt($(tdobjs[i]).html())<parseInt(value))
						  {
							  $(tdobjs[i]).css('color','red');
						  }else{
							   $(tdobjs[i]).css('color','black');
						  }
					  }
					  
				  }
				 // $(c[t]).html(result);
			  })
		 
	  }
</script>