<?php
class ajax extends spController
{
	function getsaledata(){
		
		/*$employees = spClass("employees"); 
		//$sql = "select employee_Id,employee_Name from ";
		$conditions = array('is_sales'=>1);
		$this->sales = $employees->findAll($conditions,NULL,'`employee_Id`,`employee_Name`');
		//print_r($this->sales);
		$firstid = $this->sales[0]['employee_Id'];*/
		session_start();
		$firstid = $this->spArgs('id');
		$index = $this->spArgs('index');
		$_SESSION['index']=$index;
		include_once(APP_PATH."/class/localdate.php");
		$localdate = new localdate();
		if(!$_SESSION['thisweek']){
			$nweek = $localdate->getweek(date('Y-m-d'));
			if($nweek['w']==1)
			{
				$preweek=$localdate->getweek((date('Y')-1).'-12-31');
			}else
			{
				$preweek=$nweek;
				//$preweek['w']=$preweek['w']-1;
			}
		//weeklist = $localdate->getweeklist();
		}else
		{
			$pwk = explode('-',$_SESSION['thisweek']);
			$preweek['y']=$pwk[0];
			$preweek['w']=$pwk[1];
		}
		$weeks = $localdate->getweekday($preweek['y'],$preweek['w']);
		$start = strtotime($weeks['s']);
		$end   = strtotime($weeks['e']);
		$salesrecord = spClass("salesrecord");
		$sql = "SELECT count(*) as salescount,from_unixtime(`dateline`,'%Y-%m-%d') as `localdate`,`ctype` FROM `salesrecord` WHERE  `salesid`='$firstid' and `dateline` between '$start' and '$end' group by `salesid`,from_unixtime(`dateline`,'%Y-%m-%d'),`ctype`";       
		$records = $salesrecord->findSql($sql);
		//$pointer = 0;
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
		//print_r($alreadcm);
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
		$this->display("getsaledata.html");
		//SELECT * FROM `salesrecord` WHERE `ctype`='新進客戶' group by `salesid`,from_unixtime(`dateline`,'%Y-%m-%d')
	}
	
	function getcust()
	{
		session_start();
		$firstid = $this->spArgs('id');
		$index = $this->spArgs('index');
		$_SESSION['index']=$index;
		include_once(APP_PATH."/class/localdate.php");
		$localdate = new localdate();
		$id = $this->spArgs('id');
		$classname = $this->spArgs('classname');
		$p = $this->spArgs('p');
		if(!$_SESSION['thisweek']){
			$nweek = $localdate->getweek(date('Y-m-d'));
			if($nweek['w']==1)
			{
				$preweek=$localdate->getweek((date('Y')-1).'-12-31');
			}else
			{
				$preweek=$nweek;
				//$preweek['w']=$preweek['w']-1;
			}
		//weeklist = $localdate->getweeklist();
		}else
		{
			$pwk = explode('-',$_SESSION['thisweek']);
			$preweek['y']=$pwk[0];
			$preweek['w']=$pwk[1];
		}
		$weeks = $localdate->getweekday($preweek['y'],$preweek['w']);
		$start = strtotime($weeks['s']);
		$end   = strtotime($weeks['e']);
		
		if($p=='d2')
		{
			$phonerecords = spClass("phonerecords");
		    $sql = "SELECT c.customers_Name,c.shortName,c.customers_Id, from_unixtime(p.`dateline`,'%Y-%m-%d') as `localdate` FROM `phone_records` p,customers c WHERE  p.`salesid`='$id' and  p.`dateline` between '$start' and '$end' and c.customers_Id =p.customer_id";
			
			$precords = $phonerecords->findSql($sql);
			//$pointer = 0;
			for($i=$start;$i<=$end;$i=$i+(24*3600))
			{
				foreach($precords as $recode){
					
					if($recode['localdate']==date('Y-m-d',$i))
					{
					   $results[$recode['localdate']][]='<a href="javascript:void(0)" onclick="gotocrm('.$recode['customers_Id'].')">'.($recode['shortName']?$recode['shortName']:mb_substr($recode['customers_Name'],0,4,'utf-8')).'</a>';
					}
				}
				//$pointer++;
			}
			//print_r($results);
		}else{
			$salesrecord = spClass("salesrecord");
			if($p=='d1')
			{
				$ctype = '新進客戶';
			}
			if($p=='d3')
			{
				$ctype = '潛在客戶';
			}
			if($p=='d4')
			{
				$ctype = '現有客戶';
			}
		    $sql = "SELECT c.name as customers_Name,c.nick as shortName,c.id as customers_Id ,from_unixtime(s.`dateline`,'%Y-%m-%d') as `localdate`,`ctype` FROM `salesrecord` s,crm_crm_view c WHERE  s.`salesid`='$id' and s.`dateline` between '$start' and '$end' and c.id =s.cid and s.ctype='$ctype'";       
			
		   $records = $salesrecord->findSql($sql);
		   for($i=$start;$i<=$end;$i=$i+(24*3600))
			{
				foreach($records as $recode){
					
					if($recode['localdate']==date('Y-m-d',$i))
					{
					   $results[$recode['localdate']][]='<a href="javascript:void(0)" onclick="gotocrm('.$recode['customers_Id'].')">'.($recode['shortName']?$recode['shortName']:mb_substr($recode['customers_Name'],0,4,'utf-8')).'</a>';
					}
				}
				//$pointer++;
			}
		}
		
		$str = '';
		$max = 0;
		foreach($results as $key=>$result)
		{
			if($max<=count($result))
			{
				$max = count($result);
			}
		}
		for($k=0;$k<$max;$k++){	
		    $str.='<tr class="'.$classname.'" bgcolor="#cccccc"><td></td>';
			for($i=$start;$i<=$end;$i=$i+(24*3600))
			{
				
				 $str.='<td>'.$results[date('Y-m-d',$i)][$k].'</td>';
			}
			$str.='</tr>';
		}
		echo $str;
		
	}
	
