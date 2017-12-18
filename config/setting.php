<?php
$setting = array(
	'appDir' => phpkitRoot,
	'appBaseUri'=>'phpkit-admin',
    'cacheDir'=>dirname(dirname(dirname(dirname(__FILE__))))."/runtime/phpkitCache/",
    'viewsDir'=>phpkitRoot."/views/",
    'registerNamespaces' => array(
		'services' => dirname(dirname(dirname(phpkitRoot))) . '/services', //服务层目录
	),
	'adminUrl'=>array('default'=>'http://www.makelog.me/phpkit-admin','__admin__'=>'http://www.makelog.me/admin'),
	'asstesUrl'=>'http://www.makelog.me/phpkit-admin/asstes',
	'adminTitle'=>'makelog 后台管理',
);

$setting['di'] = require phpkitRoot."/config/di.php";
return $setting;