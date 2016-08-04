<?php
class Application_Model_ResponseModel extends Wavegoing_Model{
	public $id; // bigint(20) NOT NULL AUTO_INCREMENT,
	public $businessType; // tinyint(4) NOT NULL DEFAULT '1',
	public $businessId; // bigint(20) NOT NULL,
	public $userId; // bigint(20) NOT NULL,
	public $submitTime; // timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE
	                    // CURRENT_TIMESTAMP,
	public $provinceId;
	public $childId;
	public function __construct($businessType=null, $businessId=null, $userId=null, $submitTime=null, $provinceId=null, $childId=null) {
		$this->businessType=$businessType;
		$this->businessId=$businessId;
		$this->userId=$userId;
		$this->submitTime=$submitTime;
		$this->provinceId=$provinceId;
		$this->childId=$childId;
	}
	public function getChildId() {
		return $this->childId;
	}
	public function setChildId($childId) {
		$this->childId=$childId;
	}
	public function getId() {
		return $this->id;
	}
	public function getBusinessType() {
		return $this->businessType;
	}
	public function getBusinessId() {
		return $this->businessId;
	}
	public function getUserId() {
		return $this->userId;
	}
	public function getSubmitTime() {
		return $this->submitTime;
	}
	public function setId($id) {
		$this->id=$id;
	}
	public function setBusinessType($businessType) {
		$this->businessType=$businessType;
	}
	public function setBusinessId($businessDd) {
		$this->businessId=$businessDd;
	}
	public function setUserId($userId) {
		$this->userId=$userId;
	}
	public function setSubmitTime($submitTime) {
		$this->submitTime=$submitTime;
	}
	public function getProvinceId() {
		return $this->provinceId;
	}
	public function setProvinceId($provinceId) {
		$this->provinceId=$provinceId;
	}
}

