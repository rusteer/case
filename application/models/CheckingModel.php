<?php
class Application_Model_CheckingModel extends Wavegoing_Model{
    public $id; // `id` bigint(20) NOT NULL AUTO_INCREMENT,
    public $businessType; // `user_id` bigint(20) NOT NULL,
    public $businessId;
    public $checkingDate;
    public $checkingAmount;
    public $createTime;
    public $updateTime;
    /**
	 * @return the $id
	 */
    public function getId(){
        return $this->id;
    }
    
    /**
	 * @return the $businessType
	 */
    public function getBusinessType(){
        return $this->businessType;
    }
    
    /**
	 * @return the $businessId
	 */
    public function getBusinessId(){
        return $this->businessId;
    }
    
    /**
	 * @return the $checkingDate
	 */
    public function getCheckingDate(){
        return $this->checkingDate;
    }
    
    /**
	 * @return the $checkingAmount
	 */
    public function getCheckingAmount(){
        return $this->checkingAmount;
    }
    
    /**
	 * @return the $createTime
	 */
    public function getCreateTime(){
        return $this->createTime;
    }
    
    /**
	 * @return the $updateTime
	 */
    public function getUpdateTime(){
        return $this->updateTime;
    }
    
    /**
	 * @param field_type $id
	 */
    public function setId($id){
        $this->id=$id;
    }
    
    /**
	 * @param field_type $businessType
	 */
    public function setBusinessType($businessType){
        $this->businessType=$businessType;
    }
    
    /**
	 * @param field_type $businessId
	 */
    public function setBusinessId($businessId){
        $this->businessId=$businessId;
    }
    
    /**
	 * @param field_type $checkingDate
	 */
    public function setCheckingDate($checkingDate){
        $this->checkingDate=$checkingDate;
    }
    
    /**
	 * @param field_type $checkingAmount
	 */
    public function setCheckingAmount($checkingAmount){
        $this->checkingAmount=$checkingAmount;
    }
    
    /**
	 * @param field_type $createTime
	 */
    public function setCreateTime($createTime){
        $this->createTime=$createTime;
    }
    
    /**
	 * @param field_type $updateTime
	 */
    public function setUpdateTime($updateTime){
        $this->updateTime=$updateTime;
    }
}

