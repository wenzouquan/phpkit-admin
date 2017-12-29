<?php
$setting = array(
	'appDir' => phpkitRoot,
	'appBaseUri'=>'phpkit-admin',
    'cacheDir'=>dirname(dirname(dirname(dirname(__FILE__))))."/runtime/phpkitCache/",
    'viewsDir'=>phpkitRoot."/views/",
    'registerNamespaces' => array(
		'services' => dirname(dirname(dirname(phpkitRoot))) . '/services', //服务层目录
	),
	'adminUrl'=>array('default'=>'http://www.makelog.me:81/phpkit-admin','__admin__'=>'http://www.makelog.me:81/admin'),
	'asstesUrl'=>'http://www.makelog.me:81/phpkit-admin/public/asstes',
	'adminTitle'=>'makelog 后台管理',
);

$setting['di'] = require phpkitRoot."/config/di.php";
return $setting;