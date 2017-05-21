<?php
	/*** 
		* db.config.php
		* 資料庫資訊
		*
		* 資料庫的配置與基本的 ThinkPHP 配置
	***/
	if (!defined('PHOTONICCMS')) exit();
	
	return array(
	/////// 資料庫 erp_qhand ///////
    // 資料庫類型
	
	'DB_TYPE' => 'mysql',

	// Database Server 位址
	'DB_HOST' => 'localhost',
	// 使用的資料庫名稱
	'DB_NAME' => 'touch_travel',
	// 登入 SQL 的用戶帳號
	'DB_USER' => 'root',
	'DB_PWD' => '',
	
	// 登入資料庫使用的 port
	'DB_PORT' => '3306',
	// 資料庫的名稱前綴
	'DB_PREFIX' => '',
	'ADMIN_ACCESS' => '61d6357d687a74ee3427a734860881ce',
	'URL_ROUTER_ON' => false,
	'URL_DISPATCH_ON' => true,
	'DEFAULT_THEME' => 'default',
	'TOKEN_ON' => false,
	'TOKEN_NAME' => '__hash__',
	'TOKEN_TYPE' => 'md5',
	'TMPL_CACHE_ON' => false,
	'TMPL_CACHE_TIME' => -1,
	'DB_FIELDS_CACHE' => false
	);
	
?>