	function getotal()
	{
		session_start();
		session_start();
		$firstid = $this->spArgs('id');
		$index = $this->spArgs('index');
		$_SESSION['index']=$index;
		include_once(APP_PATH."/class/localdate.php");
		$localdate = new localdate();
		if(!$_SESSION['thisweek']){
			$nweek = $localdate->getweek(date('Y-m-d'));
			if($nweek['w']==1)
			{
				$preweek=$localdate->getweek((date('Y')-1).'-12-31');
			}else
			{
				$preweek=$nweek;
				//$preweek['w']=$preweek['w']-1;
			}
		//weeklist = $localdate->getweeklist();
		}else
		{
			$pwk = explode('-',$_SESSION['thisweek']);
			$preweek['y']=$pwk[0];
			$preweek['w']=$pwk[1];
		}
		$weeks = $localdate->getweekday($preweek['y'],$preweek['w']);
		$start = strtotime($weeks['s']);
		$end   = strtotime($weeks['e']);
		
		$salesrecord = spClass("salesrecord");
		//$sql = "select if(t.salescount is null,0,t.salescount) salescount,t.localdate,if(t.Contact_datetime is null, '$start',t.contact_datetime) as Contact_datetime,if(s.daim is null,0,s.daim) as daim,e.`id` as employee_Id from eip_user e left join (SELECT count(b.`Brecord_Id`) rcount,b.`Contact_TypeName`,b.`employee_Id`,from_unixtime(b.`dateline`,'%Y-%m-%d') as `Contact_datetime` FROM `business_record` b  WHERE from_unixtime(b.`dateline`,'%Y-%m-%d') between '$start' and '$end' and from_unixtime(b.`dateline`,'%Y-%m-%d')<'$curdate' and b.`Contact_TypeName`='電訪' group by b.`employee_Id`,from_unixtime(b.`dateline`,'%Y-%m-%d')) t on e.`id`=t.`employee_Id` left join (select * from salesaim where `weeks`='".$_SESSION['thisweek']."') s on e.`id`=s.sid where e.is_job=1 and e.is_anysis=1";
		$sql = "SELECT count(*) as salescount,from_unixtime(`dateline`,'%Y-%m-%d') as `localdate`,`ctype`,s.aim1,s.aim2,s.aim3,s.aim4,if(a.salesid is null, s.sid,a.salesid) as salesid,dateline FROM `salesrecord` a  right join (select * from devaim where `weeks`='".$_SESSION['thisweek']."') s on a.`salesid`=s.`sid` and `dateline` between '$start' and '$end' group by `salesid`,s.`sid`,from_unixtime(`dateline`,'%Y-%m-%d'),ctype";  
		//echo $sql;
		$records = $salesrecord->findSql($sql);
		//$pointer = 0;
		$newcm = $qiancm = $alreadcm = array();
		$phonerecords = spClass("phonerecords");
		$sql = "SELECT count(*) as phonecount,from_unixtime(`dateline`,'%Y-%m-%d') as `localdate`,s.aim1,s.aim2,s.aim3,s.aim4,if(a.salesid is null, s.sid,a.salesid) as salesid FROM `phone_records` a  right join (select * from devaim where `weeks`='".$_SESSION['thisweek']."') s on a.`salesid`=s.`sid` and  `dateline` between '$start' and '$end'  group by `salesid`,s.`sid`,from_unixtime(`dateline`,'%Y-%m-%d')";       
		$precords = $phonerecords->findSql($sql);

		$sql = "select id from eip_user where is_job=1 and is_anysis=1";
		$eipuserlist = $phonerecords->findSql($sql);
		//var_dump( $eipuserlist );
		$newcm = $qiancm = $alreadcm = array();
		$t1=$t2=$t3=$t4=array();
		$round1 = $round2 = $round3 = $round4 = array();
		$aim1 = $aim2 = $aim3 = $aim4 = array();
		$npointer =$qpointer = $apointer=$phpointer = $pointer= 1;
		$firstrecord = $secondrecord = $thirdrecord=$fourthrecord=array();
		$firstrecordd = $secondrecordd = $thirdrecordd=$fourthrecordd=array();
		foreach($records as $key=>$v)
		{
			switch($v['ctype'])
			{
				case '新進客戶':$newcm[]=$v; break;
				case '潛在客戶':$qiancm[]=$v; break;
				case '現有客戶':$alreadcm[]=$v; break;
			}
		}
		
		
		foreach($newcm as $key=>$v)
		{
			$firstrecord[$v['salesid']][$v['localdate']]=$v['salescount'];
			$firstrecord[$v['salesid']][0]=$v['salesid'];
			$aim1[$v['salesid']]=$v['aim1'];
		}
		foreach($qiancm as $key=>$v)
		{
			$secondrecord[$v['salesid']][$v['localdate']]=$v['salescount'];
			$secondrecord[$v['salesid']][0]=$v['salesid'];
			$aim3[$v['salesid']]=$v['aim3'];
		}
		foreach($alreadcm as $key=>$v)
		{
			$thirdrecord[$v['salesid']][$v['localdate']]=$v['salescount'];
			$thirdrecord[$v['salesid']][0]=$v['salesid'];
			$aim4[$v['salesid']]=$v['aim4'];
		}
		foreach($precords as $key=>$v)
		{
			$fourthrecord[$v['salesid']][$v['localdate']]=$v['phonecount'];
			$fourthrecord[$v['salesid']][0]=$v['salesid'];
			$aim2[$v['salesid']]=$v['aim2'];
		}
		
		
		
		for($i=$start;$i<=$end;$i=$i+(24*3600))
		{
			foreach($firstrecord as $key=>$v)
			{
				//echo $v[date('Y-m-d',$i)];
				if($v[date('Y-m-d',$i)]) {
					$firstrecordd[$key][$pointer]=$v[date('Y-m-d',$i)];
					$t1[$key]+=$v[date('Y-m-d',$i)];
				} elseif(!$firstrecordd[$key][$pointer]) {
					$firstrecordd[$key][$pointer]=0;
				}
				if($pointer==7) {
					if(!$t1[$key]) {
						$t1[$key]=0;
					}
					$round1[$key]=round($aim1[$key]/5);
					$firstrecordd[$key][8] = $t1[$key];
					if( $firstrecordd[$key][8] < $aim1[$key] ) {
						$color="red";
					} else {
						$color="blue";
					}
					$firstrecordd[$key][8]='<font color="' . $color . '">' . $t1[$key] . '</font>';
					$firstrecordd[$key][9]=$round1[$key];
					$firstrecordd[$key][10]='<div contentEditable="true" onblur="updateaim(this)" sid="'.$key.'" wid="'.$_SESSION['thisweek'].'" t="aim1"  style="height:19px;">'.$aim1[$key].'</div>';	
					if($t1[$key]>=$aim1[$key]) {
						$colorarr[$key]='black';
					}else{
						$colorarr[$key]='red';
					}
				}
			}
			foreach( $eipuserlist as  $val ) {
				if(!$firstrecordd[$val['id']][$pointer]) {
					$firstrecordd[$val['id']][$pointer]=0;
					$aim1[$val['id']] = 0;
					reset( $records );
					foreach( $records as $subval ) {
						if( $subval['salesid'] == $val['id'] ) {
							$aim1[$val['id']] =  $subval['aim1'];
						}
					}
				}
				if($pointer==7) {
					if(!$t1[$val['id']]) {
						$t1[$val['id']]=0;
					}
					$round1[$val['id']]=round($aim1[$val['id']]/5);
					$firstrecordd[$val['id']][8] = $t1[$val['id']];
					$firstrecordd[$val['id']][9]=$round1[$val['id']];
					$firstrecordd[$val['id']][10]='<div contentEditable="true" onblur="updateaim(this)" sid="'.$val['id'].'" wid="'.$_SESSION['thisweek'].'" t="aim1"  style="height:19px;">'.$aim1[$val['id']].'</div>';
				}
			}
			foreach($secondrecord as $key=>$v)
			{
				if($v[date('Y-m-d',$i)]) {
					$secondrecordd[$key][$pointer]=$v[date('Y-m-d',$i)];
					$t3[$key]+=$v[date('Y-m-d',$i)];
				}elseif(!$secondrecordd[$key][$pointer])
				{
					$secondrecordd[$key][$pointer]=0;
				}
				if($pointer==7) {
					if(!$t3[$key]) {
						$t3[$key]=0;
					}
					$round3[$key]=round($aim3[$key]/5);
					$secondrecordd[$key][8] = $t3[$key];
					if( $secondrecordd[$key][8] < $aim3[$key] ) {
						$color="red";
					} else {
						$color="blue";
					}
					$secondrecordd[$key][8]='<font color="' . $color . '">' . $t3[$key] . '</font>';
					$secondrecordd[$key][9]=$round3[$key];
					$secondrecordd[$key][10]='<div contentEditable="true" onblur="updateaim(this)" sid="'.$key.'" wid="'.$_SESSION['thisweek'].'" t="aim3"  style="height:19px;">'.$aim3[$key].'</div>';					
					if($t3[$key]>=$aim3[$key]) {
						$colorarr[$key]='black';
					}else{
						$colorarr[$key]='red';
					}
				}
			}
			foreach( $eipuserlist as  $val ) {
				if(!$secondrecordd[$val['id']][$pointer]) {
					$secondrecordd[$val['id']][$pointer]=0;
					$aim3[$val['id']] = 0;
					reset( $records );
					foreach( $records as $subval ) {
						if( $subval['salesid'] == $val['id'] ) {
							$aim3[$val['id']] =  $subval['aim3'];
						}
					}
				}
				if($pointer==7) {
					if(!$t3[$val['id']]) {
						$t3[$val['id']]=0;
					}
					$round3[$val['id']]=round($aim3[$val['id']]/5);
					$secondrecordd[$val['id']][8] = $t3[$val['id']];
					$secondrecordd[$val['id']][9]=$round3[$val['id']];
					$secondrecordd[$val['id']][10]='<div contentEditable="true" onblur="updateaim(this)" sid="'.$val['id'].'" wid="'.$_SESSION['thisweek'].'" t="aim3"  style="height:19px;">'.$aim3[$val['id']].'</div>';
				}
			}
			foreach($thirdrecord as $key=>$v)
			{
				if($v[date('Y-m-d',$i)])
				{
					$thirdrecordd[$key][$pointer]=$v[date('Y-m-d',$i)];
					$t4[$key]+=$v[date('Y-m-d',$i)];
				}elseif(!$thirdrecordd[$key][$pointer])
				{
					$thirdrecordd[$key][$pointer]=0;
				}
				if($pointer==7) {
					if(!$t4[$key]) {
						$t4[$key]=0;
					}
					$round4[$key]=round($aim4[$key]/5);
					$thirdrecordd[$key][8] = $t4[$key];
					if( $thirdrecordd[$key][8] < $aim4[$key] ) {
						$color="red";
					} else {
						$color="blue";
					}
					$thirdrecordd[$key][8]='<font color="' . $color . '">' . $t4[$key] . '</font>';
					$thirdrecordd[$key][9]=$round4[$key];
					$thirdrecordd[$key][10]='<div contentEditable="true" onblur="updateaim(this)" sid="'.$key.'" wid="'.$_SESSION['thisweek'].'" t="aim4"  style="height:19px;">'.$aim4[$key].'</div>';					
					if($t4[$key]>=$aim4[$key]) {
						$colorarr[$key]='black';
					}else{
						$colorarr[$key]='red';
					}
				}
			}
			foreach( $eipuserlist as  $val ) {
				if(!$thirdrecordd[$val['id']][$pointer]) {
					$thirdrecordd[$val['id']][$pointer]=0;
					$aim4[$val['id']] = 0;
					reset( $records );
					foreach( $records as $subval ) {
						if( $subval['salesid'] == $val['id'] ) {
							$aim4[$val['id']] =  $subval['aim4'];
						}
					}
				}
				if($pointer==7) {
					if(!$t4[$val['id']]) {
						$t4[$val['id']]=0;
					}
					$round4[$val['id']]=round($aim4[$val['id']]/5);
					$thirdrecordd[$val['id']][8] = $t4[$val['id']];
					$thirdrecordd[$val['id']][9]=$round4[$val['id']];
					$thirdrecordd[$val['id']][10]='<div contentEditable="true" onblur="updateaim(this)" sid="'.$val['id'].'" wid="'.$_SESSION['thisweek'].'" t="aim4"  style="height:19px;">'.$aim4[$val['id']].'</div>';
				}
			}
			foreach($fourthrecord as $key=>$v)
			{
				if($v[date('Y-m-d',$i)])
				{
					$fourthrecordd[$key][$pointer]=$v[date('Y-m-d',$i)];
					$t2[$key]+=$v[date('Y-m-d',$i)];
				}elseif(!$fourthrecordd[$key][$pointer])
				{
					$fourthrecordd[$key][$pointer]=0;
				}
				if($pointer==7) {
					if(!$t2[$key]) {
						$t2[$key]=0;
					}
					$round2[$key]=round($aim2[$key]/5);
					$fourthrecordd[$key][8] = $t2[$key];
					if( $fourthrecordd[$key][8] < $aim2[$key] ) {
						$color="red";
					} else {
						$color="blue";
					}
					$fourthrecordd[$key][8]='<font color="' . $color . '">' . $t2[$key] . '</font>';
					$fourthrecordd[$key][9]=$round2[$key];
					$fourthrecordd[$key][10]='<div contentEditable="true" onblur="updateaim(this)" sid="'.$key.'" wid="'.$_SESSION['thisweek'].'" t="aim2"  style="height:19px;">'.$aim2[$key].'</div>';					
					if($t2[$key]>=$aim2[$key]) {
						$colorarr[$key]='black';
					}else{
						$colorarr[$key]='red';
					}
				}
			}
			foreach( $eipuserlist as  $val ) {
				if(!$fourthrecordd[$val['id']][$pointer]) {
					$fourthrecordd[$val['id']][$pointer]=0;
					$aim2[$val['id']] = 0;
					reset( $records );
					foreach( $records as $subval ) {
						if( $subval['salesid'] == $val['id'] ) {
							$aim2[$val['id']] =  $subval['aim2'];
						}
					}
				}
				if($pointer==7) {
					if(!$t2[$val['id']]) {
						$t2[$val['id']]=0;
					}
					$round2[$val['id']]=round($aim2[$val['id']]/5);
					$fourthrecordd[$val['id']][8] = $t2[$val['id']];
					$fourthrecordd[$val['id']][9]=$round2[$val['id']];
					$fourthrecordd[$val['id']][10]='<div contentEditable="true" onblur="updateaim(this)" sid="'.$val['id'].'" wid="'.$_SESSION['thisweek'].'" t="aim2"  style="height:19px;">'.$aim2[$val['id']].'</div>';
				}
			}
			$pointer++;
		}
		
		$employees = spClass("employees"); 
		//$sql = "select employee_Id,employee_Name from ";
		//$argsw = $this->spArgs('w');
		$conditions = array('is_job'=>1,'is_anysis'=>1);
		$sales = $employees->findAll($conditions,NULL,'`id`,`name`');
		foreach($sales as $key=>$v)
		{
			$tempsales[$v['id']]=$v['name'];
		}
		$tempsales[0]='未指定';
		foreach( $firstrecordd as $k => $v ) {
			for( $i = 1; $i <= 7; $i++ ) {
				if( $firstrecordd[$k][$i] < $firstrecordd[$k][9] ) {
					$firstrecordd[$k][$i] = '<font color="red">' . $firstrecordd[$k][$i] . '</font>';
				} else {
					$firstrecordd[$k][$i] = '<font color="blue">' . $firstrecordd[$k][$i] . '</font>';
				}
			}
		}
		foreach( $secondrecordd as $k => $v ) {
			for( $i = 1; $i <= 7; $i++ ) {
				if( $secondrecordd[$k][$i] < $secondrecordd[$k][9] ) {
					$secondrecordd[$k][$i] = '<font color="red">' . $secondrecordd[$k][$i] . '</font>';
				} else {
					$secondrecordd[$k][$i] = '<font color="blue">' . $secondrecordd[$k][$i] . '</font>';
				}
			}
		}
		foreach( $thirdrecordd as $k => $v ) {
			for( $i = 1; $i <= 7; $i++ ) {
				if( $thirdrecordd[$k][$i] < $thirdrecordd[$k][9] ) {
					$thirdrecordd[$k][$i] = '<font color="red">' . $thirdrecordd[$k][$i] . '</font>';
				} else {
					$thirdrecordd[$k][$i] = '<font color="blue">' . $thirdrecordd[$k][$i] . '</font>';
				}
			}
		}
		foreach( $fourthrecordd as $k => $v ) {
			for( $i = 1; $i <= 7; $i++ ) {
				if( $fourthrecordd[$k][$i] < $fourthrecordd[$k][9] ) {
					$fourthrecordd[$k][$i] = '<font color="red">' . $fourthrecordd[$k][$i] . '</font>';
				} else {
					$fourthrecordd[$k][$i] = '<font color="blue">' . $fourthrecordd[$k][$i] . '</font>';
				}
			}
		}
		$this->newcm = $firstrecordd;
		$this->qiancm = $secondrecordd;
		$this->alreadcm = $thirdrecordd;
		$this->precords= $fourthrecordd;
		$this->sales = $tempsales;
		$this->display("getotal.html");
		
	}
	
