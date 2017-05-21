<?php
//计算 每周的 起点，终点。周数

class localdate{
	
	//$date ='2010-10-27'
	public function getweek($date)
	{
		list($year,$month,$day)=explode('-',$date);
		//$phpdate = new Date();
		//$phpdate->setDMY($day,$month,$year);
		//$weeks = $phpdate->getISOWeekOfYear();
		//echo strftime('%U',time());
		$first = $this->getfirstweekday($year);
		$noday = strtotime($date)+1;
		$weeks =array();
		if($first<=$noday){
		    $inval = $noday - $first;
		    $inval = ceil($inval/(60*60*24*7));
		}
		else{
			$year = $year-1;
			$first= $this->getfirstweekday($year);
			$inval = $noday - $first;
		    $inval = ceil($inval/(60*60*24*7));
		}
		//$weeks = strftime('%U',strtotime($date));
		//echo date( 'N ',strtotime( "$year-01-01 "));
		 $weeks['y']=$year;
		 $weeks['w']=$inval;
		return  $weeks;
	}
	
	//获取一年当中第一个星期一的 日期
	public function getfirstweekday($year)
	{
		$first = date( 'N',strtotime( "$year-01-01 "));
		if($first!=1)
		{
			$first = 8-$first;
			$first = "$year-01-0".(1+$first);
		}
		else{
			$first = "$year-01-01";
		}
		//$first=strtotime($first);
		return strtotime($first);
	}
	
	//获取某周一,周日·的日期
	public function getweekday($year,$week)
	{
		$first = $this->getfirstweekday($year);
		//$first = strtotime($first);
		$temptime = (($week-1)*7*24*60*60);
		$weekday['s'] =  date('Y-m-d',$first+$temptime);
		$weekday['e'] =  date('Y-m-d',($first+$temptime+(6*24*60*60)));
		return $weekday;
		
	}
	
	public function getweeklist($starttime='2010-10-04')
	{
		$stp = strtotime($starttime);
		$etp = time();
		while($stp<=$etp){
		   $temp = $this->getweek(date('Y-m-d',$stp));
		   $weeklist[]=$temp['y'].'-'.$temp['w'];
		   $stp  = $stp+(7*24*60*60);
		}
		return $weeklist;
	}
}
?>