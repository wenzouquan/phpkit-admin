<?php
/**
 * Created by PhpStorm.
 * User: onsakuquan
 * Date: 17/8/25
 * Time: 下午5:07
 */

//数据库结构缓存,默认apc
 $di['modelsMetadata'] = function () {
      \phpkit\helper\mk_dir(phpkitRoot . '/cache/metadata/');
     $metaData = new \Phalcon\Mvc\Model\Metadata\Files([
         "metaDataDir" => phpkitRoot . '/cache/metadata/',
     ]);
     return $metaData;
 };
            

//配置读取类
$di['config'] = function () {
    $params = array(
        'configDir' => phpkitRoot . '/config/',
    );
    $config = new \phpkit\config\Config($params);
    return $config;
};

//数据库
$di['db'] = function () {
    $params = array(
        'configDir' => phpkitRoot . '/config/',
    );
    $config = new \phpkit\config\Config($params);
    $DbConfig = $config->get("database");
    return new \Phalcon\Db\Adapter\Pdo\Mysql($DbConfig);
};

//缓存注入
// $di['cache'] = function () {
//     return new \phpkit\redis\Redis(array(
//         "prefix" => 'project-name-data-cache-',
//         'host' => '127.0.0.1',
//         'port' => 6379,
//         'persistent' => true,
//     ));
// };
$di['cache'] = function () {
    $frontCache = new \Phalcon\Cache\Frontend\Data(array(
        "lifetime" => 0,
    ));
    $cacheDir = phpkitRoot . '/cache/data/';
    \phpkit\helper\mk_dir($cacheDir);
   return new \Phalcon\Cache\Backend\File($frontCache, array(
        "cacheDir" => $cacheDir,
    ));
};


//注入日志服务
$di['logger']=function(){
    $params = require phpkitRoot."/config/log.php";
    $logger = new \phpkit\aliyunLogger\Logger($params);
    return $logger;
};


return $di;