	function geqtotal()
	{
		session_start();
		$firstid = $this->spArgs('id');
		$index = $this->spArgs('index');
		$_SESSION['index']=$index;
		include_once(APP_PATH."/class/localdate.php");
		$localdate = new localdate();
		if(!$_SESSION['thisweek']){
			$nweek = $localdate->getweek(date('Y-m-d'));
			if($nweek['w']==1)
			{
				$preweek=$localdate->getweek((date('Y')-1).'-12-31');
			}else
			{
				$preweek=$nweek;
				//$preweek['w']=$preweek['w']-1;
			}
		//weeklist = $localdate->getweeklist();
		}else
		{
			$pwk = explode('-',$_SESSION['thisweek']);
			$preweek['y']=$pwk[0];
			$preweek['w']=$pwk[1];
		}
		$weeks = $localdate->getweekday($preweek['y'],$preweek['w']);
		$start = $weeks['s'];
		$end   = $weeks['e'];
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
			
		$curdate = date('Y-m-d');	
		$chatrecords = spClass("chatrecords");
		//SELECT count(b.`Brecord_Id`)  rcount,b.`Contact_TypeName`,b.`employee_Id`,b.`Contact_datetime`,if(s.aim is null,0,s.aim) as aim FROM `business_record` b left join (select * from salesaim where `weeks`='2011-15') s on b.`employee_Id`=s.sid WHERE b.`Contact_datetime` between '2011-04-11' and '2011-04-17'  group by b.`Contact_TypeName`,b.`employee_Id`,b.`Contact_datetime`
		$sql = "select if(t.rcount is null,0,t.rcount) rcount,t.Contact_TypeName,if(t.Contact_datetime is null, '$start',t.contact_datetime) as Contact_datetime,if(s.daim is null,0,s.daim) as daim,e.`id` as employee_Id from eip_user e left join (SELECT count(b.`Brecord_Id`) rcount,b.`Contact_TypeName`,b.`employee_Id`,from_unixtime(b.`dateline`,'%Y-%m-%d') as `Contact_datetime` FROM `business_record` b  WHERE from_unixtime(b.`dateline`,'%Y-%m-%d') between '$start' and '$end' and from_unixtime(b.`dateline`,'%Y-%m-%d')<'$curdate' and b.`Contact_TypeName`='電訪' group by b.`employee_Id`,from_unixtime(b.`dateline`,'%Y-%m-%d')) t on e.`id`=t.`employee_Id` left join (select * from salesaim where `weeks`='".$_SESSION['thisweek']."') s on e.`id`=s.sid where e.is_job=1 and e.is_anysis=1";       
		
		$phonechat = $chatrecords->findSql($sql);
		
		$sql = "select if(t.rcount is null,0,t.rcount) rcount,t.Contact_TypeName,if(t.Contact_datetime is null, '$start',t.contact_datetime) as Contact_datetime,if(s.saim is null,0,s.saim) as saim,e.`id` as employee_Id from eip_user e left join (SELECT count(b.`Brecord_Id`) rcount,b.`Contact_TypeName`,b.`employee_Id`,from_unixtime(b.`dateline`,'%Y-%m-%d') as `Contact_datetime` FROM `business_record` b  WHERE from_unixtime(b.`dateline`,'%Y-%m-%d') between '$start' and '$end' and from_unixtime(b.`dateline`,'%Y-%m-%d')<'$curdate' and b.`Contact_TypeName`='直訪' group by b.`employee_Id`,from_unixtime(b.`dateline`,'%Y-%m-%d')) t on e.`id`=t.`employee_Id` left join (select * from salesaim where `weeks`='".$_SESSION['thisweek']."') s on e.`id`=s.sid where e.is_job=1 and e.is_anysis=1"; 
		
		
		$selfchat = $chatrecords->findSql($sql);
		
		
		$sql = "SELECT count(*) rcount,`employee_Id`,from_unixtime(`dateline`,'%Y-%m-%d') as `Contact_datetime`,`attitude` FROM `business_record` WHERE from_unixtime(`dateline`,'%Y-%m-%d') between '$start' and '$end'  and from_unixtime(`dateline`,'%Y-%m-%d')<'$curdate'  group by `attitude`,`employee_Id`,from_unixtime(`dateline`,'%Y-%m-%d')"; 
		$otherrecords = $chatrecords->findSql($sql);  
		
		/*$phonerecords = spClass("phonerecords");
		$sql = "SELECT count(*) as phonecount,from_unixtime(`dateline`,'%Y-%m-%d') as `localdate` FROM `phone_records` WHERE  `salesid`='$firstid' and `dateline` between '$start' and '$end' group by `salesid`,from_unixtime(`dateline`,'%Y-%m-%d')"; 
		      
		$precords = $phonerecords->findSql($sql);*/
		/*foreach($records as $key=>$v)
		{
			switch($v['Contact_TypeName'])
			{
				case '電訪':$phonechat[]=$v; break;
				case '直訪':$selfchat[]=$v; break;
				default:
				{$phonechat[]=$v;$selfchat[]=$v;}
				//case '現有客戶':$alreadcm[]=$v; break;
			}
		}*/
		//print_r($precords);
		$bpq = $yyy = $bzd = $rbz = $wyy=$dsj = array();
		//var_dump($otherrecords);
		foreach($otherrecords as $key=>$v)
		{
			switch($v['attitude'])
			{
				case '不排斥':$bpq[]=$v; break;
				case '有意願':$yyy[]=$v; break;
				case '被阻擋':$bzd[]=$v; break;
				case '人不在':$rbz[]=$v; break;
				case '無意願':$wyy[]=$v; break;
				case '大事件':$dsj[]=$v; break;
				//case '現有客戶':$alreadcm[]=$v; break;
			}
		}
		$npointer =$qpointer = $apointer=$phpointer = $fvpointer = $sixpointer = $sevpointer=$eigpointer = $pointer= 1;
		$firstrecord = $secondrecord = $thirdrecord=$fourthrecord=$fiveth=$sixth=$seventh=$eight=array();
		$firstrecordd = $secondrecordd = $thirdrecordd=$fourthrecordd=$fivethd=$sixthd=$seventhd=$eightd=array();
		$t1=$t2=$t3=$t4=$t5=$t6=$t7=$t8=array();
		$round1 = $round2= array();
		$start = strtotime($weeks['s']);
		$end   = strtotime($weeks['e']);
		
		$daim = $saim = array();
		//var_dump( $phonechat );
		foreach($phonechat as $key=>$v)
		{
			$firstrecord[$v['employee_Id']][$v['Contact_datetime']]=$v['rcount'];
			$firstrecord[$v['employee_Id']][0]=$v['employee_Id'];
			$daim[$v['employee_Id']]=$v['daim'];
		}
		
		foreach($selfchat as $key=>$v)
		{
			$secondrecord[$v['employee_Id']][$v['Contact_datetime']]=$v['rcount'];
			$secondrecord[$v['employee_Id']][0]=$v['employee_Id'];
			$saim[$v['employee_Id']]=$v['saim'];
		}
		
		foreach($bpq as $key=>$v)
		{
			$thirdrecord[$v['employee_Id']][$v['Contact_datetime']]=$v['rcount'];
			$thirdrecord[$v['employee_Id']][0]=$v['employee_Id'];
		}
		
		foreach($yyy as $key=>$v)
		{
			$fourthrecord[$v['employee_Id']][$v['Contact_datetime']]=$v['rcount'];
			$fourthrecord[$v['employee_Id']][0]=$v['employee_Id'];
		}
		foreach($bzd as $key=>$v)
		{
			$fiveth[$v['employee_Id']][$v['Contact_datetime']]=$v['rcount'];
			$fiveth[$v['employee_Id']][0]=$v['employee_Id'];
		}
		
		foreach($rbz as $key=>$v)
		{
			$sixth[$v['employee_Id']][$v['Contact_datetime']]=$v['rcount'];
			$sixth[$v['employee_Id']][0]=$v['employee_Id'];
		}
		foreach($wyy as $key=>$v)
		{
			$seventh[$v['employee_Id']][$v['Contact_datetime']]=$v['rcount'];
			$seventh[$v['employee_Id']][0]=$v['employee_Id'];
		}
		
		foreach($dsj as $key=>$v)
		{
			$eight[$v['employee_Id']][$v['Contact_datetime']]=$v['rcount'];
			$eight[$v['employee_Id']][0]=$v['employee_Id'];
		}
		$colorarr = $colorarr1 = array();
		for($i=$start;$i<=$end;$i=$i+(24*3600))
		{
			//$temp = array();
			foreach($firstrecord as $key=>$v)
			{
				//echo $v[date('Y-m-d',$i)];
				if($v[date('Y-m-d',$i)])
				{
					$firstrecordd[$key][$pointer]=$v[date('Y-m-d',$i)];
					$t1[$key]+=$v[date('Y-m-d',$i)];
					
				}elseif(!$firstrecordd[$key][$pointer])
				{
					$firstrecordd[$key][$pointer]=0;
				}
				if($pointer==7)
					{
						if(!$t1[$key])
						{
							$t1[$key]=0;
						}
						$round1[$key]=round($daim[$key]/5);
						$firstrecordd[$key][8]=$t1[$key];
						if( $firstrecordd[$key][8] < $daim[$key] ) {
							$color="red";
						} else {
							$color="blue";
						}
						$firstrecordd[$key][8]='<font color="' . $color . '">' . $t1[$key] . '</font>';
						$firstrecordd[$key][9]=$round1[$key];
						$firstrecordd[$key][10]='<div contentEditable="true" onblur="updateaim(this)" sid="'.$key.'" wid="'.$_SESSION['thisweek'].'" t="daim"  style="height:19px;">'.$daim[$key].'</div>';
						
						
						if($t1[$key]>=$daim[$key])
						{
							$colorarr[$key]='blue';
						}else{
							$colorarr[$key]='red';
						}
					}
			}
			foreach($secondrecord as $key=>$v)
			{
				if($v[date('Y-m-d',$i)])
				{
					$secondrecordd[$key][$pointer]=$v[date('Y-m-d',$i)];
					$t2[$key]+=$v[date('Y-m-d',$i)];
					
				}elseif(!$secondrecordd[$key][$pointer])
				{
					$secondrecordd[$key][$pointer]=0;
				}
				if($pointer==7)
					{
						if(!$t2[$key])
						{
							$t2[$key]=0;
						}
						$round2[$key]=round($saim[$key]/5);
						$secondrecordd[$key][8] = $t2[$key];
						if( $secondrecordd[$key][8] < $saim[$key] ) {
							$color="red";
						} else {
							$color="blue";
						}
						$secondrecordd[$key][8]='<font color="' . $color . '">' . $t2[$key] . '</font>';
						$secondrecordd[$key][9]=$round2[$key];
						$secondrecordd[$key][10]='<div contentEditable="true" onblur="updateaim(this)" sid="'.$key.'" wid="'.$_SESSION['thisweek'].'" t="saim" style="height:19px;">'.$saim[$key].'</div>';
						
						if($t2[$key]>=$saim[$key])
						{
							$colorarr1[$key]='black';
						}else{
							$colorarr1[$key]='red';
						}
					}
			}
			foreach($thirdrecord as $key=>$v)
			{
				if($v[date('Y-m-d',$i)])
				{
					$thirdrecordd[$key][$pointer]=$v[date('Y-m-d',$i)];
					$t3[$key]+=$v[date('Y-m-d',$i)];
					
				}elseif(!$thirdrecordd[$key][$pointer])
				{
					$thirdrecordd[$key][$pointer]=0;
				}
				if($pointer==7)
					{
						$thirdrecordd[$key][8]=$t3[$key];
					}
			}
			foreach($fourthrecord as $key=>$v)
			{
				if($v[date('Y-m-d',$i)])
				{
					$fourthrecordd[$key][$pointer]=$v[date('Y-m-d',$i)];
					$t4[$key]+=$v[date('Y-m-d',$i)];
					
				}elseif(!$fourthrecordd[$key][$pointer])
				{
					$fourthrecordd[$key][$pointer]=0;
				}
				if($pointer==7)
					{
						$fourthrecordd[$key][8]=$t4[$key];
					}
			}
			
			foreach($fiveth as $key=>$v)
			{
				//echo $v[date('Y-m-d',$i)];
				if($v[date('Y-m-d',$i)])
				{
					$fivethd[$key][$pointer]=$v[date('Y-m-d',$i)];
					$t5[$key]+=$v[date('Y-m-d',$i)];
					
				}elseif(!$fivethd[$key][$pointer])
				{
					$fivethd[$key][$pointer]=0;
				}
				if($pointer==7)
					{
						$fivethd[$key][8]=$t5[$key];
					}
			}
			foreach($sixth as $key=>$v)
			{
				if($v[date('Y-m-d',$i)])
				{
					$sixthd[$key][$pointer]=$v[date('Y-m-d',$i)];
					$t6[$key]+=$v[date('Y-m-d',$i)];
					
				}elseif(!$sixthd[$key][$pointer])
				{
					$sixthd[$key][$pointer]=0;
				}
				if($pointer==7)
					{
						$sixthd[$key][8]=$t6[$key];
					}
			}
			foreach($seventh as $key=>$v)
			{
				if($v[date('Y-m-d',$i)])
				{
					$seventhd[$key][$pointer]=$v[date('Y-m-d',$i)];
					$t7[$key]+=$v[date('Y-m-d',$i)];
					
				}elseif(!$seventhd[$key][$pointer])
				{
					$seventhd[$key][$pointer]=0;
				}
				if($pointer==7)
					{
						$seventhd[$key][8]=$t7[$key];
					}
			}
			foreach($eight as $key=>$v)
			{
				if($v[date('Y-m-d',$i)])
				{
					$eightd[$key][$pointer]=$v[date('Y-m-d',$i)];
					$t8[$key]+=$v[date('Y-m-d',$i)];
					
				}elseif(!$eightd[$key][$pointer])
				{
					$eightd[$key][$pointer]=0;
				}
				if($pointer==7)
					{
						$eightd[$key][8]=$t8[$key];
					}
			}
			$pointer++;
		}
		
		$employees = spClass("employees"); 
		//$sql = "select employee_Id,employee_Name from ";
		//$argsw = $this->spArgs('w');
		//$conditions = array('is_sales'=>1);
		$sales = $employees->findAll(NULL,NULL,'`id`,`name`');
		foreach($sales as $key=>$v)
		{
			$tempsales[$v['id']]=$v['name'];
		}
		foreach( $firstrecordd as $k => $v ) {
			for( $i = 1; $i <= 7; $i++ ) {
				if( $firstrecordd[$k][$i] < $firstrecordd[$k][9] ) {
					$firstrecordd[$k][$i] = '<font color="red">' . $firstrecordd[$k][$i] . '</font>';
				} else {
					$firstrecordd[$k][$i] = '<font color="blue">' . $firstrecordd[$k][$i] . '</font>';
				}
			}
		}
		foreach( $secondrecordd as $k => $v ) {
			for( $i = 1; $i <= 7; $i++ ) {
				if( $secondrecordd[$k][$i] < $secondrecordd[$k][9] ) {
					$secondrecordd[$k][$i] = '<font color="red">' . $secondrecordd[$k][$i] . '</font>';
				} else {
					$secondrecordd[$k][$i] = '<font color="blue">' . $secondrecordd[$k][$i] . '</font>';
				}
			}
		}
		$tempsales[0]='未指定';
		$this->colorarr = $colorarr;
		$this->colorarr1 = $colorarr1;
		$this->sales = $tempsales;
		//var_dump( $firstrecordd );
		$this->phonechat = $firstrecordd;
		$this->selfchat = $secondrecordd;
		$this->round1 = $round1;
		$this->round2 = $round2;
		$this->bpq = $thirdrecordd;
		$this->yyy= $fourthrecordd;
		$this->bzd = $fivethd;
		$this->rbz= $sixthd;
		$this->wyy = $seventhd;
		$this->dsj= $eightd;
		$this->display('getqtotal.html');
	}
	
