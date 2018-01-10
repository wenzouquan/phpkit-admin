# phpkit-admin
管理后台  , 基于 boostrap , ace , Phalcon ，实现生成CURD ,权限管理 ，等基础功能

# 安装使用

1.安装php扩展：Phalcon ，http://phalcon.ipanta.com

2.在phpkit-admin目录下执行：composer install 安装依赖

3.将db目录下的sql文件导入到数据库

4.在config目录改配置

5.访问后台 ：http://你的域名/phpkit-admin/index.php


# 目录介绍

1.  cache ：文件缓存目录。   config ： 配置文件，di注入  。db ：数据库文件  。 app : Controller 和 model 


# 在其它框架中使用 

可以考参与 demo 目录的 tp5Base.php文件类 （tp5框架中使用phpkitadmin的例子 ）， 后台所有文件都继承它，就可以实现权限验证 ，使用  adminDisplay 方法显示 后台模板   


 