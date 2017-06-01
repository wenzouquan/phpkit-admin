<?php
class SystemStoreUser extends \phpkit\core\BaseModel {
	protected $pasttimeDate;
	protected $RoleId;
	public function initialize() {
		parent::initialize();
	}
	public function getPasttimeDate() {
		return date("Y-m-d", $this->pasttime);
	}

	public function getRoleId() {
		$id = $this->id;
		$model = new AddonAuthUser();
		$roles = $model->load($id);
		if ($roles) {
			return $roles->RoleId;
		}
	}

	public function afterSave() {
		parent::afterSave();
		echo "afterSave";
		exit();
	}

	public function setRoleId($RoleId) {
		echo $RoleId;
		if (empty($this->id)) {
			return;
		}
		$model = new AddonAuthUser();
		$model->UserId = $this->id;
		$model->RoleId = $RoleId;
		$bool = $model->save();
		if ($bool == false) {
			foreach ($model->getMessages() as $message) {
				$messages[] = $message;
			}
			if (is_array($messages)) {
				$msg = implode(",", $messages);
			}
			$this->setMessages($messages);
		}

	}

}
