<?php
class SystemStore extends \phpkit\backend\models\SystemStore {
    protected $Created;
	public function initialize() {
		parent::initialize();
	}
    public function getCreated(){
        $this->Created = date("Y-m-d H:i:s",$this->Created);
    }

    public function setCreated($v){
        return time();
    }


}
