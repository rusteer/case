<?php
class Application_Dao_RequestDAO extends Wavegoing_TableDAO{
	protected $_name='request';
	public function getName() {
		return $this->_name;
	}
	public function composeEntity($row) {
		$entry=new Application_Model_RequestModel();
		$entry->setId($row->id);
		$entry->setBusinessId($row->business_id);
		$entry->setBusinessType($row->business_type);
		$entry->setSubmitTime($row->submit_time);
		$entry->setUserId($row->user_id);
		$entry->setProvinceId($row->province_id);
		return $entry;
	}
	public function composeRow(Application_Model_RequestModel $entity) {
		return array(
				'id'=>$entity->getId(),
				'province_id'=>$entity->getProvinceId(),
				'business_id'=>$entity->getBusinessId(),
				'business_type'=>$entity->getBusinessType(),
				'submit_time'=>$entity->getSubmitTime(),
				'user_id'=>$entity->getUserId()
		);
	}
	public function getRequestCount($type, $from, $to, $provinceId) {
		$select=$this->select();
		$select->from($this,array(
				'COUNT(1) as business_count',
				'business_id'
		));
		if($provinceId!= 0){
			$select->where("province_id=?",$provinceId);
		}
		$select->where('business_type = ?',$type);
		if($from)
			$select->where('submit_time >=?',$from);
		if($to)
			$select->where('submit_time <=?',$to);
		$select->group('business_id');
		$rows=$this->fetchAll($select);
		$result=array();
		foreach($rows as $row){
			$result[$row->business_id]=$row->business_count;
		}
		return $result;
	}
}

