<?php
class Application_Model_WhiteBusinessModel extends Wavegoing_Model{
	private $id;
	private $businessId;
	private $businessType;
	private $status;
	public function getId(){
		return $this->id;
	}
	public function getStatus(){
		return $this->status;
	}
	public function setId($id){
		$this->id=$id;
	}
	public function setStatus($status){
		$this->status=$status;
	}
	public function getBusinessId(){
		return $this->businessId;
	}
	public function getBusinessType(){
		return $this->businessType;
	}
	public function setBusinessId($businessId){
		$this->businessId=$businessId;
	}
	public function setBusinessType($businessType){
		$this->businessType=$businessType;
	}
}

