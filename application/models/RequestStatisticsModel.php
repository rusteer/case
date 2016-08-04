<?php
class Application_Model_RequestStatisticsModel extends Wavegoing_Model{
	protected $_id; // bigint(20) NOT NULL AUTO_INCREMENT,
	protected $_businessType; // tinyint(4) NOT NULL DEFAULT '1',
	protected $_businessId; // bigint(20) NOT NULL,
	protected $_userId; // bigint(20) NOT NULL,
	protected $_statTime; // varchar(20) NOT NULL,
	protected $_statCount; // int(11) DEFAULT '0',
	protected $_updateTime; // timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	public function __construct($businessType=null, $businessId=null, $userId=null, $statTime=null, $statCount=null, $updateTime=null) {
		$this->_businessType=$businessType;
		$this->_businessId=$businessId;
		$this->_userId=$userId;
		$this->_statTime=$statTime;
		$this->_statCount=$statCount;
		$this->_updateTime=$updateTime;
	}
	public function getId() {
		return $this->_id;
	}
	public function getBusinessType() {
		return $this->_businessType;
	}
	public function getBusinessId() {
		return $this->_businessId;
	}
	public function getUserId() {
		return $this->_userId;
	}
	public function getStatTime() {
		return $this->_statTime;
	}
	public function getStatCount() {
		return $this->_statCount;
	}
	public function getUpdateTime() {
		return $this->_updateTime;
	}
	public function setId($_id) {
		$this->_id=$_id;
	}
	public function setBusinessType($_businessType) {
		$this->_businessType=$_businessType;
	}
	public function setBusinessId($_businessId) {
		$this->_businessId=$_businessId;
	}
	public function setUserId($_userId) {
		$this->_userId=$_userId;
	}
	public function setStatTime($_statTime) {
		$this->_statTime=$_statTime;
	}
	public function setStatCount($_statCount) {
		$this->_statCount=$_statCount;
	}
	public function setUpdateTime($_updateTime) {
		$this->_updateTime=$_updateTime;
	}
}

