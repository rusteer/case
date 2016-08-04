<?php
class Application_Model_WhiteUserModel extends Wavegoing_Model{
	private $imei;
	private $status;
	public function getStatus() {
		return $this->status;
	}
	public function setStatus($status) {
		$this->status=$status;
	}
	public function getImei() {
		return $this->imei;
	}
	public function setImei($imei) {
		$this->imei=$imei;
	}
}

