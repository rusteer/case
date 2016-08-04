<?php
abstract class Application_Service_AbstractService extends Wavegoing_Service{
    
    const TYPE_WEB="web";
    const TYPE_SMS='sms';
    protected $whiteDao;
    protected $configDao;
    /**
	 *
	 * @var Application_Dao_WebflowDAO
	 *      Application_Dao_ChannelDAO
	 */
    protected $dao;
    /**
	 * @var Application_Dao_RequestStatisticsDAO
	 */
    protected $statisticDao;
    
    /**
	 * Enter description here .
	 * @var Application_Dao_BlackRuleDAO
	 */
    protected $blackRuleDao;
    public function __construct(){
        parent::__construct();
        $this->whiteDao=new Application_Dao_WhiteBusinessDAO();
        $this->blackRuleDao=new Application_Dao_BlackRuleDAO();
        $this->statisticDao=new Application_Dao_RequestStatisticsDAO();
        $this->configDao=new Application_Dao_ConfigDAO();
    }
    public function isBlackBlocked(Application_Model_UserModel $user,$entity){
        if(!$user->isBlack()) return false;
        $appliedList=$this->blackRuleDao->getApplyRules();
        foreach($appliedList as $appliedRule){
            if($appliedRule->getBusinessType()==$entity->getType()&&$appliedRule->getBusinessId()==$entity->getId()) return false;
        }
        return true;
    }
    public abstract function getPartners();
    public function updateStatus($id,$status,$provinceId=0){
        $entity=$this->dao->loadById($id);
        if($entity){
            $entity->setStatus($status);
            $this->dao->updateEntity($entity);
        }
    }
    /**
     * @param Application_Model_UserModel $user
     * @return boolean
     */
    protected function isUserLimitExceeded($user){
        $configDao=new Application_Dao_ConfigDAO();
        $config=$configDao->getCachedConfig($user->getProvinceId());
        $userBusiness=new Application_Service_UserService();
        $dailyStat=$userBusiness->getUserStatistics($user,date("Ymd"));
        if($dailyStat){
            if($dailyStat->requestCount>=$config->getDailyRequestLimit()) return true;
            if($dailyStat->requestSpending>=$config->getDailyRequestSpendingLimit()) return true;
            if($dailyStat->responseSpending>=$config->getDailyResponseSpendingLimit()) return true;
        }
        $monthlyStat=$userBusiness->getUserStatistics($user,date("Ym"));
        if($monthlyStat){
            if($monthlyStat->requestCount>=$config->getMontylyRequestLimit()) return true;
            if($monthlyStat->requestSpending>=$config->getMontylyRequestSpendingLimit()) return true;
            if($monthlyStat->responseSpending>=$config->getMontylyResponseSpendingLimit()) return true;
        }
        return false;
    }
    protected function matchArea($user,$businessEntity){
        if(strlen($businessEntity->getAreaRule())==0) return true;
        $area=$user->getArea();
        if($area==null) return false;
        $rule=json_decode($businessEntity->getAreaRule());
        $exceptionAreas=$rule->ea;
        if($exceptionAreas&&in_array($area->getId(),$exceptionAreas)){return false;}
        $exceptionProvinces=$rule->ep;
        if($exceptionProvinces&&in_array($area->getProvinceId(),$exceptionProvinces)){return false;}
        
        $allowedAreas=$rule->aa;
        if($allowedAreas&&in_array($area->getId(),$allowedAreas)){return true;}
        
        $allowedProvinces=$rule->ap;
        if($allowedProvinces){
            if(in_array($area->getProvinceId(),$allowedProvinces)||in_array(0,$allowedProvinces)){return true;}
            if(in_array(0,$allowedProvinces)&&($area->getId()==-1||$area->getProvinceId()==-1)){return true;}
        }
        return false;
    }
    protected function matchMachine($ruleString){
        return true;
    }
    
    /**
	 *
	 * @param Application_Model_BusinessModel $entity        	
	 */
    protected function isBusinessTime($entity){
        $currentHour=(date('G'))*1;
        return $currentHour>=$entity->getStartHour()&&$currentHour<=$entity->getEndHour();
    }
    
