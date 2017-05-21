<?php /* Smarty version Smarty-3.0.6, created on 2015-11-28 06:01:09
         compiled from "C:\xampp\htdocs\qhand\anysis/tpl\getotal.html" */ ?>
<?php /*%%SmartyHeaderCode:2040856593515835e50-69966998%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '89b201de73a846693b62533fe1de22272dadabc0' => 
    array (
      0 => 'C:\\xampp\\htdocs\\qhand\\anysis/tpl\\getotal.html',
      1 => 1416800498,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2040856593515835e50-69966998',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_function_cycle')) include 'C:\xampp\htdocs\qhand\anysis\SpeedPHP\Drivers\Smarty\plugins\function.cycle.php';
?><table class="table">
     <tr class="gray"><th style="width:8%;"></th><th style="width:8%;">一</th><th style="width:8%;">二</th><th style="width:8%;">三</th><th style="width:8%;">四</th><th style="width:8%;">五</th><th style="width:8%;color:red;">六</th><th style="width:8%;color:red;">日</th><th>總訪問數</th><th>平均目標訪問數</th><th>目標訪問數</th></tr>
     <tbody class="result">
<tr class="color1"><td><b>新進客戶</b></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
   <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('newcm')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['item']->key;
?>
   <?php if ($_smarty_tpl->tpl_vars['key']->value!=0){?>
      <tr bgcolor="<?php echo smarty_function_cycle(array('values'=>"#eeeeee,#d0d0d0"),$_smarty_tpl);?>
">
      
      <td align="right"><?php echo $_smarty_tpl->getVariable('sales')->value[$_smarty_tpl->getVariable('key')->value];?>
</td>
      <?php  $_smarty_tpl->tpl_vars['one'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['keysec'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['item']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['one']->key => $_smarty_tpl->tpl_vars['one']->value){
 $_smarty_tpl->tpl_vars['keysec']->value = $_smarty_tpl->tpl_vars['one']->key;
?>
      <td><?php echo $_smarty_tpl->tpl_vars['one']->value;?>
</td>
      <?php }} ?>
      </tr> 
      <?php }?>
   <?php }} ?>
<tr class="color1"><td><b>電話轉入</b></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('precords')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['item']->key;
?>
<?php if ($_smarty_tpl->tpl_vars['key']->value!=0){?>
      <tr bgcolor="<?php echo smarty_function_cycle(array('values'=>"#eeeeee,#d0d0d0"),$_smarty_tpl);?>
">
      <td align="right"><?php echo $_smarty_tpl->getVariable('sales')->value[$_smarty_tpl->getVariable('key')->value];?>
</td>
      <?php  $_smarty_tpl->tpl_vars['one'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['keysec'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['item']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['one']->key => $_smarty_tpl->tpl_vars['one']->value){
 $_smarty_tpl->tpl_vars['keysec']->value = $_smarty_tpl->tpl_vars['one']->key;
?>
      <td><?php echo $_smarty_tpl->tpl_vars['one']->value;?>
</td>
      <?php }} ?>
      </tr> 
       <?php }?>
   <?php }} ?>
<tr class="color1"><td><b>轉入潛在</b></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('qiancm')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['item']->key;
?>
<?php if ($_smarty_tpl->tpl_vars['key']->value!=0){?>
      <tr bgcolor="<?php echo smarty_function_cycle(array('values'=>"#eeeeee,#d0d0d0"),$_smarty_tpl);?>
">
      <td align="right"><?php echo $_smarty_tpl->getVariable('sales')->value[$_smarty_tpl->getVariable('key')->value];?>
</td>
      <?php  $_smarty_tpl->tpl_vars['one'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['keysec'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['item']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['one']->key => $_smarty_tpl->tpl_vars['one']->value){
 $_smarty_tpl->tpl_vars['keysec']->value = $_smarty_tpl->tpl_vars['one']->key;
?>
      <td><?php echo $_smarty_tpl->tpl_vars['one']->value;?>
</td>
      <?php }} ?>
      </tr> 
       <?php }?>
   <?php }} ?>
<tr class="color1"><td><b>轉入現有</b></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('alreadcm')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['item']->key;
?>
<?php if ($_smarty_tpl->tpl_vars['key']->value!=0){?>
      <tr bgcolor="<?php echo smarty_function_cycle(array('values'=>"#eeeeee,#d0d0d0"),$_smarty_tpl);?>
">
      <td align="right"><?php echo $_smarty_tpl->getVariable('sales')->value[$_smarty_tpl->getVariable('key')->value];?>
</td>
      <?php  $_smarty_tpl->tpl_vars['one'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['keysec'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['item']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['one']->key => $_smarty_tpl->tpl_vars['one']->value){
 $_smarty_tpl->tpl_vars['keysec']->value = $_smarty_tpl->tpl_vars['one']->key;
?>
      <td><?php echo $_smarty_tpl->tpl_vars['one']->value;?>
</td>
      <?php }} ?>
      </tr> 
       <?php }?>
   <?php }} ?>
     </tbody>
  </table>