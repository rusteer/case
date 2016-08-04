<?php
class Application_Dao_RequestStatisticsDAO extends Wavegoing_TableDAO{
	protected $_name='request_statistics';
	public function getName() {
		return $this->_name;
	}
	
	/**
	 *
	 * @param Application_Model_RequestStatisticsModel $stat        	
	 */
	private function updateStatistics($stat) {
		$cacheKey=$this->_name. "_user_". $stat->getUserId(). "_". $stat->getBusinessType(). "_". $stat->getBusinessId(). "_". $stat->getStatTime();
		$this->updateAndCacheEntity($cacheKey,3600* 24,$stat);
	}
	
	/**
	 *
	 * @param Application_Model_RequestStatisticsModel $stat        	
	 */
	public function increaseStatistics($stat) {
		$stat->setStatCount($stat->getStatCount()+ 1);
		$stat->setUpdateTime(date('Y-m-d H:i:s'));
		$this->updateStatistics($stat);
	}
	
	/**
	 *
	 * @param int $userId        	
	 * @param Application_Model_BusinessModel $entity        	
	 * @param string $statTime        	
	 * @return Application_Model_RequestStatisticsModel null
	 */
	private function getStatistics($userId, $entity, $statTime) {
		$cacheKey=$this->_name. "_user_". $userId. "_". $entity->getType(). "_". $entity->getId(). "_". $statTime;
		$select=$this->select();
		$select->where("business_type=?",$entity->getType());
		$select->where("business_id=?",$entity->getId());
		$select->where('user_id = ?',$userId);
		$select->where("stat_time=?",$statTime);
		return $this->getCachedEntity($cacheKey,3600* 24,$select);
	}
	
	/**
	 *
	 * @param Application_Model_UserModel $user        	
	 * @param Application_Model_BusinessModel $entity        	
	 * @param string $statTime        	
	 * @return Application_Model_RequestStatisticsModel null
	 */
	public function getUserStatistics($user, $entity, $statTime) {
		return $this->getStatistics($user->getId(),$entity,$statTime);
	}
	
	/**
	 *
	 * @param Application_Model_BusinessModel $entity        	
	 * @param string $statTime        	
	 * @return Application_Model_RequestStatisticsModel null
	 */
	public function getBusinessStatistics($entity, $statTime) {
		return $this->getStatistics(0,$entity,$statTime);
	}
	public function composeEntity($row) {
		$entry=new Application_Model_RequestStatisticsModel();
		$entry->setId($row->id);
		$entry->setBusinessId($row->business_id);
		$entry->setBusinessType($row->business_type);
		$entry->setStatCount($row->stat_count);
		$entry->setStatTime($row->stat_time);
		$entry->setUpdateTime($row->update_time);
		$entry->setUserId($row->user_id);
		return $entry;
	}
	public function composeRow(Application_Model_RequestStatisticsModel $entity) {
		$row=array(
				'id'=>$entity->getId(),
				'business_id'=>$entity->getBusinessId(),
				'business_type'=>$entity->getBusinessType(),
				'stat_count'=>$entity->getStatCount(),
				'stat_time'=>$entity->getStatTime(),
				'update_time'=>$entity->getUpdateTime(),
				'user_id'=>$entity->getUserId()
		);
		if( ! $entity->getUpdateTime())
			$row->update_time=date('Y-m-d H:i:s');
		return $row;
	}
}

