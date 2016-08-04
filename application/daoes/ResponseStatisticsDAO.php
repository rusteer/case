<?php
class Application_Dao_ResponseStatisticsDAO extends Wavegoing_TableDAO{
	protected $_name='response_statistics';
	public function composeEntity($row) {
		$entry=new Application_Model_ResponseStatisticsModel();
		$entry->setId($row->id);
		$entry->setBusinessId($row->business_id);
		$entry->setBusinessType($row->business_type);
		$entry->setStatCount($row->stat_count);
		$entry->setStatTime($row->stat_time);
		$entry->setUpdateTime($row->update_time);
		$entry->setUserId($row->user_id);
		return $entry;
	}
	public function getUserResponseStatistics($userId) {
		return $this->getEntityList($this->select()->where('user_id = ?',$userId));
	}
	public function composeRow($entity) {
		return array(
				'id'=>$entity->getId(),
				'business_id'=>$entity->getBusinessId(),
				'business_type'=>$entity->getBusinessType(),
				'stat_count'=>$entity->getStatCount(),
				'stat_time'=>$entity->getStatTime(),
				'update_time'=>$entity->getUpdateTime(),
				'user_id'=>$entity->getUserId()
		);
	}
}

