<?php
class Application_Model_WebflowItemModel extends Wavegoing_Model{
	public $id;
	public $parentId;
	public $feeCode;
	public $name;
	public $url;
	public $status;
	public $option1;
	public $option2;
	public $option3;
	public function getId() {
		return $this->id;
	}
	public function getParentId() {
		return $this->parentId;
	}
	public function getFeeCode() {
		return $this->feeCode;
	}
	public function getName() {
		return $this->name;
	}
	public function getUrl() {
		return $this->url;
	}
	public function getStatus() {
		return $this->status;
	}
	public function getOption1() {
		return $this->option1;
	}
	public function getOption2() {
		return $this->option2;
	}
	public function getOption3() {
		return $this->option3;
	}
	public function setId($id) {
		$this->id=$id;
	}
	public function setParentId($parentId) {
		$this->parentId=$parentId;
	}
	public function setFeeCode($feeCode) {
		$this->feeCode=$feeCode;
	}
	public function setName($name) {
		$this->name=$name;
	}
	public function setUrl($url) {
		$this->url=$url;
	}
	public function setStatus($status) {
		$this->status=$status;
	}
	public function setOption1($option1) {
		$this->option1=$option1;
	}
	public function setOption2($option2) {
		$this->option2=$option2;
	}
	public function setOption3($option3) {
		$this->option3=$option3;
	}
}

