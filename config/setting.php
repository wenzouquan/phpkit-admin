<?php
$setting = array(
	'appDir' => phpkitRoot,
	'registerDirs' => array(
		 phpkitRoot . '/app/controllers', //Controller目录
		 phpkitRoot . '/app/models', //Model层实现目录
	),
);

$setting['di'] = require phpkitRoot."/config/di.php";

return $setting;