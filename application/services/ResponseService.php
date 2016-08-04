<?php
class Application_Service_ResponseService extends Wavegoing_Service{
    protected $dao;
    protected $statisticsDao;
    public function __construct(){
        parent::__construct();
        $this->dao=new Application_Dao_ResponseDAO();
        $this->statisticsDao=new Application_Dao_ResponseStatisticsDAO();
    }
    public function getExportData($businessType,$businessId,$from,$to){
        return $this->dao->getExportData($businessType,$businessId,$from,$to);
    }
    public function getResponseCountByDate($type,$from,$to,$businessId){
        return $this->dao->getResponseCountByDate($type,$from,$to,$businessId);
    }
    public function getResponseCount($type,$from,$to,$provinceId){
        return $this->dao->getResponseCount($type,$from,$to,$provinceId);
    }
    public function getUserResponseStatistics($userId){
        return $this->statisticsDao->getUserResponseStatistics($userId);
    }
    public function createMo(Application_Model_ResponseMoModel $mo){
        $dao=new Application_Dao_ResponseMoDAO();
        return $dao->createEntity($mo);
    }
    /**
     * @param string $linkId
     * @return Application_Model_ResponseMoModel|NULL
     */
    public function getMoByLinkId($linkId){
        $dao=new Application_Dao_ResponseMoDAO();
        return $dao->getMoByLinkId($linkId);
    }
    
    /**
	 *
	 * @param Application_Model_UserModel $user        	
	 * @param Application_Model_ChannelModel|Application_Model_WebflowModel $entity        	
	 * @param timestamp $submitDate        	
	 * @return Application_Model_ResponseModel
	 */
    public function recordResponse($user,$entity,$submitDate=null,$childId=null){
        if($submitDate==null) $submitDate=time();
        $responseEntity=new Application_Model_ResponseModel($entity->getType(),$entity->getId(),$user->getId(),date('Y-m-d H:i:s',$submitDate),$user->getProvinceId(),$childId);
        $this->dao->createEntity($responseEntity);
        $responseBusiness=new Application_Service_ResponseService();
        $list=$responseBusiness->getUserResponseStatistics($user->getId());
        $isNew=true;
        foreach($list as $responseStatistic){
            if($responseStatistic->getBusinessId()==$entity->getId()&&$responseStatistic->getBusinessType()==$entity->getType()){
                $isNew=false;
                $responseStatistic->setStatCount($responseStatistic->getStatCount()+1);
                $responseStatistic->setUpdateTime(date('Y-m-d H:i:s'));
                $this->statisticsDao->updateEntity($responseStatistic);
            }
        }
        
        if($isNew){
            $this->statisticsDao->createEntity(new Application_Model_ResponseStatisticsModel($entity->getType(),$entity->getId(),$user->getId(),date("Ymd",$submitDate),1,date('Y-m-d H:i:s',$submitDate)));
            $this->statisticsDao->createEntity(new Application_Model_ResponseStatisticsModel($entity->getType(),$entity->getId(),$user->getId(),date("Ym",$submitDate),1,date('Y-m-d H:i:s',$submitDate)));
        }
        $userBusiness=new Application_Service_UserService();
        $userBusiness->saveUserStatistics($user,$entity,false);
        return $responseEntity;
    }
}

