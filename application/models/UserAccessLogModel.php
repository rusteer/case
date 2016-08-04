<?php
class Application_Model_UserAccessLogModel extends Wavegoing_Model{
	protected $id;  
	protected $userId;  
	protected $submitTime;  
	protected $balance;
	public function getId() {
		return $this->id;
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
	public function setUserId($userId) {
		$this->userId=$userId;
	}
	public function setSubmitTime($submitTime) {
		$this->submitTime=$submitTime;
	}
	public function getBalance() {
		return $this->balance;
	}

	public function setBalance($balance) {
		$this->balance = $balance;
	}

}

