<?php
class Application_Dao_WebflowDemoDAO extends Wavegoing_TableDAO{
	protected $_name='webflow_demo';
	
	/**
	 *
	 * @return Application_Model_WebflowDemoModel null
	 */
	public function getOne() {
		return $this->getEntity($this->select()->where("status=?","Y"));
	}
	
	/**
	 *
	 * @param Application_Model_WebflowDemoModel $entity        	
	 */
	public function saveOne($entity) {
		if($entity->getId())
			$this->updateEntity($entity);
		else
			$this->createEntity($entity);
	}
	
	/**
	 *
	 * @see Wavegoing_TableDAO::composeRow()
	 * @param Application_Model_WebflowDemoModel $entity        	
	 *
	 */
	public function composeRow(Application_Model_WebflowDemoModel $entity) {
		$result=array(
				"id"=>$entity->id,
				"content"=>$entity->content,
				"status"=>$entity->status
		);
		return $result;
	}
	
	/**
	 *
	 * @see Wavegoing_TableDAO::composeEntity()
	 * @return Application_Model_WebflowItemModel
	 */
	public function composeEntity($row) {
		$result=new Application_Model_WebflowDemoModel();
		$result->setId(intval($row->id));
		$result->setContent($row->content);
		$result->setStatus($row->status);
		return $result;
	}
}

