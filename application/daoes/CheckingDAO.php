<?php
class Application_Dao_CheckingDAO extends Wavegoing_TableDAO{
    protected $_name='checking';
    public function getName(){
        return $this->_name;
    }
    
    public function createChecking($businessType,$businessId,$date,$amount){
        $model=new Application_Model_CheckingModel();
        $model->setBusinessType($businessType);
        $model->setBusinessId($businessId);
        $model->setCheckingDate($date);
        $model->setCheckingAmount($amount);
        $model->setCreateTime(date('Y-m-d H:i:s'));
        $model->setUpdateTime($model->getCreateTime());
        return $this->createEntity($model);
    }
    /**
     * @param string $businessType
     * @param int $businessId
     * @param string $date
     * @return Application_Model_CheckingModel|null
     */
    public function getChecking($businessType,$businessId,$date){
        if($businessType&&$businessId&&Zend_Date::isDate($date,"YYYY-MM-dd")){
            $select=$this->select();
            $select->where("business_type=?",$businessType);
            $select->where("business_id=?",$businessId);
            $select->where("checking_date=?",$date);
            return $this->getEntity($select);
        }
    }
    public function getCheckingList($businessType,$businessId,$from,$to){
        if($businessType&&$businessId&&Zend_Date::isDate($from,"YYYY-MM-dd")&&Zend_Date::isDate($to,"YYYY-MM-dd")){
            $select=$this->select();
            $select->where("business_type=?",$businessType);
            $select->where("business_id=?",$businessId);
            $select->where("checking_date>=?",$from);
            $select->where("checking_date<=?",$to);
            return $this->getEntityList($select);
        }
    }
    public function composeRow(Application_Model_CheckingModel $checking){
        return array(
                "id"=>$checking->id,
                "business_type"=>$checking->businessType,
                "business_id"=>$checking->businessId,
                "checking_date"=>$checking->checkingDate,
                "checking_amount"=>$checking->checkingAmount,
                "create_time"=>$checking->createTime,
                "update_time"=>$checking->updateTime);
    }
    
    /*
	 * (non-PHPdoc) @see Wavegoing_TableDAO::composeEntity()
	 */
    public function composeEntity($row){
        $result=new Application_Model_CheckingModel();
        $result->id=$row->id;
        $result->businessType=$row->business_type;
        $result->businessId=$row->business_id;
        $result->checkingDate=$row->checking_date;
        $result->checkingAmount=$row->checking_amount;
        $result->createTime=$row->create_time;
        $result->updateTime=$row->update_time;
        return $result;
    }
}

