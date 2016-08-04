<?php
class Application_Model_BlackRuleModel extends Wavegoing_Model{
	/**
	 *
	 * @var int
	 */
	private $id;
	/**
	 *
	 * @var string
	 */
	private $businessType;
	/**
	 *
	 * @var int
	 */
	private $businessId;
	/**
	 *
	 * @var string
	 */
	private $rule;
	/**
	 *
	 * @var string
	 */
	private $status;
	/**
	 *
	 * @return the $id
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 *
	 * @return the $businessType
	 */
	public function getBusinessType() {
		return $this->businessType;
	}
	
	/**
	 *
	 * @return the $businessId
	 */
	public function getBusinessId() {
		return $this->businessId;
	}
	
	/**
	 *
	 * @return the $rule
	 */
	public function getRule() {
		return $this->rule;
	}
	
	/**
	 *
	 * @return the $status
	 */
	public function getStatus() {
		return $this->status;
	}
	
	/**
	 *
	 * @param int $id        	
	 */
	public function setId($id) {
		$this->id=$id;
	}
	
	/**
	 *
	 * @param string $businessType        	
	 */
	public function setBusinessType($businessType) {
		$this->businessType=$businessType;
	}
	
	/**
	 *
	 * @param int $businessId        	
	 */
	public function setBusinessId($businessId) {
		$this->businessId=$businessId;
	}
	
	/**
	 *
	 * @param string $rule        	
	 */
	public function setRule($rule) {
		$this->rule=$rule;
	}
	
	/**
	 *
	 * @param string $status        	
	 */
	public function setStatus($status) {
		$this->status=$status;
	}
}

