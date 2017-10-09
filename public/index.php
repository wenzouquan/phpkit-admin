<?php
// require '../vendor/autoload.php'; //自动加载
// use phpkit\core\Phpkit as Phpkit;
// $Phpkit = new Phpkit();
// $config = array(
// 	'appDir' => dirname(dirname(__FILE__)),
// 	'appBaseUri' => 'phpkit-admin',
// );
// $Phpkit->Run($config);


define("phpkitRoot", dirname(dirname(__FILE__)));
require phpkitRoot.'/vendor/autoload.php';
use phpkit\core\Phpkit as Phpkit;
$phpkit = new Phpkit();
$setting = require phpkitRoot . '/config/setting.php';
//初始化phpkit
$app = $phpkit->Run($setting);