<?php
/*
 * @thinkphp5.0  后台auth认证   php5.3以上
 * @Author     359945126@qq.com
 */
namespace app\admin\controller;

use think\Controller;
use think\Model;
use phpkit\core\Phpkit as Phpkit;
use phpkit\backend\View as backendView;
//权限认证
class Base extends Controller {

	 public function adminDisplay($name="") {
	 	$content= $this->fetch($name);
 		$backendView = new backendView(['phpkitApp'=>$this->phpkitApp]);
   		return $backendView->display($content);
    }


	protected function _initialize(){
		//
		parent::_initialize();
		$request = request();
	    //使用phpkit
	    $this->phpkitApp = $this->getphpkitApp();
	    
	    //后台用户信息
	    $this->adminUserInfo = $this->phpkitApp->getDi()->getSession()->get('adminUserInfo');
	     
	    if(empty($this->adminUserInfo)){
	    	$this->error('还没有登录，正在跳转到登录页','/phpkit-admin/index/login');
	    }
	    //权限验证
	    $this->checkAuth();
	    //$this->activemenu = 'system-admin-menu';

	}

	//验证权限
    protected function checkAuth() {
    	$request = request();
    	$authCode= implode("/",array($request->module(),strtolower($request->controller()),strtolower($request->action())));
    	// $_GET['activemenu']='system-admin-menu';
    	if(isset($_GET['activemenu'])){
    		 $activemenu = $_GET['activemenu'];
    	}else{
    		$activemenu =$authCode;
    	}
    	$this->setNavActive($activemenu);
    	//最高管理员处理逻辑
    	if($this->adminUserInfo['type']=="super"){

    	}else{	
    		$auth = \phpkit\auth\auth();
    		if(!$auth->check($this->adminUserInfo['id'],$authCode)){
    			 $this->error('没有权限访问 '.$auth->AuthCheckMsg['msg']);
    		}
    	}
	}

   //设置选中的菜单 
	protected function setNavActive($activemenu){
		$_GET['activemenu'] = $activemenu;
	}


	//使用phpkit
	protected  function  getphpkitApp(){
		define("phpkitRoot", dirname(dirname(dirname(dirname(__FILE__))))."/public/phpkit-admin/");//
		$phpkit = new Phpkit();
		$setting = require phpkitRoot. '/config/setting.php';
		//初始化phpkit
		$app = $phpkit->init($setting);
		return $app;
	}

	
}
