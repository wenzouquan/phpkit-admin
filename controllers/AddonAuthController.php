<?php

class AddonAuthController extends AdminController {

	public function initialize() {
		parent::initialize();
		$this->model = new AddonAuth();
		$this->view->modelPk = $this->model->getPk();
	}

	public function indexAction() {
		$this->adminDisplay();

	}

	//列表查询
	public function searchAction() {
		$pagesize = $this->request->getQuery('length', null, "10"); //条数
		$offset = $this->request->getQuery('start', null, "0"); //起始条数
		$conditions = "";
		$orderBy = ""; //排序方式
		$order = $this->request->getQuery('order'); //排序字段
		$columns = $this->request->getQuery('columns'); //所有字段
		// var_dump($columns);
		// var_dump($order);
		if (is_array($order)) {
			foreach ($order as $key => $value) {
				$orderColumn = $columns[$value['column']]['data'];
				if ($orderColumn) {
					$orderBy .= $orderColumn . " " . $value['dir'] . ",";
				}
			}
			$orderBy = trim($orderBy, ",");

		} else {
			$orderBy = $this->view->modelPk . " desc"; //排序方式
		}
		//var_dump($this->request->getQuery());
		//关键字查询
		$search = $this->request->getQuery('search');
		$kw = trim($search['value']);
		if ($kw) {
			$conditions .= " Title like '%$kw%'";
		}

		$res = $this->model->order($orderBy)->where($conditions)->limit("$pagesize,$offset")->select();
		$recordsFiltered = $res['recordsFiltered'];
		$recordsTotal = $res['recordsTotal'];
		$data = $res["list"];
		//exit();
		foreach ($data as $list) {
			$values = $list->toArray();
			$values['GroupName'] = $list->GroupName;
			$lists[] = $values;
		}
		$data = array(
			'recordsTotal' => $recordsTotal,
			'draw' => intval($_GET['draw']),
			'recordsFiltered' => $recordsFiltered,
			'data' => (array) $lists,
		);
		echo json_encode($data);
	}

	public function addAction() {
		$Id = $this->request->get("Id");
		if (!empty($Id)) {
			$model = $this->view->data = $this->model->load($Id);
		}
		$this->view->GroupList = $this->model->GroupList;
		if ($this->request->isPost()) {
			if (empty($model)) {
				$model = $this->model;
			}
			if ($model->save($this->request->getPost()) == false) {
				$msg = '保存失败';
				foreach ($model->getMessages() as $message) {
					$messages[] = $message;
				}
				if (is_array($messages)) {
					$msg = implode(",", $messages);
				}
				$this->jump($msg);

			} else {
				$this->jump("保存成功", $this->url->get($this->dispatcher->getControllerName() . '/add') . "?" . $this->view->modelPk . "=" . $Id);
			}
		}
		$this->adminDisplay();

	}

	public function deleteAction() {
		$ids = (array) $this->request->getQuery("ids");
		foreach ($ids as $key => $id) {
			$r = $this->model->remove($id);
		}
		if ($r) {
			echo json_encode(array('error' => 0, 'msg' => '删除成功'));
		} else {
			echo json_encode(array('error' => 1, 'msg' => is_array($this->model->error) ? implode(",", $this->model->error) : ''));
		}
		exit();
	}
}
