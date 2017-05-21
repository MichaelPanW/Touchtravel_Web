<?php 
/***
 * index.php
 * 系统首頁
 *
 * 基本的配置與 debug OC
 ***/

header("Content-type: text/html; charset=UTF-8");
if (!file_exists('./db.config.php')) die('db.config.php 不存在，請正常安裝系统');
date_default_timezone_set('Asia/Taipei');
define('PHOTONICCMS', './Touch');
define('CMS_DATA', './CmsData');
define('UPLOAD_PATH', './Uploads');
define('URL_MODEL', 'PATHINFO');
define('APP_DEBUG', true); // true=debug
define('NO_CACHE_RUNTIME', false); // true=debug
//define('APP_NAME', 'Erp'); //3.0 down version
// 不想使用預設的 Home
define('BIND_MODULE','Trade');
define('APP_PATH', './Touch/');
require "./ThinkPHP/ThinkPHP.php";
//App::run(); //3.0 down version

//require "Erp/ThinkPHP/ThinkPHP.php";

?>