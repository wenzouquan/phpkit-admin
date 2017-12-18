<?php

use Phalcon\Mvc\Controller;

class IndexController extends AdminController {

	 public function IndexAction() {
	 	// var_dump($this->adminSetting['adminUrl']);
		 //echo '欢迎！！,<a href="'.$this->adminSetting['adminUrl'].'/system-admin-menu/index?activemenu=system-admin-menu">进入管理</a>';
	 	$this->jump("",$this->adminSetting['adminUrl']['default'].'/system-admin-menu/index?activemenu=system-admin-menu');
	}


}
