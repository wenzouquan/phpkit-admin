<?php
require '../../vendor/autoload.php'; //自动加载
use phpkit\core\Phpkit as Phpkit;
$Phpkit = new Phpkit();
$config = array(
	'appDir' => dirname(dirname(__FILE__)),
	'appBaseUri' => 'phpkit-admin',
);
$Phpkit->Run($config);
