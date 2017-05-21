<?php
class res extends spController
{
	function index(){
		
		session_start();
		$this->res =  "class='current'";
		$employees = spClass("employees"); 
		//$sql = "select employee_Id,employee_Name from ";
		$argsw = $this->spArgs('w');
		$conditions = array('is_job'=>1,'is_anysis'=>1);
		$this->sales = $employees->findAll($conditions,NULL,'`id`,`name`');
		//print_r($this->sales);
		$firstid = ($_SESSION['index']==1)?($this->sales[0]['id']):($this->sales[$_SESSION['index']-1]['id']);
		//$firstid = $_SESSION['index'];
		if( !$firstid ) {
			$firstid = $this->sales[0]['id'];
			$this->ttid = 0;
		} else {
			$this->ttid = 1;
		}
		$this->id = $firstid;
		$salesname = ($_SESSION['index']==1)?($this->sales[0]['name']):($this->sales[$_SESSION['index']-1]['name']);
		include_once(APP_PATH."/class/localdate.php");
		$localdate = new localdate();
		if(!$argsw){
			$argsd = $this->spArgs('d');
			$date = $argsd?$argsd:date('Y-m-d');
			$this->dates=$date;
			$nweek = $localdate->getweek($date);
			if($nweek['w']==1)
			{
				$preweek=$localdate->getweek((date('Y')-1).'-12-31');
			}else
			{
				$preweek=$nweek;
				//$preweek['w']=$preweek['w']-1;
			}
			
		//$weeklist = $localdate->getweeklist();
		}
		else
		{
			$pwk = explode('-',$argsw);
			$preweek['y']=$pwk[0];
			$preweek['w']=$pwk[1];
		}
		$weeks = $localdate->getweekday($preweek['y'],$preweek['w']);
		$start = strtotime($weeks['s']);
		$end   = strtotime($weeks['e']);
		$month = date('m',$start);
		$this->thweeks = $preweek['y'].'年'.$month.'月第'.$preweek['w'].'周';
		$_SESSION['thisweek']=$preweek['y'].'-'.$preweek['w'];
		//上一周
		$ppdate = date('Y-m-d',strtotime($weeks['s'])-7*24*3600);//上一周
		$ppweek = $localdate->getweek($ppdate);
		if($ppweek['w']==1)
		{
			$ppreweek=$localdate->getweek((date('Y')-1).'-12-31');
		}else
		{
			$ppreweek=$ppweek;
			//$preweek['w']=$preweek['w']-1;
		}
		$this->ppreweek = $ppreweek['y'].'-'.$ppreweek['w'];
		
		//下一周
		$nndate = date('Y-m-d',strtotime($weeks['s'])+7*24*3600);//上一周
		$nnweek = $localdate->getweek($nndate);
		if($nnweek['w']==1)
		{
			$nextweek=$localdate->getweek((date('Y')-1).'-12-31');
		}else
		{
			$nextweek=$nnweek;
			//$preweek['w']=$preweek['w']-1;
		}
		$this->nextweek = $nextweek['y'].'-'.$nextweek['w'];
			
			
		$casetables = spClass("casetables");
		$sql = "SELECT count(c.`id`) as count, t.name as customers_Name, t.id as customers_Id,from_unixtime(c.`exptime`,'%Y-%m-%d') as localdate FROM `crm_contract` c ,crm_crm_view t WHERE c.`cid`=t.id and `eid` ='$firstid' and `exptime` between $start and $end group by from_unixtime(c.`exptime`,'%Y-%m-%d') with rollup ";       
		$records = $casetables->findSql($sql);
		
		$sql = "SELECT c.`cid` as customer_id, t.`name` as customers_Name,t.`nick` as shortName,t.`id` as customers_Id,from_unixtime(`exptime`,'%Y-%m-%d') as localdate FROM `crm_contract` c ,`crm_crm_view` t WHERE c.`cid`=t.id and `eid` ='$firstid' and `exptime` between $start and $end";       
		$derecords = $casetables->findSql($sql);
		
		
		//print_r($precords);
		$npointer =$pointer= 0;
		$firstrecord = $second = array();
		$sum = 0;
		for($i=$start;$i<=$end;$i=$i+(24*3600))
		{
			//$temp = array();
			if($records[$npointer]['localdate']==date('Y-m-d',$i))
			{	
				$firstrecord[$pointer]=$records[$npointer];
				$npointer++;
				
			}else
			{
				$firstrecord[$pointer]['count']=0;
				$firstrecord[$pointer]['localdate']=date('Y-m-d',$i);
			}
			$sum+=$firstrecord[$pointer]['count'];
			
			foreach($derecords as $key=>$v)
			{
				if($v['localdate']==date('Y-m-d',$i))
				{
					$second[$v['localdate']][]='<a href="javascript:void(0)" onclick="gotocrm('.$v['customers_Id'].')">'.($v['shortName']?$v['shortName']:mb_substr($v['customers_Name'],0,4,'utf-8')).'</a>';
				}
			}
			
			$pointer++;
		}
		
		$max = 0;
		foreach($second as $key=>$result)
		{
			if($max<=count($result))
			{
				$max = count($result);
			}
		}
		
		$str = '';
		for($k=0;$k<$max;$k++){	
		    $str.='<tr  bgcolor="#cccccc"><td></td>';
			for($i=$start;$i<=$end;$i=$i+(24*3600))
			{
				
				 $str.='<td>'.$second[date('Y-m-d',$i)][$k].'</td>';
			}
			$str.='<td></td></tr>';
		}
		$this->str = $str;
		$this->sum=$sum;
		$this->newcm = $firstrecord;
		
		
		//print_r($firstrecord);
		$this->display("resdata.html");
		//SELECT * FROM `salesrecord` WHERE `ctype`='新進客戶' group by `salesid`,from_unixtime(`dateline`,'%Y-%m-%d')
	}
}