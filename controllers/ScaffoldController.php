<?php

class ScaffoldController extends AdminController {
	public function initialize() {
		parent::initialize();
	}

	public function indexAction() {
		
		$this->adminDisplay();
		
	}

	function makeAction(){
		$db = $this->getDi()->getDb();
		$sql = "show tables";
		$data = $db->fetchAll($sql);
		$this->adminDisplay();
	}

	public function makeAllModelAction(){
		
		$this->adminDisplay();
	
	}

	function doMakeAllModelAction(){
		
		$databaseConfig = $this->getDi()->getConfig()->get('database');
		$prefix=$databaseConfig['prefix']?$databaseConfig['prefix']:"";
		$data = (array) $this->request->getPost();
		$db = $this->getDi()->getDb();
		$sql = "show tables";
		$tables = $db->fetchAll($sql);
		foreach ($tables as $key => $value) {
			 $res[]= current($value) ;
		}
		$scaffold =new \phpkit\backend\Scaffold();
		foreach ($res as $key => $table) {

			if(strpos($table, $prefix)===0){
				$modelName=substr_replace($table,'',0,strlen($prefix));
			}else{
				$modelName= $table;
			}
			
			$config = array(
 				'table'=>\phpkit\helper\convertUnderline($modelName),
 				'modelsDir'=>rtrim($data['path'],"/")."/",
 				'model'=>$data['extendsModel'],
 				'overwrite'=>$data['overwrite'],
 				'namespace'=>$data['namespace'],
 				'tableName'=>$table,
			);
			$scaffold->makeModel($config);
		}
		
	}

	public function runAction() {
		$databaseConfig = $this->getDi()->getConfig()->get('database');
		$prefix=$databaseConfig['prefix']?$databaseConfig['prefix']:"";
		$cache = $this->getDi()->getCache();
		//$config = new \phpkit\config\Config();
		$data = (array) $this->request->getPost();
		$table=$data['table'];
		if(strpos($table, $prefix)===0){
			$data['modelName']=substr_replace($table,'',0,strlen($prefix));
		}else{
			$data['modelName']= $table;
		}
		$name = $data['table'] . "_scaffold";
		$tableConfig = $cache->get($name);
		if (is_array($tableConfig)) {
			$data = array_merge($tableConfig, $data);
		}
		$cache->save($name, $data);
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
		//$config = new \phpkit\config\Config();
		$config = $this->getDi()->getCache();
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