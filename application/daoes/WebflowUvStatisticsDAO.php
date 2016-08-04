<?php
class Application_Dao_WebflowUvStatisticsDAO extends Wavegoing_TableDAO{
	protected $_name='webflow_uv_statistics';
	
	/**
	 *
	 * @param integer $businessId        	
	 * @param string $statTime        	
	 * @return Application_Model_WebflowUvStatisticsModel
	 */
	public function getMockStatistics($businessId, $statTime) {
		return $this->getEntity($this->select()->where('business_id=?',$businessId)->where("stat_time=?",$statTime));
	}
	
	/**
	 *
	 * @param integer $businessId        	
	 * @param string $statTime        	
	 */
	public function getMockCount($businessId, $statTime) {
		$entity=$this->getMockStatistics($businessId,$statTime);
		if($entity== null)
			return 0;
		return $entity->setStatCount();
	}
	public function addMockCount($businessId, $statTime) {
		$entity=$this->getMockStatistics($businessId,$statTime);
		if($entity== null){
			$entity=new Application_Model_WebflowUvStatisticsModel();
			$entity->setBusinessId($businessId);
			$entity->setStatCount(1);
			$entity->setStatTime(date('Ymd'));
			$this->createEntity($entity);
			$entity->setUpdateTime(date('Y-m-d H:i:s'));
		}else{
			$entity->setStatCount($entity->getStatCount()+ 1);
			$entity->setUpdateTime(date('Y-m-d H:i:s'));
			$this->updateEntity($entity);
		}
	}
	
	/**
	 *
	 * @param Application_Model_WebflowUvStatisticsModel $entity        	
	 * @see Wavegoing_TableDAO::composeRow()
	 */
	public function composeRow($entity) {
		return array(
				'id'=>$entity->getId(),
				'business_id'=>$entity->getBusinessId(),
				'stat_time'=>$entity->getStatTime(),
				'stat_count'=>$entity->getStatCount(),
				'update_time'=>$entity->getUpdateTime()
		);
	}
	
	/**
	 *
	 * @see Wavegoing_TableDAO::composeEntity()
	 * @return Application_Model_WebflowUvStatisticsModel
	 */
	public function composeEntity($row) {
		$result=new Application_Model_WebflowUvStatisticsModel();
		$result->setId(intval($row->id));
		$result->setBusinessId($row->business_id);
		$result->setStatTime($row->stat_time);
		$result->setStatCount($row->stat_count);
		$result->setUpdateTime($row->update_time);
		return $result;
	}
}

