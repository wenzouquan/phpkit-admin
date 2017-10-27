<?php

use Phalcon\Mvc\Controller;

class IndexController extends AdminController {

	 public function IndexAction() {
		 echo '欢迎使用phpkit-admin,<a href="/system-admin-menu/index?activemenu=system-admin-menu">进入管理</a>';
	}


}
