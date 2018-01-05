<?php
class CacheController extends AdminController {

	public function initialize() {
		parent::initialize();
	}

	public function indexAction() {
		$this->session->set("user-name", "Michael");
		$this->adminDisplay();
		//$this->display();
	}

	public function testAction() {
		var_dump($this->session->get("user-name"));
	}

	//清Apc缓存 ， 用于表结构缓存
	public function deleteModelsMetadataAction() {
		$data = \apc_cache_info();

		if (is_array($data['cache_list'])) {
			foreach ($data['cache_list'] as $key => $value) {
				if (strpos($value['key'], 'phpkit-modelsMetadata')) {
					\apc_delete($value['key']);
				}
			}
		}

		$this->jump("操作成功");

	}
	//清数据缓存
	public function deletecachedataAction() {
		$cache = \phpkit\core\Phpkit::cache();
		$name = get_class($cache);
		if ($name == 'Phalcon\Cache\Backend\File') {
			$options = $cache->getOptions();
			if (is_dir($options['cacheDir'])) {
				\phpkit\helper\deldir($options['cacheDir']);
			}
		}
		$this->jump("操作成功");
		//var_dump(get_class($cache));
		//var_dump($cache->getOptions());
	}
}