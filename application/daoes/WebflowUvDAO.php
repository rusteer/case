<?php
class Application_Dao_WebflowUvDAO extends Wavegoing_TableDAO{
    protected $_name='webflow_uv';
    
    /**
	 *
	 * @param integer $businessId        	
	 * @param string $statTime        	
	 * @return Application_Model_WebflowUvModel
	 */
    public function getMock($businessId,$userId,$statTime){
        $select=$this->select()->where('business_id=?',$businessId)->where('user_id=?',$userId)->where("stat_time=?",$statTime);
        return $this->getEntity($select);
    }
    
    /**
	 *
	 * @param Application_Model_WebflowUvModel $entity        	
	 * @see Wavegoing_TableDAO::composeRow()
	 */
    public function composeRow($entity){
        return array(
                'id'=>$entity->getId(),
                'business_id'=>$entity->getBusinessId(),
                'user_id'=>$entity->getUserId(),
                'stat_time'=>$entity->getStatTime(),
                'create_time'=>$entity->getCreateTime());
    }
    
    /**
	 *
	 * @see Wavegoing_TableDAO::composeEntity()
	 * @return Application_Model_WebflowUvModel
	 */
    public function composeEntity($row){
        $result=new Application_Model_WebflowUvModel();
        $result->setId(intval($row->id));
        $result->setBusinessId($row->business_id);
        $result->setUserId($row->user_id);
        $result->setStatTime($row->stat_time);
        $result->setCreateTime($row->create_time);
        return $result;
    }
}

