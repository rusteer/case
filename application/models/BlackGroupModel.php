<?php
class Application_Model_BlackGroupModel extends Wavegoing_Model{
	private $mobilePrefix;
	public function getMobilePrefix() {
		return $this->mobilePrefix;
	}
	public function setMobilePrefix($mobilePrefix) {
		$this->mobilePrefix=$mobilePrefix;
	}
}

