<?php
class AdminController extends \phpkit\base\AdminController {
	public $LoginUrl;
	public function initialize() {
		//$this->LoginUrl = '/phpkit-admin/cache/index';
		parent::initialize();
		$this->adminUserInfo = $this->session->get('adminUserInfo');

	}

}