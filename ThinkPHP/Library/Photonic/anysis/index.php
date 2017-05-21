<?php

error_reporting(0);

session_start();

if(!isset($_SESSION['eid'])||empty($_SESSION['eid'])) {

   //setcookie('refer',$_SERVER['REQUEST_URI']);

   echo "<script language='javascript'>location.href='../index.php';</script>";

   exit();

}

$_SESSION['index']=$_SESSION['index']?$_SESSION['index']:1;

define("APP_PATH",dirname(__FILE__));

define("SP_PATH",dirname(__FILE__).'/SpeedPHP');

$spConfig = array(

'mode' => 'debug',

'db' => array(  // 数据库连接配置

		'driver' => 'mysql',   // 驱动类型

		'host' => 'localhost', // 数据库地址

		'port' => 3306,        // 端口

		'login' => 'dayfor_user',     // 用户名

		'password' => 'pv001',      // 密码

		'database' => 'erp_qhand',      // 库名称

		'prefix' => '',           // 表前缀

		'persistent' => FALSE,    // 是否使用长链接

	),

'view' => array( // 视图配置

		'enabled' => TRUE, // 开启视图

		'config' =>array(

			'template_dir' => APP_PATH.'/tpl', // 模板目录

			'compile_dir' => APP_PATH.'/tmp', // 编译目录

			'cache_dir' => APP_PATH.'/tmp', // 缓存目录

			'left_delimiter' => '<{',  // smarty左限定符

			'right_delimiter' => '}>', // smarty右限定符

			'auto_literal' => TRUE, // Smarty3新特性

		),

		'html' => array(  // HTML生成配置  



         'enabled' => TRUE, // 开启HTML生成功能  



        ),  

	   'url' => array( // URL设置

		 'url_path_info' => TRUE,//FALSE, // 是否使用path_info方式的URL

		 'url_path_base' => '', // URL的根目录访问地址，默认为空则是入口文件index.php

	   ),



        'debugging' => FALSE, // 是否开启视图调试功能，在部署模式下无法开启视图调试功能

		'engine_name' => 'Smarty', // 模板引擎的类名称，默认为Smarty

		'engine_path' => SP_PATH.'/Drivers/Smarty/Smarty.class.php', // 模板引擎主类路径

		'auto_ob_start' => FALSE, // 是否自动开启缓存输出控制

		'auto_display' => FALSE, // 是否使用自动输出模板功能

		'auto_display_sep' => '/', // 自动输出模板的拼装模式，/为按目录方式拼装，_为按下划线方式，以此类推

		'auto_display_suffix' => '.html', // 自动输出模板的后缀名

	),

);

require(SP_PATH."/SpeedPHP.php");

spRun();