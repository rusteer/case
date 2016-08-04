<?php
class Application_Dao_WebflowItemDAO extends Wavegoing_TableDAO{
	protected $_name='webflow_item';
	const cacheAllEnabled='webflow_item_all_enabled';
	const cacheAllEnabledWithUrl='webflow_item_all_enabled_url_not_null';
	/**
	 *
	 * @param int $parentId        	
	 * @return multitype: Application_Model_WebflowItemModel
	 */
	public function getItems($parentId) {
		$select=$this->select()->where("parent_id=?",$parentId)->where("status=?",'Y');
		$select->order("id");
		return $this->getCachedEntityList('webflow_item_enabled_list_parent_'. $parentId,parent::cacheSeconds,$select);
	}
	public function getEnabledList() {
		return $this->getCachedEntityList(self::cacheAllEnabled,parent::cacheSeconds,$this->select()->where("status=?",'Y'));
	}
	public function getTryItems() {
		return $this->getCachedEntityList(self::cacheAllEnabledWithUrl,parent::cacheSeconds,$this->select()->where("status=?",'Y')->where('url is not null'));
	}
	
	/**
	 *
	 * @see Wavegoing_TableDAO::composeEntity()
	 * @return Application_Model_WebflowItemModel
	 */
	public function composeEntity($row) {
		$result=new Application_Model_WebflowItemModel();
		$result->setId(intval($row->id));
		$result->setName($row->name);
		$result->setFeeCode($row->fee_code);
		$result->setStatus($row->status);
		$result->setParentId(intval($row->parent_id));
		$result->setUrl($row->url);
		$result->setOption1($row->option1);
		$result->setOption2($row->option2);
		$result->setOption3($row->option3);
		return $result;
	}
}

