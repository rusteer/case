<?php
class Application_Model_ProvinceModel extends Wavegoing_Model{
	public $id;
	public $name;
	public $areaList;
	
	public function __construct($id=null,$name=null) {
		$this->id=$id;
		$this->name=$name;
	}
	public function getAreaList() {
		return $this->areaList;
	}
	public function setAreaList($areaList) {
		$this->areaList=$areaList;
	}
	public function getId() {
		return $this->id;
	}
	public function getName() {
		return $this->name;
	}
	public function setId($id) {
		$this->id=$id;
	}
	public function setName($name) {
		$this->name=$name;
	}
}