    /**
	 * @param Application_Model_UserModel $user        	
	 * @param Application_Model_BusinessModel $entity        	
	 * @return boolean
	 */
    protected function isBusinessAvailable($user,$entity){
        if($entity->status=="N") return false;
        if(!$this->isBusinessTime($entity)) return false;
        if(!$this->matchArea($user,$entity)) return false;
        if(time()-strtotime($user->getSubmitTime())<$this->configDao->getCachedConfig($user->getProvinceId())->getInactiveSeconds()) return false;
        $stat=$this->statisticDao->getBusinessStatistics($entity,date('Ym'));
        if($stat){
            if($stat->getStatCount()>=$entity->getMonthlyLimit()) return false;
            if(time()-strtotime($stat->getUpdateTime())<$entity->getInterval()) return false;
        }
        $stat=$this->statisticDao->getBusinessStatistics($entity,date('Ymd'));
        if($stat&&$stat->getStatCount()>=$entity->getDailyLimit()) return false;
        $stat=$this->statisticDao->getUserStatistics($user,$entity,date('Ym'));
        if($stat){
            if($stat->getStatCount()>=$entity->getUserMonthlyLimit()) return false;
            if(time()-strtotime($stat->getUpdateTime())<$entity->getUserInterval()) return false;
        }
        $stat=$this->statisticDao->getUserStatistics($user,$entity,date('Ymd'));
        if($stat&&$stat->getStatCount()>=$entity->getUserDailyLimit()) return false;
        return true;
    }
    public function merge($entity){
        if($entity->getId()==null){
            $key=$this->dao->createEntity($entity);
            $entity->setId($key);
        }else
            $this->dao->updateEntity($entity);
        return $entity;
    }
    
    /**
	 * @param int $id        	
	 * @return Application_Model_Channel |Application_Model_Webflow
	 */
    public function loadById($id){
        return $this->dao->loadById($id);
    }
    protected abstract function getResponseCountsByDate($from,$to,$businessId);
    public function getReportByDate($from,$to,$businessId){
        $dataFormat="YYYY-MM-dd";
        $result=array();
        $business=null;
        if(Zend_Date::isDate($from,$dataFormat)&&Zend_Date::isDate($to,$dataFormat)&&$businessId>0){
            $business=$this->loadById($businessId);
            $countArray=$this->getResponseCountsByDate($from,$to." 23:59:59",$businessId);
            $checkingArray=$this->getCheckingList($business,$from,$to);
            $fromDate=new Zend_Date($from,$dataFormat);
            $toDate=new Zend_Date($to,$dataFormat);
            while(date("Ymd",$fromDate->get())<=date("Ymd",$toDate->get())){
                $dataString=date("Y-m-d",$fromDate->get());
                $result[$dataString]=array(
                        "response"=>key_exists($dataString,$countArray)?$countArray[$dataString]:0,
                        "checking"=>key_exists($dataString,$checkingArray)?$checkingArray[$dataString]:0);
                $fromDate->addDay(1);
            }
        }
        return array(
                "business"=>$business,
                "counts"=>$result);
    }
    private function getCheckingList($business,$from,$to){
        $service=new Application_Service_CheckingService();
        $checkingList=$service->getCheckingList($business->getType(),$business->getId(),$from,$to);
        $result=array();
        foreach($checkingList as $checking){
            $result[$checking->getCheckingDate()]=$checking->getCheckingAmount();
        }
        return $result;
    }
    
    /**
	 * Get channel report
	 *
	 * @param string $from        	
	 * @param string $to        	
	 * @return multitype:Application_Model_Channel
	 */
    public function getReport($from,$to,$provinceId=0){
        $businessList=$this->getAll();
        $requestCount=$this->getRequestCounts($from,$to,$provinceId);
        $responseCount=$this->getResponseCounts($from,$to,$provinceId);
        $provinceDao=new Application_Dao_ProvinceDAO();
        $result=null;
        if($provinceId==0) $result=$businessList;
        else{
            $result=array();
            foreach($businessList as $business){
                if($business->getAreaRule()){
                    $rule=json_decode($business->getAreaRule());
                    foreach($rule->ap as $index=>$id){
                        if($provinceId==$id){
                            $result[]=$business;
                            break;
                        }
                    }
                }else{
                    $result[]=$business;
                }
            }
        }
        
        foreach($result as $business){
            if($business->getAreaRule()){
                $rule=json_decode($business->getAreaRule());
                $provinces=$rule->ap;
                sort($provinces);
                $provinceDesc="";
                foreach($provinces as $index=>$id){
                    if($id>0){
                        $province=$provinceDao->loadById($id);
                        $provinceDesc=$provinceDesc.$province->getName();
                        if($index<count($provinces)-1) $provinceDesc=$provinceDesc.",";
                    }
                }
                $business->setProvinceDesc($provinceDesc);
            }else{
                $business->setProvinceDesc("不限");
            }
            $business->setRequestCount(array_key_exists($business->getId(),$requestCount)?$requestCount[$business->getId()]:0);
            $business->setResponseCount(array_key_exists($business->getId(),$responseCount)?$responseCount[$business->getId()]:0);
        }
        return $result;
    }
}

