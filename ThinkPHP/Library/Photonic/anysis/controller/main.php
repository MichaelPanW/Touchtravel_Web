<?php
class main extends spController
{
	function index(){
		$this->sdata =  "class='current'";
		$employees = spClass("employees"); 
		//$sql = "select employee_Id,employee_Name from ";
		$argsw = $this->spArgs('w');
		$conditions = array('is_job'=>1,'is_anysis'=>1);
		$this->sales = $employees->findAll($conditions,NULL,'id,name');
		//print_r($this->sales);
		$firstid = ($_SESSION['index']==1)?($this->sales[0]['id']):($this->sales[$_SESSION['index']-1]['id']);
		if( !$firstid ) {
			$firstid = $this->sales[0]['id'];
			$this->ttid = 0;
		} else {
			$this->ttid = 1;
		}
		$this->id = $firstid;
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
			
			
		$salesrecord = spClass("salesrecord");
		$sql = "SELECT count(*) as salescount,from_unixtime(`dateline`,'%Y-%m-%d') as `localdate`,`ctype` FROM `salesrecord` WHERE  `salesid`='$firstid' and `dateline` between '$start' and '$end' group by `salesid`,from_unixtime(`dateline`,'%Y-%m-%d'),`ctype`";       
		$records = $salesrecord->findSql($sql);
		
		$newcm = $qiancm = $alreadcm = array();
		$phonerecords = spClass("phonerecords");
		$sql = "SELECT count(*) as phonecount,from_unixtime(`dateline`,'%Y-%m-%d') as `localdate` FROM `phone_records` WHERE  `salesid`='$firstid' and `dateline` between '$start' and '$end' group by `salesid`,from_unixtime(`dateline`,'%Y-%m-%d')"; 
		      
		$precords = $phonerecords->findSql($sql);
		foreach($records as $key=>$v)
		{
			switch($v['ctype'])
			{
				case '新進客戶':$newcm[]=$v; break;
				case '潛在客戶':$qiancm[]=$v; break;
				case '現有客戶':$alreadcm[]=$v; break;
			}
		}
		//print_r($precords);
		$npointer =$qpointer = $apointer=$phpointer = $pointer= 0;
		$firstrecord = $secondrecord = $thirdrecord=$fourthrecord=array();
		for($i=$start;$i<=$end;$i=$i+(24*3600))
		{
			//$temp = array();
			if($newcm[$npointer]['localdate']==date('Y-m-d',$i))
			{	
				$firstrecord[$pointer]=$newcm[$npointer];
				$npointer++;
				
			}else
			{
				$firstrecord[$pointer]['salescount']=0;
				$firstrecord[$pointer]['localdate']=date('Y-m-d',$i);
			}
			if($qiancm[$qpointer]['localdate']==date('Y-m-d',$i))
			{	
				$secondrecord[$pointer]=$qiancm[$qpointer];
				$qpointer++;
			}else
			{
				$secondrecord[$pointer]['salescount']=0;
				$secondrecord[$pointer]['localdate']=date('Y-m-d',$i);
			}
			if($alreadcm[$apointer]['localdate']==date('Y-m-d',$i))
			{	
				$thirdrecord[$pointer]=$alreadcm[$apointer];
				$apointer++;
			}else
			{
				$thirdrecord[$pointer]['salescount']=0;
				$thirdrecord[$pointer]['localdate']=date('Y-m-d',$i);
			}
			if($precords[$phpointer]['localdate']==date('Y-m-d',$i))
			{	
				$fourthrecord[$pointer]=$precords[$phpointer];
				$phpointer++;
			}else
			{
				$fourthrecord[$pointer]['phonecount']=0;
				$fourthrecord[$pointer]['localdate']=date('Y-m-d',$i);
			}
			$pointer++;
		}
		$this->newcm = $firstrecord;
		$this->qiancm = $secondrecord;
		$this->alreadcm = $thirdrecord;
		$this->precords= $fourthrecord;
		
		//print_r($records);
		$this->display("saledata.html");
		//SELECT * FROM `salesrecord` WHERE `ctype`='新進客戶' group by `salesid`,from_unixtime(`dateline`,'%Y-%m-%d')
	}
}