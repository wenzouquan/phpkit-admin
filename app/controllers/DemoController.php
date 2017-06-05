<?php

use Phalcon\Mvc\Controller;

class DemoController extends Controller {

	public function weiXinApiAction() {
		$a = new phpkit\weixinapi\WeiXinApi();
		print_r($a);
	}

	public function payAction() {
		//微信支付
		$paytype = 'Wxpay';
		$configData = array(
			'MCHID' => '10036811',
			'KEY' => 'yu13324P23d8kao999SHItu13ji323mi',
			'APPID' => 'wxd8e7a93dd0cb2c14',
			'APPSECRET' => '1289c71b3768d7addb537da5dbaa3fae',
		);
		//支付宝支付

		$pay = new phpkit\pay\Pay();
		//支付成功之后回调
		if ($OrderNo = $pay->getOrderNo()) {
			//通过订单号查出支付方式，这里我测试写死的
			// $paytype = 'Alipay';
			// $configData = array(
			// 	'email' => '359945126@qq.com',
			// 	'key' => 'evhvkbu2isspktoc7j5hhopz4f8pjuvl',
			// 	'partner' => '2088012957518851',
			// );
			$pay->config($paytype, $configData)->success(function ($info) {
				var_dump($info);
				//成功之后处理业务
			})->fail(function ($info) {
				var_dump($info);
			});
		} else {
			//去支付
			// $paytype = 'Alipay';
			// $configData = array(
			// 	'email' => '359945126@qq.com',
			// 	'key' => 'evhvkbu2isspktoc7j5hhopz4f8pjuvl',
			// 	'partner' => '2088012957518851',
			// );
			$pay->config($paytype, $configData)->setParams(array(
				'body' => '商品描述',
				'title' => '商品名称',
				'fee' => 1000, //交易金额
				'orderNo' => $pay->createOrderNo(), //订单号
				'return_url' => 'http://www.phpkit.com/tutorial/Demo/pay', //逻辑处理成功之后跳转url
				'fail_url' => 'http://www.phpkit.com/tutorial/Demo/pay', //支付失败url
				'notify_url' => 'http://www.phpkit.com/tutorial/Demo/pay', //支付成功异步通知
			))->run();
		}

		exit();

	}
//第三方登录
	public function syncloginAction() {
		//加载ThinkOauth类并实例化一个对象
		$type = "Qq";
		$config = array(
			'QqKEY' => '216649',
			'QqSecret' => '99cd955863f3f57a00213ac94a297b65',
			'SinaKEY' => '1731004350',
			'SinaSecret' => '7bc7a6fb28cac28c9e8061d8ab74124f',
			'WeixinKEY' => 'wxbefa0813d5031188',
			'WeixinSecret' => '3b05fb78ad754be163107d5ac6df8bbc',
			'callbackUrl' => "http://www.phpkit.com/tutorial/Demo/synclogin?type=Qq&backUrl=" . urlencode($_GET['backUrl']),
		);
		$sns = phpkit\synclogin\ThinkOauth::getInstance($type)->config($config)->suceess(function ($OauthMsg) {
			//成功之后执行的业务
			var_dump($OauthMsg);
		})->run();
		$data = $sns->getOauthMsg();
		var_dump($data);
	}

	//权限验证
	public function authAction() {
		$auth = new phpkit\auth\Auth();
		$UserId = 118;
		$AuthCode = 'BoxAdmin/Auth/access';
		$hasAuth = $auth->check($UserId, $AuthCode);
		var_dump($hasAuth);
	}
	//通用后台 , 基于 boostrap , ace , Phalcon
	public function backendAction() {
		$params = array(
			'menus' => array(), //菜单
			'active' => '', //当前菜单
		);
		$content = '<h1>你好, 温 ！ </h1>';
		$backendView = new phpkit\backend\View($params);
		$backendView->display($content);
	}

	//通用后台 , 基于 boostrap , ace , Phalcon
	public function dictAction() {
		$params = array(
			'menus' => array(), //菜单
			'active' => '', //当前菜单
		);
		$dict = new \phpkit\dict\Dict();
		//$data = $dict->get("apps");
		//$data = $dict->set("test", $params);
		$data = $dict->delete('test');
		var_dump($data);
	}

	public function registerAction() {

		$user = new Users();

		// Store and check for errors
		$success = $user->save(
			$this->request->getPost(),
			array('name', 'email')
		);

		if ($success) {
			echo "Thanks for registering!";
		} else {
			echo "Sorry, the following problems were generated: ";
			foreach ($user->getMessages() as $message) {
				echo $message->getMessage(), "<br/>";
			}
		}

		$this->view->disable();
	}

}
