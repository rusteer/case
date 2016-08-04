<?php
class Application_Dao_BlackRuleDAO extends Wavegoing_TableDAO{
	protected $_name='black_rule';
	
	/**
	 *
	 * @see Wavegoing_TableDAO::composeEntity()
	 * @return Application_Model_BlackRuleModel
	 */
	public function composeEntity($row) {
		$result=new Application_Model_BlackRuleModel();
		$result->setId($row->id);
		$result->setBusinessType($row->business_type);
		$result->setBusinessId($row->business_id);
		$result->setRule($row->rule);
		$result->setStatus($row->status);
		return $result;
	}
	
	/**
	 * Get applied rules
	 *
	 * @return multitype:Application_Model_BlackRuleModel
	 */
	public function getApplyRules() {
		$cacheKey=$this->_name. "_apply_list";
		return $this->getCachedEntityList($cacheKey,parent::cacheSeconds,$this->select()->where("rule=?",'apply'));
	}
	
	/**
	 * Get exception rules
	 *
	 * @return multitype:Application_Model_BlackRuleModel
	 */
	public function getExceptionRules() {
		$cacheKey=$this->_name. "_exception_list";
		return $this->getCachedEntityList($cacheKey,parent::cacheSeconds,$this->select()->where("rule=?",'exception'));
	}
}

