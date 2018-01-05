<?php
$setting = array(
	'appDir' => phpkitRoot,
	'appBaseUri'=>'',
    'cacheDir'=>dirname(dirname(__FILE__))."/cache/",
    'viewsDir'=>phpkitRoot."/views/",
    'registerNamespaces' => array(
		'services' => dirname(dirname(dirname(phpkitRoot))) . '/services', //服务层目录
	),
	'adminUrl'=>array('default'=>'http://phpkit-admin.com'),
	'asstesUrl'=>'http://phpkit-admin.com/asstes',
	'adminTitle'=>'后台管理',
);

$setting['di'] = require phpkitRoot."/config/di.php";
return $setting;