	function getchatrecord()
	{
		session_start();
		$firstid = $this->spArgs('id');
		$index = $this->spArgs('index');
		$_SESSION['index']=$index;
		include_once(APP_PATH."/class/localdate.php");
		$localdate = new localdate();
		if(!$_SESSION['thisweek']){
			$nweek = $localdate->getweek(date('Y-m-d'));
			if($nweek['w']==1)
			{
				$preweek=$localdate->getweek((date('Y')-1).'-12-31');
			}else
			{
				$preweek=$nweek;
				//$preweek['w']=$preweek['w']-1;
			}
		//weeklist = $localdate->getweeklist();
		}else
		{
			$pwk = explode('-',$_SESSION['thisweek']);
			$preweek['y']=$pwk[0];
			$preweek['w']=$pwk[1];
		}
		$weeks = $localdate->getweekday($preweek['y'],$preweek['w']);
		$start = $weeks['s'];
		$end   = $weeks['e'];
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
			
		$curdate = date('Y-m-d');	
		$chatrecords = spClass("chatrecords");
		$sql = "SELECT count(*) rcount,`Contact_TypeName`,`employee_Id`,from_unixtime(`dateline`,'%Y-%m-%d') as `Contact_datetime` FROM `business_record` WHERE from_unixtime(`dateline`,'%Y-%m-%d') between '$start' and '$end'  and from_unixtime(`dateline`,'%Y-%m-%d')<'$curdate' and `employee_Id`=$firstid group by `Contact_TypeName`,`employee_Id`,from_unixtime(`dateline`,'%Y-%m-%d')";       
		$records = $chatrecords->findSql($sql);
		
		$selfchat = $phonechat = array();
		
		
		$sql = "SELECT count(*) rcount,`employee_Id`,from_unixtime(`dateline`,'%Y-%m-%d') as `Contact_datetime`,`attitude` FROM `business_record` WHERE from_unixtime(`dateline`,'%Y-%m-%d') between '$start' and '$end'  and from_unixtime(`dateline`,'%Y-%m-%d')<'$curdate' and `employee_Id`=$firstid group by `attitude`,`employee_Id`,from_unixtime(`dateline`,'%Y-%m-%d')"; 
		$otherrecords = $chatrecords->findSql($sql);  
		
		/*$phonerecords = spClass("phonerecords");
		$sql = "SELECT count(*) as phonecount,from_unixtime(`dateline`,'%Y-%m-%d') as `localdate` FROM `phone_records` WHERE  `salesid`='$firstid' and `dateline` between '$start' and '$end' group by `salesid`,from_unixtime(`dateline`,'%Y-%m-%d')"; 
		      
		$precords = $phonerecords->findSql($sql);*/
		foreach($records as $key=>$v)
		{
			switch($v['Contact_TypeName'])
			{
				case '電訪':$phonechat[]=$v; break;
				case '直訪':$selfchat[]=$v; break;
				//case '現有客戶':$alreadcm[]=$v; break;
			}
		}
		//print_r($precords);
		$bpq = $yyy = $bzd = $rbz = $wyy=$dsj = array();
		foreach($otherrecords as $key=>$v)
		{
			switch($v['attitude'])
			{
				case '不排斥':$bpq[]=$v; break;
				case '有意願':$yyy[]=$v; break;
				case '被阻擋':$bzd[]=$v; break;
				case '人不在':$rbz[]=$v; break;
				case '無意願':$wyy[]=$v; break;
				case '大事件':$dsj[]=$v; break;
				//case '現有客戶':$alreadcm[]=$v; break;
			}
		}
		$npointer =$qpointer = $apointer=$phpointer = $fvpointer = $sixpointer = $sevpointer=$eigpointer = $pointer= 0;
		$firstrecord = $secondrecord = $thirdrecord=$fourthrecord=$fiveth=$sixth=$seventh=$eight=array();
		$start = strtotime($weeks['s']);
		$end   = strtotime($weeks['e']);
		for($i=$start;$i<=$end;$i=$i+(24*3600))
		{
			//$temp = array();
			if($phonechat[$npointer]['Contact_datetime']==date('Y-m-d',$i))
			{	
				$firstrecord[$pointer]=$phonechat[$npointer];
				$npointer++;
				
			}else
			{
				$firstrecord[$pointer]['rcount']=0;
				$firstrecord[$pointer]['Contact_datetime']=date('Y-m-d',$i);
			}
			if($selfchat[$qpointer]['Contact_datetime']==date('Y-m-d',$i))
			{	
				$secondrecord[$pointer]=$selfchat[$qpointer];
				$qpointer++;
			}else
			{
				$secondrecord[$pointer]['rcount']=0;
				$secondrecord[$pointer]['Contact_datetime']=date('Y-m-d',$i);
			}
			
			if($bpq[$apointer]['Contact_datetime']==date('Y-m-d',$i))
			{	
				$thirdrecord[$pointer]=$bpq[$apointer];
				$apointer++;
			}else
			{
				$thirdrecord[$pointer]['rcount']=0;
				$thirdrecord[$pointer]['Contact_datetime']=date('Y-m-d',$i);
			}
			if($yyy[$phpointer]['Contact_datetime']==date('Y-m-d',$i))
			{	
				$fourthrecord[$pointer]=$yyy[$phpointer];
				$phpointer++;
			}else
			{
				$fourthrecord[$pointer]['rcount']=0;
				$fourthrecord[$pointer]['Contact_datetime']=date('Y-m-d',$i);
			}
			///
			if($bzd[$fvpointer]['Contact_datetime']==date('Y-m-d',$i))
			{	
				$fiveth[$pointer]=$bzd[$fvpointer];
				$fvpointer++;
				
			}else
			{
				$fiveth[$pointer]['rcount']=0;
				$fiveth[$pointer]['Contact_datetime']=date('Y-m-d',$i);
			}
			if($rbz[$sixpointer]['Contact_datetime']==date('Y-m-d',$i))
			{	
				$sixth[$pointer]=$rbz[$sixpointer];
				$sixpointer++;
			}else
			{
				$sixth[$pointer]['rcount']=0;
				$sixth[$pointer]['Contact_datetime']=date('Y-m-d',$i);
			}
			
			if($wyy[$sevpointer]['Contact_datetime']==date('Y-m-d',$i))
			{	
				$seventh[$pointer]=$wyy[$sevpointer];
				$sevpointer++;
			}else
			{
				$seventh[$pointer]['rcount']=0;
				$seventh[$pointer]['Contact_datetime']=date('Y-m-d',$i);
			}
			if($dsj[$eigpointer]['Contact_datetime']==date('Y-m-d',$i))
			{	
				$eight[$pointer]=$dsj[$eigpointer];
				$eigpointer++;
			}else
			{
				$eight[$pointer]['rcount']=0;
				$eight[$pointer]['Contact_datetime']=date('Y-m-d',$i);
			}
			$pointer++;
		}
		$this->phonechat = $firstrecord;
		$this->selfchat = $secondrecord;
		
		$this->bpq = $thirdrecord;
		$this->yyy= $fourthrecord;
		$this->bzd = $fiveth;
		$this->rbz= $sixth;
		$this->wyy = $seventh;
		$this->dsj= $eight;
		$this->display('getqality.html');
	}
	
	
	function getchatcust()
	{
		session_start();
		$firstid = $this->spArgs('id');
		$index = $this->spArgs('index');
		$_SESSION['index']=$index;
		include_once(APP_PATH."/class/localdate.php");
		$localdate = new localdate();
		$id = $this->spArgs('id');
		$classname = $this->spArgs('classname');
		$p = $this->spArgs('p');
		if(!$_SESSION['thisweek']){
			$nweek = $localdate->getweek(date('Y-m-d'));
			if($nweek['w']==1)
			{
				$preweek=$localdate->getweek((date('Y')-1).'-12-31');
			}else
			{
				$preweek=$nweek;
				//$preweek['w']=$preweek['w']-1;
			}
		//weeklist = $localdate->getweeklist();
		}else
		{
			$pwk = explode('-',$_SESSION['thisweek']);
			$preweek['y']=$pwk[0];
			$preweek['w']=$pwk[1];
		}
		$weeks = $localdate->getweekday($preweek['y'],$preweek['w']);
		$start = $weeks['s'];
		$end   = $weeks['e'];
		$chatrecords = spClass("chatrecords");
		if($p=='d2'||$p=='d1')
		{
			//$phonerecords = spClass("phonerecords");
			if($p=='d1')
			{
				$ctype = '電訪';
			}
			if($p=='d2')
			{
				$ctype = '直訪';
			}
			$curdate = date('Y-m-d');	
		    $sql = "SELECT b.`employee_Id`,from_unixtime(b.`dateline`,'%Y-%m-%d') as `Contact_datetime`,c.`name` as customers_Name,c.`id` as customers_Id,c.`nick` as shortName FROM `business_record` b,crm_crm_view c WHERE b.customers_Id=c.id and  from_unixtime(b.`dateline`,'%Y-%m-%d') between '$start' and '$end' and b.`employee_Id`=$id and b.`Contact_TypeName`='$ctype'  and from_unixtime(b.`dateline`,'%Y-%m-%d')<'$curdate'";       
		    $precords = $chatrecords->findSql($sql);
			
			//$precords = $phonerecords->findSql($sql);
			//$pointer = 0;
			$start = strtotime($weeks['s']);
		    $end   = strtotime($weeks['e']);
			for($i=$start;$i<=$end;$i=$i+(24*3600))
			{
				foreach($precords as $recode){
					
					if($recode['Contact_datetime']==date('Y-m-d',$i))
					{
					   $results[$recode['Contact_datetime']][]='<a href="javascript:void(0)" onclick="gotocrm('.$recode['customers_Id'].')">'.($recode['shortName']?$recode['shortName']:mb_substr($recode['customers_Name'],0,4,'utf-8')).'</a>';
					}
				}
				//$pointer++;
			}
			//print_r($results);
		}else{
			//$salesrecord = spClass("salesrecord");
			if($p=='d3')
			{
				$ctype = '不排斥';
			}
			if($p=='d4')
			{
				$ctype = '有意願';
			}
			if($p=='d5')
			{
				$ctype = '被阻擋';
			}
			if($p=='d6')
			{
				$ctype = '人不在';
			}
			if($p=='d7')
			{
				$ctype = '無意願';
			}
			if($p=='d8')
			{
				$ctype = '大事件';
			}
			$start = $weeks['s'];
		    $end   = $weeks['e'];
			$curdate = date('Y-m-d');	
		    $sql = "SELECT b.`employee_Id`,from_unixtime(b.`dateline`,'%Y-%m-%d') as `Contact_datetime`,b.`attitude`,c.`name` as customers_Name,c.`id` as customers_Id,c.`nick` as shortName FROM `business_record` b,crm_crm_view c WHERE b.customers_Id=c.id and  from_unixtime(b.`dateline`,'%Y-%m-%d') between '$start' and '$end' and b.`employee_Id`=$id and b.`attitude`='$ctype' and from_unixtime(b.`dateline`,'%Y-%m-%d')<'$curdate' "; 
		   $records = $chatrecords->findSql($sql);        
			
		   //$records = $salesrecord->findSql($sql);
		   $start = strtotime($weeks['s']);
		   $end   = strtotime($weeks['e']);
		   for($i=$start;$i<=$end;$i=$i+(24*3600))
			{
				foreach($records as $recode){
					
					if($recode['Contact_datetime']==date('Y-m-d',$i))
					{
					   $results[$recode['Contact_datetime']][]='<a href="javascript:void(0)" onclick="gotocrm('.$recode['customers_Id'].')">'.($recode['shortName']?$recode['shortName']:mb_substr($recode['customers_Name'],0,4,'utf-8')).'</a>';
					}
				}
				//$pointer++;
			}
		}
		
		$str = '';
		$max = 0;
		foreach($results as $key=>$result)
		{
			if($max<=count($result))
			{
				$max = count($result);
			}
		}
		for($k=0;$k<$max;$k++){	
		    $str.='<tr class="'.$classname.'" bgcolor="#cccccc"><td></td>';
			for($i=$start;$i<=$end;$i=$i+(24*3600))
			{
				
				 $str.='<td>'.$results[date('Y-m-d',$i)][$k].'</td>';
			}
			$str.='</tr>';
		}
		echo $str;
		
	}
	
