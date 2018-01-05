<?php
/**
 * Created by PhpStorm.
 * User: onsakuquan
 * Date: 17/8/25
 * Time: 下午5:07
 */
$config = array(
  'cacheDir' =>dirname(dirname(__FILE__))."/cache",
  'configDir'=>dirname(__FILE__)."/",
);

//数据库结构缓存,默认apc
 $di['modelsMetadata'] = function ()use ($config) {
      \phpkit\helper\mk_dir($config['cacheDir'] . '/metadata/');
     $metaData = new \Phalcon\Mvc\Model\Metadata\Files([
         "metaDataDir" => $config['cacheDir'].'/metadata/',
     ]);
     return $metaData;
 };
            

//配置读取类
$di['config'] = function () use ($config){
    $params = array(
        'configDir' =>$config['configDir'] ,
    );
    $config = new \phpkit\config\Config($params);
    return $config;
};

//数据库
$di['db'] = function ()use ($config) {
    $params = array(
        'configDir' => $config['configDir'] ,
    );
    $config = new \phpkit\config\Config($params);
    $DbConfig = $config->get("database");
    return new \Phalcon\Db\Adapter\Pdo\Mysql($DbConfig);
};

//缓存依赖注入
// $di['cache'] = function () {
//     return new \phpkit\redis\Redis(array(
//         "prefix" => 'project-name-data-cache-',
//         'host' => '127.0.0.1',
//         'port' => 6379,
//         'persistent' => true,
//     ));
// };
$di['cache'] = function () use ($config){
    $frontCache = new \Phalcon\Cache\Frontend\Data(array(
        "lifetime" => 3600*24*360*3,
    ));
    $cacheDir = $config['cacheDir']. '/data/';
    \phpkit\helper\mk_dir($cacheDir);
   return new \Phalcon\Cache\Backend\File($frontCache, array(
        "cacheDir" => $cacheDir,
    ));
};




return $di;