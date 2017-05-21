<?php
/***
 * Left
 * 首頁選單項目
 *
 * 統計 user 的業務狀態並將結果顯示在首頁
 *
 ***/
namespace Photonic;
class Left
{
	// 公司id
	var $cid;
	var $htm='';
	
	function __construct($_cid=0)
	{
		$this->cid = $_cid;
		$this->getLeft();
	}
	
	function getLeft()
	{
		$cid = session('cid');
		$sql = "select m.model,m.action from eip_compay_right r,eip_role_mod m where r.is_left=1 and r.cid=$cid and m.id=r.modid";
		$list = M()->query($sql);
		foreach($list as $k=>$v){
			$this->htm.=$this->$v['model']($v['action']);
		}
	}
	
	//function 
	function mens($action=0)
	{
		$str = '  <div class="AccordionPanel">
    <div class="AccordionPanelTab"><a href="#">接收事件簿</a></div>
    <div class="AccordionPanelContent">
      <ul>
        <li>新接收004</li>
        <li>進行中030</li>
        <li>退件020</li>
        <li>完成未核002</li>
      </ul>
      </div>
  </div>';
	    return $str;
	}
	
	function crm($action=0)
	{
		$str = '<div class="AccordionPanel">
    <div class="AccordionPanelTab"><a href="#">發佈事件簿</a></div>
    <div class="AccordionPanelContent">
      <ul>
        <li><a href="#">新接收004</a></li>
        <li>進行中030</li>
        <li>退件020</li>
        <li>完成未核002</li>
      </ul>
    </div>
  </div>';
		return $str;
	}
	
	/***
	 * lcrmlist
	 * 本日應連絡
	 ***/
	function lcrmlist()
	{
		$crmobj = new crm();
		$crmlist = $crmobj->getclist($id=3, $t=0);
		$str = '<div class="AccordionPanel" child="01"><div class="AccordionPanelTab">本日應連絡客戶</div><div class="AccordionPanelContent" id="c_01"><ul>';
		foreach($crmlist as $k)
		{
			$str.='<li><a href="./index.php?m=crm&a=getCums&id='.$k['id'].'">'.$k['nick'].'</a></li>';
		}
		$str.='</ul></div></div>';
	    return $str;
	}
	
	/***
	 * mcrmlist
	 * 明日應連絡客戶
	 ***/
	function mcrmlist()
	{
		$crmobj = new crm();
		$crmlist = $crmobj->getclist($id=3, $t=1);
		$str = '<div class="AccordionPanel" child="02"><div class="AccordionPanelTab">明日應連絡客戶</div><div class="AccordionPanelContent" id="c_02"><ul>';
		foreach($crmlist as $k)
		{
			$str.='<li><a href="./index.php?m=crm&a=getCums&id='.$k['id'].'">'.$k['nick'].'</a></li>';
		}
		$str.='</ul></div></div>';
	    return $str;
	}
	
	/***
	 * bxsj
	 * 本日小事件應處理列
	 ***/
	function bxsj()
	{
		
		$crmobj = new crm();
		$crmlist = $crmobj->getclist($id=5, $t=0);
		$str = '<div class="AccordionPanel" child="03"><div class="AccordionPanelTab">本日小事件應處理列</div><div class="AccordionPanelContent" " id="c_03"><ul>';
		foreach($crmlist as $k)
		{
			$str.='<li><a href="./index.php?m=crm&a=getCums&id='.$k['id'].'">'.$k['nick'].'</a></li>';
		}
		$str.='</ul></div></div>';
	    return $str;
	}
	
	/***
	 * zxsj
	 * 昨日小事件應處理列
	 ***/
	function zxsj()
	{
		$crmobj = new crm();
		$crmlist = $crmobj->getclist($id=5, $t=2);
		$str = '<div class="AccordionPanel" child="04"><div class="AccordionPanelTab">昨日小事件應處理列</div><div class="AccordionPanelContent" id="c_04"><ul>';
		foreach($crmlist as $k)
		{
			$str.='<li><a href="./index.php?m=crm&a=getCums&id='.$k['id'].'">'.$k['nick'].'</a></li>';
		}
		$str.='</ul></div></div>';
	    return $str;
	}
	
	/***
	 * links
	 * 好用連結
	 ***/
	function links()
	{
		
		$str = '<div class="AccordionPanel" child="05">
    				<div class="AccordionPanelTab">好用連結</div>
   				    <div class="AccordionPanelContent" id="c_05">
      					<p><a href="http://www.google.com.tw" target="_blank">Google</a></p>
      					<p><a href="http://www.yahoo.com.tw" target="_blank">Yahoo</a></p>
    				</div>
  				</div>';
	    return $str;
	}
	
	function __call($methon, $args)
	{
		//echo $args[0];
		$left = new $methon($args[0]);
		return $left;
	}
	
	function __toString()
	{
		return $this->htm;
	}
}
?>