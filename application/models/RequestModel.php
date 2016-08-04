<?php
class Application_Model_RequestModel extends Wavegoing_Model{
	public $id; // bigint(20) NOT NULL AUTO_INCREMENT,
	public $businessType; // tinyint(4) NOT NULL DEFAULT '1',
	public $businessId; // bigint(20) NOT NULL,
	public $userId; // bigint(20) NOT NULL,
	public $submitTime; //
	public $provinceId;
	public function __construct($businessType=null, $businessId=null, $userId=null, $submitTime=null, $provinceId=null) {
		$this->businessType=$businessType;
		$this->businessId=$businessId;
		$this->userId=$userId;
		$this->submitTime=$submitTime;
		$this->provinceId=$provinceId;
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
	public function setId($_id) {
		$this->id=$_id;
	}
	public function setBusinessType($_businessType) {
		$this->businessType=$_businessType;
	}
	public function setBusinessId($_businessId) {
		$this->businessId=$_businessId;
	}
	public function setUserId($_userId) {
		$this->userId=$_userId;
	}
	public function setSubmitTime($_submitTime) {
		$this->submitTime=$_submitTime;
	}
	public function getProvinceId() {
		return $this->provinceId;
	}
	public function setProvinceId($provinceId) {
		$this->provinceId=$provinceId;
	}
}

