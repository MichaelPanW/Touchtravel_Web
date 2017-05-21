<?php
	namespace Photonic;
	class Permissions
	{
		function __construct()
		{
			$perclass_data = array(	
			"name" => array(
			"type" => "varchar(255)",
			"name" => "權限類別標題",
			"null" => true,
			'input' => 'text',
			'showeTable' => true,
			),
			);
			
			$perclass = new  \Photonic\Microcore($perclass_data, "im_perclass");
			$perclass->init();
			
			$perdata_data = array(	
			"class" => array(
			"type" => "int",
			"name" => "權限類別",
			'associate' => ' `im_perclass`(`n`) ',
			"null" => true,
			'input' => 'text',
			'showeTable' => true,
			),
			"name" => array(
			"type" => "varchar(255)",
			"name" => "權限名稱",
			"null" => true,
			'input' => 'text',
			'showeTable' => true,
			),
			"data" => array(
			"type" => "text",
			"name" => "權限內容",
			"null" => true,
			'input' => 'text',
			'showeTable' => true,
			),
			);
			
			$perdata = new  \Photonic\Microcore($perdata_data, "im_perdata");
			$perdata->init();
			
			$peritem[1]['name']='人事行政'; 
			$peritem[1]['menu'][1] = array( 'title' => '個資 ', 'readself' => true,  'readall' => true,  'new' => true,  'update' => true,  'del' => true,  'truncate' => true, );
			$peritem[1]['menu'][2] = array( 'title' => '部門管理 ', 'readself' => false,  'readall' => false,  'new' => true,  'update' => true,  'del' => true,  'truncate' => true, );
			$peritem[1]['menu'][3] = array( 'title' => '組織管理 ', 'readself' => true,  'readall' => true,  'new' => false,  'update' => false,  'del' => false,  'truncate' => false, );
			$peritem[1]['menu'][4] = array( 'title' => '權限管理 ', 'readself' => false,  'readall' => false,  'new' => true,  'update' => true,  'del' => true,  'truncate' => false, );
			$peritem[1]['menu'][5] = array( 'title' => '公司規章', 'readself' => true,  'readall' => true,  'new' => true,  'update' => true,  'del' => true,  'truncate' => true, );
			$peritem[1]['menu'][6] = array( 'title' => '業務準則', 'readself' => true,  'readall' => true,  'new' => true,  'update' => true,  'del' => true,  'truncate' => true, );
			$peritem[1]['menu'][7] = array( 'title' => '公告管理', 'readself' => true,  'readall' => true,  'new' => true,  'update' => true,  'del' => true,  'truncate' => true, );
			$peritem[1]['menu'][8] = array( 'title' => '業務教育 ', 'readself' => true,  'readall' => true,  'new' => true,  'update' => true,  'del' => true,  'truncate' => true, );
			$peritem[1]['menu'][9] = array( 'title' => '通訊錄', 'readself' => true,  'readall' => true,  'new' => false,  'update' => false,  'del' => false,  'truncate' => false, );
			$peritem[1]['menu'][10] = array( 'title' => ' EIP歷程', 'readself' => true,  'readall' => true,  'new' => false,  'update' => false,  'del' => false,  'truncate' => false, );
			$peritem[1]['menu'][11] = array( 'title' => '我的連結', 'readself' => false,  'readall' => true,  'new' => true,  'update' => true,  'del' => false,  'truncate' => false, );
			$peritem[1]['menu'][12] = array( 'title' => '重要文件', 'readself' => true,  'readall' => true,  'new' => true,  'update' => true,  'del' => true,  'truncate' => true, );
			$peritem[1]['menu'][13] = array( 'title' => '人才庫', 'readself' => true,  'readall' => true,  'new' => true,  'update' => true,  'del' => true,  'truncate' => true, );
			
			$peritem[2]['name']='客戶管理';
			$peritem[2]['menu'][1] = array( 'title' => '客戶列表', 'readself' => true,  'readall' => true,  'new' => false,  'update' => true,  'del' => true,  'truncate' => true, );
			$peritem[2]['menu'][2] = array( 'title' => 'CRM', 'readself' => true,  'readall' => true,  'new' => true,  'update' => true,  'del' => true,  'truncate' => true, );
			$peritem[2]['menu'][3] = array( 'title' => '小事件', 'readself' => true,  'readall' => true,  'new' => true,  'update' => true,  'del' => true,  'truncate' => false, );
			$peritem[2]['menu'][4] = array( 'title' => '連繫', 'readself' => true,  'readall' => true,  'new' => true,  'update' => true,  'del' => true,  'truncate' => false, );
			$peritem[2]['menu'][5] = array( 'title' => '周分析', 'readself' => true,  'readall' => true,  'new' => true,  'update' => true,  'del' => false,  'truncate' => false, );
			$peritem[2]['menu'][6] = array( 'title' => '匯入客戶名單', 'readself' => false,  'readall' => false,  'new' => true,  'update' => false,  'del' => false,  'truncate' => false, );
			$peritem[2]['menu'][7] = array( 'title' => '匯入資料列表', 'readself' => false,  'readall' => false,  'new' => false,  'update' => true,  'del' => true,  'truncate' => false, );
			$peritem[2]['menu'][8] = array( 'title' => '重複名單比對', 'readself' => false,  'readall' => false,  'new' => false,  'update' => true,  'del' => true,  'truncate' => false, );
			$peritem[2]['menu'][9] = array( 'title' => '匯入名單與本機名單比對', 'readself' => false,  'readall' => false,  'new' => false,  'update' => true,  'del' => true,  'truncate' => false, );
			$peritem[2]['menu'][10] = array( 'title' => '匯入完成的名單', 'readself' => false,  'readall' => false,  'new' => false,  'update' => true,  'del' => true,  'truncate' => false, );
			$peritem[2]['menu'][11] = array( 'title' => '其他待處理', 'readself' => false,  'readall' => false,  'new' => false,  'update' => true,  'del' => true,  'truncate' => false, );
			$peritem[2]['menu'][12] = array( 'title' => '批次刪除資料庫客戶名單', 'readself' => false,  'readall' => false,  'new' => false,  'update' => true,  'del' => true,  'truncate' => false, );
			$peritem[2]['menu'][13] = array( 'title' => '外訪地圖', 'readself' => true,  'readall' => true,  'new' => false,  'update' => false,  'del' => false,  'truncate' => false, );
			
			$peritem[3]['name']='銷貨管理 ';
			$peritem[3]['menu'][1] = array( 'title' => '合約處理', 'readself' => true,  'readall' => true,  'new' => true,  'update' => true,  'del' => true,  'truncate' => false, );
			$peritem[3]['menu'][2] = array( 'title' => '出貨管理', 'readself' => true,  'readall' => true,  'new' => true,  'update' => true,  'del' => true,  'truncate' => false, );
			$peritem[3]['menu'][3] = array( 'title' => '請款管理', 'readself' => true,  'readall' => true,  'new' => true,  'update' => true,  'del' => false,  'truncate' => false, );
			$peritem[3]['menu'][4] = array( 'title' => '收款記錄', 'readself' => false,  'readall' => false,  'new' => true,  'update' => true,  'del' => true,  'truncate' => true, );
			$peritem[3]['menu'][5] = array( 'title' => '合約歷程', 'readself' => false,  'readall' => false,  'new' => true,  'update' => true,  'del' => true,  'truncate' => true, );
			$peritem[3]['menu'][6] = array( 'title' => '報表排程異常', 'readself' => true,  'readall' => true,  'new' => false,  'update' => true,  'del' => true,  'truncate' => false, );
			$peritem[3]['menu'][7] = array( 'title' => '績效管理', 'readself' => true,  'readall' => true,  'new' => true,  'update' => true,  'del' => false,  'truncate' => false, );
			
			$peritem[4]['name']='電子報';
			$peritem[4]['menu'][1] = array( 'title' => '帳戶清單', 'readself' => false,  'readall' => true,  'new' => false,  'update' => true,  'del' => true,  'truncate' => false, );
			$peritem[4]['menu'][2] = array( 'title' => '    新增帳戶', 'readself' => false,  'readall' => false,  'new' => true,  'update' => false,  'del' => false,  'truncate' => false, );
			$peritem[4]['menu'][3] = array( 'title' => '    群組清單', 'readself' => false,  'readall' => false,  'new' => false,  'update' => true,  'del' => true,  'truncate' => false, );
			$peritem[4]['menu'][4] = array( 'title' => '    建立群組', 'readself' => false,  'readall' => false,  'new' => true,  'update' => false,  'del' => false,  'truncate' => false, );
			$peritem[4]['menu'][5] = array( 'title' => '電子報清單', 'readself' => false,  'readall' => false,  'new' => false,  'update' => true,  'del' => true,  'truncate' => false, );
			$peritem[4]['menu'][6] = array( 'title' => '    新增電子報', 'readself' => false,  'readall' => false,  'new' => true,  'update' => false,  'del' => false,  'truncate' => false, );
		}
		// $this->getArgs('id')
		/*
			ckper ( 
			$userid, | 帶入登入使用者ID ( $GLOBALS['session']->g_s('eid') )
			$type,   
			| readself = 僅查個人
			| readall = 可查看全部
			| new = 可新增
			| update = 可編輯
			| del = 可刪除
			| truncate = 可清空垃圾桶
			$class,  | 群組編號，參考 class/permissions.php
			$item, 	 | 項目編號，參考 class/permissions.php
			)			 | 回傳 true or false ，代表是否通行 
		*/
		function ckper ( $userid, $type, $class = 1, $item = 1 ){
			global $perclass, $perdata, $peritem;
			$user = $GLOBALS['db']->getAll("SELECT * FROM  `eip_user` WHERE `id` = ".(int)$userid);
			if( count($user) != 1 or (int)$user[0]['usergroupid'] == 0 ){
				return false;
			}
			$nowdata = $perdata->select("`n` = ".(int)$user[0]['usergroupid']);
			if( count($nowdata) == 0){
				return false;
			}
			$nowdata[0]['data'] = json_decode($nowdata[0]['data'], true);
			if( $nowdata[0]['data'][$type][$class][$item] == "true" ){
				return true;
				}else{
				return false;
			}
			}
		}								