<?php
class Application_Model_AreaModel extends Wavegoing_Model{
	public $id;
	public $name;
	public $provinceId;
	public $areaCode;
	public function getId() {
		return $this->id;
	}
	public function getName() {
		return $this->name;
	}
	public function getProvinceId() {
		return $this->provinceId;
	}
	public function getAreaCode() {
		return $this->areaCode;
	}
	public function setId($id) {
		$this->id=$id;
	}
	public function setName($name) {
		$this->name=$name;
	}
	public function setProvinceId($provinceId) {
		$this->provinceId=$provinceId;
	}
	public function setAreaCode($areaCode) {
		$this->areaCode=$areaCode;
	}
}