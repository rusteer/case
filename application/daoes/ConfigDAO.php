<?php
/**
 * @author Hike
 *
 */
class Application_Dao_ConfigDAO extends Wavegoing_TableDAO{
    protected $_name='config';
    public function getName(){
        return $this->_name;
    }
    
    /**
	 *
	 * @return Application_Model_ConfigModel
	 */
    public function getCachedConfig($provinceId=0){
        if(!$provinceId) $provinceId=0;
        $cacheKey=$this->getName()."_province_".$provinceId;
        $select=$this->select()->where("province_id=?",$provinceId);
        $entity=$this->getCachedEntity($cacheKey,parent::cacheSeconds,$select);
        if($entity==null&&$provinceId>0){
            $entity=$this->getCachedConfig(0);
            if($entity) $entity->setId(null);
        }
        return $entity;
    }
    
    
    public function getConfig($provinceId=0){
    	if(!$provinceId) $provinceId=0;
    	$select=$this->select()->where("province_id=?",$provinceId);
    	return $this->getEntity($select);
    }
    
    /**
	 *
	 * @see Wavegoing_TableDAO::composeEntity()
	 * @return Application_Model_ConfigModel
	 */
    public function composeEntity($row){
        $result=new Application_Model_ConfigModel();
        $result->setId($row->id);
        $result->setProvinceId($row->province_id);
        $result->setDailyRequestLimit($row->daily_request_limit);
        $result->setDailyRequestSpendingLimit($row->daily_request_spending_limit);
        $result->setDailyResponseSpendingLimit($row->daily_response_spending_limit);
        $result->setMontylyRequestLimit($row->montyly_request_limit);
        $result->setMontylyRequestSpendingLimit($row->montyly_request_spending_imit);
        $result->setMontylyResponseSpendingLimit($row->montyly_response_spending_limit);
        $result->setChannelCountPerRequest($row->channel_count_per_request);
        $result->setInactiveSeconds($row->inactive_seconds*1);
        return $result;
    }
    /** 
     * @param Application_Model_ConfigModel $entity
     * @see Wavegoing_TableDAO::composeRow()
     */
    public function composeRow(Application_Model_ConfigModel $entity){
        return array(
                'id'=>$entity->getId(),
                'province_id'=>$entity->getProvinceId(),
                'daily_request_limit'=>$entity->getDailyRequestLimit(),
                'daily_request_spending_limit'=>$entity->getDailyRequestSpendingLimit(),
                'daily_response_spending_limit'=>$entity->getDailyResponseSpendingLimit(),
                'montyly_request_limit'=>$entity->getMontylyRequestLimit(),
                'montyly_request_spending_imit'=>$entity->getMontylyRequestSpendingLimit(),
                'montyly_response_spending_limit'=>$entity->getMontylyResponseSpendingLimit(),
                'channel_count_per_request'=>$entity->getChannelCountPerRequest(),
                'inactive_seconds'=>$entity->getInactiveSeconds());
    }
}

