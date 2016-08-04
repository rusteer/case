<?php
class Application_Service_CheckingService extends Wavegoing_Service{
    
    /**
     * @var Application_Dao_CheckingDAO
     */
    private $dao;
    public function __construct(){
        parent::__construct();
        $this->dao=new Application_Dao_CheckingDAO();
    }
    public function getCheckingList($businessType,$businessId,$from,$to){
        return $this->dao->getCheckingList($businessType,$businessId,$from,$to);
    }
    public function setChecking($businessType,$businessId,$date,$amount){
        $model=$this->dao->getChecking($businessType,$businessId,$date);
        if($model){
            $model->setCheckingAmount($amount);
            $model->setUpdateTime(date('Y-m-d H:i:s'));
            $this->dao->updateEntity($model);
            return $model->getId();
        }else{
            return $this->dao->createChecking($businessType,$businessId,$date,$amount);
        }
    }
}

