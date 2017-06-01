<?php

class ScaffoldController extends \phpkit\core\BaseController {
	public function initialize() {
		parent::initialize();
	}

	public function indexAction() {
		$db = $this->getDi()->getDb();
		$sql = "show tables";
		$data = $db->fetchAll($sql);
		// $sql = "select * from INFORMATION_SCHEMA.Columns where table_name='addon_auth' and table_schema='phpkit' ";
		// $columns = $db->fetchAll($sql);
		// var_dump($columns);
		$this->adminDisplay();
	}

	public function runAction() {
		$config = new \phpkit\config\Config();
		$data = (array) $this->request->getPost();
		$name = $data['table'] . "_scaffold";
		$tableConfig = $config->get($name);
		if (is_array($tableConfig)) {
			$data = array_merge($tableConfig, $data);
		}
		$config->save($name, $data);
		$this->view->data = $data;
		$db = $this->getDi()->getDb();
		$dbname = $db->getDescriptor()['dbname'];
		$sql = "select COLUMN_NAME,COLUMN_COMMENT,IS_NULLABLE,COLUMN_KEY from INFORMATION_SCHEMA.Columns where table_name='" . $data['table'] . "' and table_schema='" . $dbname . "' ";
		$columns = $db->fetchAll($sql);
		if (empty($columns)) {
			$this->jump($dbname . "." . $data['table'] . "没有查到任何字段");
		}
		//var_dump($columns);
		if (empty($tableConfig['columnsList'])) {
			$columnsList = array();
			//var_dump($columns);
			foreach ($columns as $key => $value) {
				$columnsList[$key + 1] = array(
					'name' => $value['COLUMN_NAME'],
					'text' => $value['COLUMN_COMMENT'],
					'display' => 1,
					'required' => $value['IS_NULLABLE'] == 'NO' ? 1 : 0,
				);
				if ($value['COLUMN_KEY'] == 'PRI') {
					$this->view->modelPk = $value['COLUMN_NAME'];
				}
			}
		} else {
			$this->view->modelPk = $tableConfig['modelPk'];
			$columnsList = $tableConfig['columnsList'];
		}

		$this->view->columns = \phpkit\helper\arrayeval($columnsList);
		$this->adminDisplay();
	}

	public function run2Action() {
		$config = new \phpkit\config\Config();
		$post = $this->request->getPost();
		$name = $post['table'] . "_scaffold";
		$data = $config->get($name);
		$value_str = str_replace("Array", "array", stripslashes(htmlspecialchars_decode(trim($_POST['columns']))));
		if (strpos($value_str, "array") !== 0) {
			$value_str = "'" . $value_str . "'";
		}
		eval("\$columnsList = " . $value_str . "; ");
		$i = 1;
		foreach ($columnsList as $key => $value) {
			$columnsList[$i] = $value;
			$i++;
		}
		$data['columnsList'] = $columnsList;
		$data['modelPk'] = $post['modelPk'];
		$config->save($name, $data);
		$scaffold = new \phpkit\backend\Scaffold();
		$config = array();
		$scaffold->run($data);
	}

}