	function getappm()
	{
		session_start();
		$firstid = $this->spArgs('id');
		$index = $this->spArgs('index');
		$_SESSION['index']=$index;
		include_once(APP_PATH."/class/localdate.php");
		$localdate = new localdate();
		$id = $this->spArgs('id');
		$_SESSION['index'] = $this->spArgs('index');
		$classname = $this->spArgs('classname');
		$p = $this->spArgs('p');
		if(!$_SESSION['thisweek']){
			$nweek = $localdate->getweek(date('Y-m-d'));
			if($nweek['w']==1)
			{
				$preweek=$localdate->getweek((date('Y')-1).'-12-31');
			}else
			{
				$preweek=$nweek;
				//$preweek['w']=$preweek['w']-1;
			}
		//weeklist = $localdate->getweeklist();
		}else
		{
			$pwk = explode('-',$_SESSION['thisweek']);
			$preweek['y']=$pwk[0];
			$preweek['w']=$pwk[1];
		}
		$weeks = $localdate->getweekday($preweek['y'],$preweek['w']);
		$start = $weeks['s'];
		$end   = $weeks['e'];
		//$chatrecords = spClass("chatrecords");
			
		$curdate = date('Y-m-d');	
		$chatrecords = spClass("chatrecords");
		$sql = "SELECT count(*) as rcount,`Contact_TypeName`,`employee_Id`,`Contact_datetime` FROM `business_record` WHERE `Contact_datetime` between '$start' and '$end' and `employee_Id`=$id   group by `Contact_datetime`";   
		//echo $sql;
		$records = $chatrecords->findSql($sql);
		
		$selfchat = $records ;
	
		/*foreach($records as $key=>$v)
		{
			switch($v['Contact_TypeName'])
			{
				//case '電訪':$phonechat[]=$v; break;
				case '直訪':$selfchat[]=$v; break;
				//case '現有客戶':$alreadcm[]=$v; break;
			}
		}*/
		//print_r($precords);
		
		$qpointer =  $pointer= 0;
	    $secondrecord =array();
		$start = strtotime($weeks['s']);
		$end   = strtotime($weeks['e']);
		for($i=$start;$i<=$end;$i=$i+(24*3600))
		{
			//$temp = array();
			
			if($selfchat[$qpointer]['Contact_datetime']==date('Y-m-d',$i))
			{	
				$secondrecord[$pointer]=$selfchat[$qpointer];
				$qpointer++;
			}else
			{
				$secondrecord[$pointer]['rcount']=0;
				$secondrecord[$pointer]['Contact_datetime']=date('Y-m-d',$i);
			}
			
			
			$pointer++;
		}

		$this->selfchat = $secondrecord;
		
		
		//print_r($records);
		$this->display("getappm.html");
	}
	
