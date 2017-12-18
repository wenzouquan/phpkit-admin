<?php
// require '../vendor/autoload.php'; //自动加载
// use phpkit\core\Phpkit as Phpkit;
// $Phpkit = new Phpkit();
// $config = array(
// 	'appDir' => dirname(dirname(__FILE__)),
// 	'appBaseUri' => 'phpkit-admin',
// );
// $Phpkit->Run($config);


define("phpkitRoot", dirname(dirname(__FILE__)));//
require dirname(dirname(phpkitRoot)).'/vendor/autoload.php';
use phpkit\core\Phpkit as Phpkit;
$phpkit = new Phpkit();
$setting = require phpkitRoot. '/config/setting.php';
$setting['registerDirs'] =  array(
		 phpkitRoot . '/controllers', //Controller目录
		 phpkitRoot . '/models', //Model层实现目录
	);

//初始化phpkit
$app = $phpkit->Run($setting);