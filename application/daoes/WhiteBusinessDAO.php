<?php
class Application_Dao_WhiteBusinessDAO extends Wavegoing_TableDAO{
	protected $_name='white_business';
	const cacheKey="white_business_all";
	private function getAll(){
		$select=$this->select()->where("status='Y'");
		return $this->getCachedEntityList(self::cacheKey,parent::cacheSeconds,$select);
	}
	public function composeEntity($row){
		$result=new Application_Model_WhiteBusinessModel();
		$result->setBusinessId($row->business_id);
		$result->setBusinessType($row->business_type);
		$result->setId($row->id);
		$result->setStatus($row->status);
		return $result;
	}
	/**
	 *
	 * @param Application_Model_WhiteBusinessModel $entity        	
	 * @see Wavegoing_TableDAO::composeRow()
	 */
	public function composeRow($entity){
		return array(
				"id"=>$entity->id,
				"business_id"=>$entity->getBusinessId(),
				"business_type"=>$entity->getBusinessType(),
				"status"=>$entity->getStatus()
		);
	}
	public function isWhite($business){
		$list=$this->getAll();
		foreach($list as $entity){
			if($entity->getBusinessType()==$business->getType()&&$entity->getBusinessId()==$business->getId())
				return true;
		}
		return false;
	}
	
	/**
	 *
	 * @param string $type        	
	 * @param integer $id        	
	 */
	public function setWhite($type,$id){
		$this->getAdapter()->query("truncate table white_business");
		$entity=new Application_Model_WhiteBusinessModel();
		$entity->setBusinessId($id);
		$entity->setBusinessType($type);
		$entity->setStatus("Y");
		$this->createEntity($entity);
	}
}