	function getappmcust()
	{
		session_start();
		$firstid = $this->spArgs('id');
		$index = $this->spArgs('index');
		$_SESSION['index']=$index;
		include_once(APP_PATH."/class/localdate.php");
		$localdate = new localdate();
		$id = $this->spArgs('id');
		$classname = $this->spArgs('classname');
		$p = $this->spArgs('p');
		if(!$_SESSION['thisweek']){
			$nweek = $localdate->getweek(date('Y-m-d'));
			if($nweek['w']==1)
			{
				$preweek=$localdate->getweek((date('Y')-1).'-12-31');
			}else
			{
				$preweek=$nweek;
				//$preweek['w']=$preweek['w']-1;
			}
		//weeklist = $localdate->getweeklist();
		}else
		{
			$pwk = explode('-',$_SESSION['thisweek']);
			$preweek['y']=$pwk[0];
			$preweek['w']=$pwk[1];
		}
		$weeks = $localdate->getweekday($preweek['y'],$preweek['w']);
		$start = $weeks['s'];
		$end   = $weeks['e'];
		$chatrecords = spClass("chatrecords");
		
			//$salesrecord = spClass("salesrecord");
			
			$start = $weeks['s'];
		    $end   = $weeks['e'];
			$curdate= date('Y-m-d');
		    $sql = "SELECT b.`employee_Id`,b.`Contact_datetime`,c.customers_Name,c.shortName,b.customers_Id FROM `business_record` b,customers c WHERE b.customers_Id=c.customers_Id and  b.`Contact_datetime` between '$start' and '$end' and b.`employee_Id`=$id "; 
		   $records = $chatrecords->findSql($sql);        
			
		   //$records = $salesrecord->findSql($sql);
		   $start = strtotime($weeks['s']);
		   $end   = strtotime($weeks['e']);
		   for($i=$start;$i<=$end;$i=$i+(24*3600))
			{
				foreach($records as $recode){
					
					if($recode['Contact_datetime']==date('Y-m-d',$i))
					{
					   $results[$recode['Contact_datetime']][]='<a href="javascript:void(0)" onclick="gotocrm('.$recode['customers_Id'].')">'.($recode['shortName']?$recode['shortName']:mb_substr($recode['customers_Name'],0,4,'utf-8')).'</a>';
					}
				}
				//$pointer++;
			}
		
		
		$str = '';
		$max = 0;
		foreach($results as $key=>$result)
		{
			if($max<=count($result))
			{
				$max = count($result);
			}
		}
		for($k=0;$k<$max;$k++){	
		    $str.='<tr class="'.$classname.'" bgcolor="#cccccc"><td></td>';
			for($i=$start;$i<=$end;$i=$i+(24*3600))
			{
				
				 $str.='<td>'.$results[date('Y-m-d',$i)][$k].'</td>';
			}
			$str.='</tr>';
		}
		echo $str;
	}
	
