<?php
class Application_Dao_WebflowDAO extends Wavegoing_TableDAO{
    protected $_name='webflow';
    const cacheAll='webflow_all_rows';
    const cacheAllEnabled='webflow_all_enabled';
    const cacheMock='webflow_all_mock';
    public function getAll(){
        return $this->getEntityList();
    }
    public function getMockList(){
        return $this->getCachedEntityList(self::cacheMock,parent::cacheSeconds,$this->select()->where("status=?",'Y')->where('(pv_rate<1 or uv_rate<1)'));
    }
    public function getEnabledList(){
        return $this->getCachedEntityList(self::cacheAllEnabled,parent::cacheSeconds,$this->select()->where("status=?",'Y'));
    }
    public function getPartners(){
        $sql="select distinct partner from webflow";
        $rows=$this->getAdapter()->fetchAll($sql);
        $result=array();
        foreach($rows as $row){
            $result[]=$row['partner'];
        }
        return $result;
    }
    
    /**
	 *
	 * @param Application_Model_WebflowModel $entity        	
	 * @see Wavegoing_TableDAO::composeRow()
	 */
    public function composeRow($entity){
        return array(
                "id"=>$entity->id,
                "name"=>$entity->name,
                "fee_code"=>$entity->feeCode,
                "status"=>$entity->status,
                "version"=>$entity->version,
                "user_daily_limit"=>$entity->userDailyLimit,
                "user_monthly_limit"=>$entity->userMonthlyLimit,
                "daily_limit"=>$entity->dailyLimit,
                "monthly_limit"=>$entity->monthlyLimit,
                "interval"=>$entity->interval,
                "user_interval"=>$entity->userInterval,
                "area_rule"=>$entity->areaRule,
                "machine_rule"=>$entity->machineRule,
                "comments"=>$entity->comments,
                "start_hour"=>$entity->startHour,
                "end_hour"=>$entity->endHour,
                "pv_rate"=>$entity->getPvRate(),
                "uv_rate"=>$entity->getUvRate(),
                "mock_interval"=>$entity->getMockInterval(),
                "partner"=>$entity->partner,
                "price"=>$entity->price,
                "sharing"=>$entity->sharing,
                "helper_type"=>$entity->getHelperType(),
                "content"=>$entity->getContent(),
                "pre_content"=>$entity->getPreContent(),
                "option1"=>$entity->option1,
                "option2"=>$entity->option2,
                "option3"=>$entity->option3,
                "create_time"=>$entity->createTime,
                "search_msg"=>$entity->searchMsg,
                "remote_report"=>$entity->remoteReport,
                "payment_cycle"=>$entity->paymentCycle);
    }
    public function composeEntity($row){
        $result=new Application_Model_WebflowModel();
        $result->setId($row->id*1);
        $result->setName($row->name);
        $result->setFeeCode($row->fee_code);
        $result->setStatus($row->status);
        $result->setVersion($row->version*1);
        $result->setUserDailyLimit($row->user_daily_limit*1);
        $result->setUserMonthlyLimit($row->user_monthly_limit*1);
        $result->setDailyLimit($row->daily_limit*1);
        $result->setMonthlyLimit($row->monthly_limit*1);
        $result->setInterval($row->interval*1);
        $result->setUserInterval($row->user_interval*1);
        $result->setAreaRule($row->area_rule);
        $result->setMachineRule($row->machine_rule);
        $result->setComments($row->comments);
        $result->setStartHour($row->start_hour);
        $result->setEndHour($row->end_hour);
        $result->setPvRate($row->pv_rate);
        $result->setUvRate($row->uv_rate);
        $result->setMockInterval($row->mock_interval);
        $result->setPartner($row->partner);
        $result->setPrice($row->price);
        $result->setSharing($row->sharing);
        $result->setHelperType($row->helper_type);
        $result->setSearchMsg($row->search_msg);
        $result->setOption1($row->option1);
        $result->setOption2($row->option2);
        $result->setOption3($row->option3);
        $result->setContent($row->content);
        $result->setPreContent($row->pre_content);
        $result->setPaymentCycle($row->payment_cycle);
        $result->setRemoteReport($row->remote_report);
        return $result;
    }
}

