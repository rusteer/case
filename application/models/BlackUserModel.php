<?php
class Application_Model_BlackUserModel extends Wavegoing_Model{
	protected $_mobile;
	public function getMobile() {
		return $this->_mobile;
	}
	public function setMobile($_mobile) {
		$this->_mobile=$_mobile;
	}
}