	function getres()
	{
		session_start();
		$firstid = $this->spArgs('id');
		$index = $this->spArgs('index');
		$_SESSION['index']=$index;
		include_once(APP_PATH."/class/localdate.php");
		$localdate = new localdate();
		if(!$_SESSION['thisweek']){
			$nweek = $localdate->getweek(date('Y-m-d'));
			if($nweek['w']==1)
			{
				$preweek=$localdate->getweek((date('Y')-1).'-12-31');
			}else
			{
				$preweek=$nweek;
				//$preweek['w']=$preweek['w']-1;
			}
		//weeklist = $localdate->getweeklist();
		}else
		{
			$pwk = explode('-',$_SESSION['thisweek']);
			$preweek['y']=$pwk[0];
			$preweek['w']=$pwk[1];
		}
		$weeks = $localdate->getweekday($preweek['y'],$preweek['w']);
		$start = strtotime($weeks['s']);
		$end   = strtotime($weeks['e']);
			
			
		$casetables = spClass("casetables");
		$sql = "SELECT count(c.`id`) as count, t.`name` as customers_Name,t.`id` as customers_Id,from_unixtime(c.`exptime`,'%Y-%m-%d') as localdate FROM `crm_contract` c ,crm_crm_view t,eip_user e WHERE c.`id`=t.id and c.`eid` =e.`id` and e.id=$firstid and c.`exptime` between $start and $end group by from_unixtime(c.`exptime`,'%Y-%m-%d')  with rollup ";       
		$records = $casetables->findSql($sql);
		
		$sql = "SELECT c.`cid` as customer_id, t.`name` as customers_Name,t.`nick` as shortName,t.`id` as customers_Id,from_unixtime(c.`exptime`,'%Y-%m-%d') as localdate FROM `crm_contract` c ,crm_crm_view t ,eip_user e WHERE c.`cid`=t.id and c.`eid` =e.`id` and e.id=$firstid and c.`exptime` between $start and $end";       
		$derecords = $casetables->findSql($sql);
		
		
		//print_r($precords);
		$npointer =$pointer=$sum= 0;
		$firstrecord = $second = array();
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
		$this->newcm = $firstrecord;
		$this->sum=$sum;
		$this->display("getresdata.html");
	}
	
	function getapptotal()
	{
		session_start();
		$firstid = $this->spArgs('id');
		$index = $this->spArgs('index');
		$_SESSION['index']=$index;
		include_once(APP_PATH."/class/localdate.php");
		$localdate = new localdate();
		if(!$_SESSION['thisweek']){
			$nweek = $localdate->getweek(date('Y-m-d'));
			if($nweek['w']==1)
			{
				$preweek=$localdate->getweek((date('Y')-1).'-12-31');
			}else
			{
				$preweek=$nweek;
				//$preweek['w']=$preweek['w']-1;
			}
		//weeklist = $localdate->getweeklist();
		}else
		{
			$pwk = explode('-',$_SESSION['thisweek']);
			$preweek['y']=$pwk[0];
			$preweek['w']=$pwk[1];
		}
		$weeks = $localdate->getweekday($preweek['y'],$preweek['w']);
		$start = $weeks['s'];
		$end   = $weeks['e'];
		//$month = date('m',strtotime($start));
		
		$curdate = date('Y-m-d');	
		$chatrecords = spClass("chatrecords");
		$sql = "select if(t.rcount is null,0,t.rcount) rcount,t.Contact_TypeName,if(t.Contact_datetime is null, '$start',t.Contact_datetime) as Contact_datetime,if(s.daim is null,0,s.daim) as daim,e.`id` as employee_Id from eip_user e left join (SELECT count(b.`Brecord_Id`) rcount,b.`Contact_TypeName`,b.`employee_Id`,from_unixtime(b.`dateline`,'%Y-%m-%d') as `Contact_datetime` FROM `business_record` b  WHERE from_unixtime(b.`dateline`,'%Y-%m-%d') between '$start' and '$end' group by b.`employee_Id`,`Contact_datetime`) t on e.`id`=t.`employee_Id` left join (select * from appaim where `weeks`='".$_SESSION['thisweek']."') s on e.`id`=s.sid where e.is_job=1 and e.is_anysis=1"; 
		//$sql = "select if(t.rcount is null,0,t.rcount) rcount,t.Contact_TypeName,e.`id` as employee_Id,if(t.Contact_datetime is null, '$start',t.contact_datetime) as Contact_datetime,if(s.daim is null,0,s.daim) as daim from eip_user e left join (SELECT count(*) rcount,`Contact_TypeName`,`employee_Id`,s.`daim`,`Contact_datetime` FROM `business_record` a  left join (select * from appaim where `weeks`='".$_SESSION['thisweek']."') s on a.`employee_Id`=s.`sid` WHERE `Contact_datetime` between '$start' and '$end' group by `employee_Id`,`Contact_datetime`";   
		//$pointer = 0;
		$records = $chatrecords->findSql($sql);
		//$newcm = $qiancm = $alreadcm = array();
		
		//var_dump( $records );
		//$newcm = $qiancm = $alreadcm = array();
		
		$pointer= 1;
		$firstrecord = array();
		$firstrecordd =array();
		$round1=array();
		$daim=array();
		
		foreach($records as $key=>$v)
		{
			$firstrecord[$v['employee_Id']][$v['Contact_datetime']]=$v['rcount'];
			$firstrecord[$v['employee_Id']][0]=$v['employee_Id'];
			$daim[$v['employee_Id']]=$v['daim'];
		}
		
		
		//print_r($firstrecord);
		
	    $t = array();
		$start = strtotime($weeks['s']);
		$end   = strtotime($weeks['e']);
		for($i=$start;$i<=$end;$i=$i+(24*3600))
		{
			foreach($firstrecord as $key=>$v)
			{
				//echo $v[date('Y-m-d',$i)];
				if($v[date('Y-m-d',$i)])
				{
					$firstrecordd[$key][$pointer]=$v[date('Y-m-d',$i)];
					$t[$key]+=$v[date('Y-m-d',$i)];
				}elseif(!$firstrecordd[$key][$pointer])
				{
					$firstrecordd[$key][$pointer]=0;
				}
				if($pointer==7)
				{
					if(!$t[$key]) {
						$t[$key]=0;
					}
					$firstrecordd[$key][8] = $t1[$key];
					if( $firstrecordd[$key][8] < $aim1[$key] ) {
						$color="red";
					} else {
						$color="blue";
					}
					$firstrecordd[$key][8]='<font color="' . $color . '">' . $t[$key] . '</font>';
					$round1[$key]=round($daim[$key]/5);
					$firstrecordd[$key][9]=$round1[$key];
					//echo $daim[$key];
					$firstrecordd[$key][10]='<div contentEditable="true" onblur="updateaim(this)" sid="'.$key.'" wid="'.$_SESSION['thisweek'].'" t="daim"  style="height:19px;">'.$daim[$key].'</div>';					
					if($t[$key]>=$daim[$key]) {
						$colorarr[$key]='black';
					}else{
						$colorarr[$key]='red';
					}
				}
			}
			
			$pointer++;
		}
		
		$employees = spClass("employees"); 
		//$sql = "select employee_Id,employee_Name from ";
		//$argsw = $this->spArgs('w');
		//、$conditions = array('is_sales'=>1);
		$sales = $employees->findAll(NULL,NULL,'`id`,`name`');
		foreach($sales as $key=>$v)
		{
			$tempsales[$v['id']]=$v['name'];
		}
		foreach( $firstrecordd as $k => $v ) {
			for( $i = 1; $i <= 7; $i++ ) {
				if( $firstrecordd[$k][$i] < $firstrecordd[$k][9] ) {
					$firstrecordd[$k][$i] = '<font color="red">' . $firstrecordd[$k][$i] . '</font>';
				} else {
					$firstrecordd[$k][$i] = '<font color="blue">' . $firstrecordd[$k][$i] . '</font>';
				}
			}
		}
		$tempsales[0]='未指定';
		//var_dump( $firstrecordd );
		$this->newcm = $firstrecordd;
		
		$this->sales = $tempsales;
		$this->display("getapptotal.html");
	}
	
	function getrestotal()
	{
		session_start();
		$firstid = $this->spArgs('id');
		$index = $this->spArgs('index');
		$_SESSION['index']=$index;
		include_once(APP_PATH."/class/localdate.php");
		$localdate = new localdate();
		$employees = spClass("employees"); 
		//$sql = "select employee_Id,employee_Name from ";
		//$argsw = $this->spArgs('w');
		$conditions = array('is_job'=>1,'is_anysis'=>1);
		$sales = $employees->findAll($conditions,NULL,'`id`,`name`');
		foreach($sales as $key=>$v)
		{
			$tempsales[$v['id']]=$v['name'];
		}
		$tempsales[0]='未指定';
		if(!$_SESSION['thisweek']){
			$nweek = $localdate->getweek(date('Y-m-d'));
			if($nweek['w']==1)
			{
				$preweek=$localdate->getweek((date('Y')-1).'-12-31');
			}else
			{
				$preweek=$nweek;
				//$preweek['w']=$preweek['w']-1;
			}
		//weeklist = $localdate->getweeklist();
		}else
		{
			$pwk = explode('-',$_SESSION['thisweek']);
			$preweek['y']=$pwk[0];
			$preweek['w']=$pwk[1];
		}
		$weeks = $localdate->getweekday($preweek['y'],$preweek['w']);
		$start = strtotime($weeks['s']);
		$end   = strtotime($weeks['e']);
		$round1=array();
		$daim=array();
		//$month = date('m',strtotime($start));
		
		$casetables = spClass("casetables");
		$sql = "SELECT count(c.`id`) as rcount, if(c.`eid` is null, s.`sid`,c.eid) as employee,s.`daim`,from_unixtime(`exptime`,'%Y-%m-%d') as localdate,exptime FROM `crm_contract` c right join (select * from resaim where `weeks`='".$_SESSION['thisweek']."') s on c.`eid`=s.`sid` and `exptime` between $start and $end group by from_unixtime(c.`exptime`,'%Y-%m-%d'),`employee`";       
		$records = $casetables->findSql($sql);   
		//$pointer = 0;
		//$records = $chatrecords->findSql($sql);
		//$newcm = $qiancm = $alreadcm = array();
		//echo $sql;
		$sql = "select id from eip_user where is_job=1 and is_anysis=1";
		$eipuserlist = $casetables->findSql($sql);
		//$newcm = $qiancm = $alreadcm = array();
		$pointer= 1;
		$firstrecord = array();
		$firstrecordd =array();
		//$tempsales = array();
		
		foreach($records as $key=>$v)
		{
			$firstrecord[$v['employee']][$v['localdate']]=$v['rcount'];
			//$tempsales[$v['employee']]=$v['employee'];
			$daim[$v['employee']]=$v['daim'];
		}
		
		
		//print_r($firstrecord);
	    $t = array();
		
		for($i=$start;$i<=$end;$i=$i+(24*3600))
		{
			foreach($firstrecord as $key=>$v)
			{
				//echo $v[date('Y-m-d',$i)];
				if($v[date('Y-m-d',$i)])
				{
					$firstrecordd[$key][$pointer]=$v[date('Y-m-d',$i)];
					$t[$key]+=$v[date('Y-m-d',$i)];
				}elseif(!$firstrecordd[$key][$pointer])
				{
					$firstrecordd[$key][$pointer]=0;
				}
				if($pointer==7)
				{
					$firstrecordd[$key][8] = $t[$key];
					if( $firstrecordd[$key][8] < $daim[$key] ) {
						$color="red";
					} else {
						$color="blue";
					}
					$firstrecordd[$key][8]='<font color="' . $color . '">' . $t[$key] . '</font>';
					$round1[$key]=round($daim[$key]/5);
					$firstrecordd[$key][9]=$round1[$key];
					//echo $daim[$key];
					$firstrecordd[$key][10]='<div contentEditable="true" onblur="updateaim(this)" sid="'.$key.'" wid="'.$_SESSION['thisweek'].'" t="daim"  style="height:19px;">'.$daim[$key].'</div>';					
					if($t[$key]>=$daim[$key]) {
						$colorarr[$key]='black';
					}else{
						$colorarr[$key]='red';
					}
				}
			}
			foreach( $eipuserlist as  $val ) {
				if(!$firstrecordd[$val['id']][$pointer]) {
					$firstrecordd[$val['id']][$pointer]=0;
					//$tempsales[$val['id']]=$val['id'];
					$daim[$val['id']] = 0;
					foreach( $records as $subval ) {
						if( $subval['employee'] == $val['id'] ) {
							$daim[$val['id']] =  $subval['daim'];
						}
					}
				}
				if($pointer==7) {
					if(!$t[$val['id']]) {
						$t[$val['id']]=0;
					}
					$round1[$val['id']]=round($daim[$val['id']]/5);
					$firstrecordd[$val['id']][8] = $t[$val['id']];
					$firstrecordd[$val['id']][9]=$round1[$val['id']];
					$firstrecordd[$val['id']][10]='<div contentEditable="true" onblur="updateaim(this)" sid="'.$val['id'].'" wid="'.$_SESSION['thisweek'].'" t="daim"  style="height:19px;">'.$daim[$val['id']].'</div>';
				}
			}
			$pointer++;
		}
		
		foreach( $firstrecordd as $k => $v ) {
			for( $i = 1; $i <= 7; $i++ ) {
				if( $firstrecordd[$k][$i] < $firstrecordd[$k][9] ) {
					$firstrecordd[$k][$i] = '<font color="red">' . $firstrecordd[$k][$i] . '</font>';
				} else {
					$firstrecordd[$k][$i] = '<font color="blue">' . $firstrecordd[$k][$i] . '</font>';
				}
			}
		}
		$this->newcm = $firstrecordd;
		
		$this->sales = $tempsales;
		$this->display("getrestotal.html");
	}
	
	function updateaim()
	{
		$saims = spClass("aims");
		$sid = $this->spArgs('id');
		$w = $this->spArgs('w');
		$v = $this->spArgs('v');
		$t = $this->spArgs('t');
		
		$conditions =array('sid'=>$sid,'weeks'=>$w);
		$sum = $saims->findCount($conditions);
		if($sum)
		{
			$newrow=array($t=>$v);
			$saims->update($conditions,$newrow);
		}else
		{
			$newrow = array(
		      'sid'=>$sid,
		      'weeks'=>$w,
		      $t=>$v
		    );
		   $id = $saims->create($newrow);
		}
		
		//echo $id;
	}

	function updatedevaim()
	{
		$saims = spClass("devaims");
		$sid = $this->spArgs('id');
		$w = $this->spArgs('w');
		$v = $this->spArgs('v');
		$t = $this->spArgs('t');
		
		$conditions =array('sid'=>$sid,'weeks'=>$w);
		$sum = $saims->findCount($conditions);
		if($sum)
		{
			$newrow=array($t=>$v);
			$saims->update($conditions,$newrow);
		}else
		{
			$newrow = array(
		      'sid'=>$sid,
		      'weeks'=>$w,
		      $t=>$v
		    );
		   $id = $saims->create($newrow);
		}
		
		//echo $id;
	}

	function updateappaim()
	{
		$saims = spClass("appaims");
		$sid = $this->spArgs('id');
		$w = $this->spArgs('w');
		$v = $this->spArgs('v');
		$t = $this->spArgs('t');
		
		$conditions =array('sid'=>$sid,'weeks'=>$w);
		$sum = $saims->findCount($conditions);
		if($sum)
		{
			$newrow=array($t=>$v);
			$saims->update($conditions,$newrow);
		}else
		{
			$newrow = array(
		      'sid'=>$sid,
		      'weeks'=>$w,
		      $t=>$v
		    );
		   $id = $saims->create($newrow);
		}
		
		//echo $id;
	}

	function updateresaim()
	{
		$saims = spClass("resaims");
		$sid = $this->spArgs('id');
		$w = $this->spArgs('w');
		$v = $this->spArgs('v');
		$t = $this->spArgs('t');
		
		$conditions =array('sid'=>$sid,'weeks'=>$w);
		$sum = $saims->findCount($conditions);
		if($sum)
		{
			$newrow=array($t=>$v);
			$saims->update($conditions,$newrow);
		}else
		{
			$newrow = array(
		      'sid'=>$sid,
		      'weeks'=>$w,
		      $t=>$v
		    );
		   $id = $saims->create($newrow);
		}
		
		//echo $id;
	}
}