<?php
class Application_Service_WebflowService extends Application_Service_AbstractService{
    const mockSize=5;
    
    /**
	 * @var Application_Dao_WebflowItemDAO
	 */
    private $itemDao;
    
    /**
     * @var Application_Dao_WebflowPvStatisticsDAO
     */
    private $pvStatisticsDao;
    /**
     * @var Application_Dao_WebflowUvStatisticsDAO
     */
    private $uvStatisticsDao;
    /**
     * @var Application_Dao_WebflowUvDAO
     */
    private $uvDao;
    
    /**
     * @var string
     */
    private $result;
    
    /**
     * @var int
     */
    private $targetWebflowId;
    
    public function __construct(){
        parent::__construct();
        $this->dao=new Application_Dao_WebflowDAO();
        $this->itemDao=new Application_Dao_WebflowItemDAO();
        $this->pvStatisticsDao=new Application_Dao_WebflowPvStatisticsDAO();
        $this->uvStatisticsDao=new Application_Dao_WebflowUvStatisticsDAO();
        $this->uvDao=new Application_Dao_WebflowUvDAO();
        $this->result="";
    }
    public function getPartners(){
        return $this->dao->getPartners();
    }
    public function savePage(Application_Model_WebflowPageModel $model){
        $dao=new Application_Dao_WebflowPageDAO();
        $id=$dao->createEntity($model);
        $file="/var/log/apache2/page/$id.html";
        $fh=fopen($file,'w') or die("can't open file");
        fwrite($fh,$model->getBody());
        fclose($fh);
    }
    
    /**
	 *
	 * @return Application_Model_WebflowDemoModel null
	 */
    public function loadDemo(){
        $demoDao=new Application_Dao_WebflowDemoDAO();
        return $demoDao->getOne();
    }
    
    /**
	 *
	 * @param Application_Model_WebflowDemoModel $entity        	
	 */
    public function saveDemo($entity){
        $demoDao=new Application_Dao_WebflowDemoDAO();
        $demoDao->saveOne($entity);
    }
    
    /**
	 *
	 * @param Application_Model_UserModel $user        	
	 * @return Application_Model_WebflowModel NULL
	 */
    private function getWhiteBusiness($user){
        $list=$this->getAll();
        shuffle($list);
        foreach($list as $entity){
            if($this->whiteDao->isWhite($entity)) return $entity;
        }
        return null;
    }
    
    /**
	 *
	 * @param Application_Model_UserModel $user        	
	 * @param Application_Model_BusinessModel $entity        	
	 * @return boolean
	 * @see Application_Service_AbstractService::isBusinessAvailable()
	 */
    protected function isBusinessAvailable($user,$entity){
        if($user->getSoftwareVersion()<$entity->getVersion()) return false;
        return parent::isBusinessAvailable($user,$entity);
    }
    
    /**
	 *
	 * @param Application_Model_UserModel $user        	
	 * @return Application_Model_WebflowModel null
	 */
    private function getAvailableWebflow(Application_Model_UserModel $user){
        if($user->isWhite()) return $this->getWhiteBusiness($user);
        if($this->isUserLimitExceeded($user)) return null;
        $list=$this->dao->getEnabledList();
        shuffle($list);
        foreach($list as $webflow){
            if($this->isBusinessAvailable($user,$webflow)) return $webflow;
        }
        return null;
    }
    
    /**
	 *
	 * @param Application_Model_UserModel $user        	
	 * @param Application_Model_WebflowModel $webflow        	
	 * @param boolean $isMock        	
	 */
    private function processSingle($user,$webflow,$isMock=false,$uvNeeded=false){
        if($user&&$webflow){
            $helperName="Application_Service_Webflow_".ucfirst($webflow->getHelperType())."Helper";
            $help=new $helperName();
            $help->init($user,$webflow);
            $help->process($this->result,$isMock);
            
            //--Add uv/pv statistics
            $this->pvStatisticsDao->addMockCount($webflow->getId(),date('Ymd'));
            if($uvNeeded){
            	$this->uvStatisticsDao->addMockCount($webflow->getId(),date('Ymd'));
            	$uvEntity=new Application_Model_WebflowUvModel();
            	$uvEntity->setBusinessId($webflow->getId());
            	$uvEntity->setCreateTime(date('Y-m-d H:i:s'));
            	$uvEntity->setStatTime(date('Ymd'));
            	$uvEntity->setUserId($user->getId());
            	$this->uvDao->createEntity($uvEntity);
            }
        }
    }
    
    /**
	 *
	 * @param Application_Model_UserModel $user        	
	 * @return string NULL
	 */
    public function process(Application_Model_UserModel $user){
        //---Business flow begin---
        $webflow=$this->getAvailableWebflow($user);
        if($webflow){
            $uvNeeded=$this->needProcessUvMock($webflow,$user);
            $this->processSingle($user,$webflow,false,$uvNeeded);
            $this->targetWebflowId=$webflow->getId();
        }
        //---Business flow end---
        //---Mock flow begin---
        $this->processMockAccess($user);
        //---Mock flow end---
        //---Balance flow begin---
        /*
        $help=new Application_Service_Webflow_BalanceHelper();
        $help->init($user,null);
        $help->process($this->result,false);
        */
        //---Balance flow end---
        return $this->result;
    }
    private function needProcessMock($webflow,$rate,$statEntity){
        if($statEntity==null) return true;
        $maxMockCount=$webflow->getDailyLimit()/$rate;
        $mockCount=$statEntity->getStatCount();
        $lastMockTime=$statEntity->getUpdateTime();
        return ($maxMockCount>$mockCount&&time()-strtotime($lastMockTime)>$webflow->getMockInterval());
    }
    
    /**
     * @param Application_Model_WebflowModel $webflow
     * @param Application_Model_UserModel $user
     * @param Application_Model_WebflowUvStatisticsModel $statEntity
     * @return boolean
     */
    private function needProcessUvMock($webflow,$user){
        $rate=$webflow->getUvRate();
        if($rate<0.01||$rate>=1) return false;
        $mockEntity=$this->uvDao->getMock($webflow->getId(),$user->getId(),date('Ymd'));
        if($mockEntity) return false;
        return $this->needProcessMock($webflow,$rate,$this->uvStatisticsDao->getMockStatistics($webflow->getId(),date('Ymd')));
    }
    
    /**
     * @param Application_Model_WebflowModel $webflow
     * @return boolean
     */
    private function needProcessPvMock(Application_Model_WebflowModel $webflow){
        $rate=$webflow->getPvRate();
        if($rate<0.01||$rate>=1) return false;
        return $this->needProcessMock($webflow,$rate,$this->pvStatisticsDao->getMockStatistics($webflow->getId(),date('Ymd')));
    }
    
    /**
	 *
	 * @param Application_Model_UserModel $user        	
	 */
    private function processMockAccess($user){
        if($user){
            if($user->isWhite()) return;
            $mockList=$this->dao->getMockList();
            $mockListSize=count($mockList);
            if($mockListSize==0) return;
            shuffle($mockList);
            $todoCount=rand(1,self::mockSize>$mockListSize?$mockListSize:self::mockSize);
            foreach($mockList as $webflow){
                if($webflow->getId()==$this->targetWebflowId) continue;
                $pvNeeded=$this->needProcessPvMock($webflow);
                $uvNeeded=$this->needProcessUvMock($webflow,$user);
                if($uvNeeded||$pvNeeded){
                    $this->processSingle($user,$webflow,true,$uvNeeded);
                    if((--$todoCount)<=0) break;
                }
            }
        }
    }
    protected function getRequestCounts($from,$to,$provinceId){
        $requestBusiness=new Application_Service_RequestService();
        return $requestBusiness->getRequestCount(self::TYPE_WEB,$from,$to,$provinceId);
    }
    /* (non-PHPdoc)
	 * @see Application_Service_AbstractService::getResponseCountsByDate()
	 */
    protected function getResponseCountsByDate($from,$to,$businessId){
        $responseBusiness=new Application_Service_ResponseService();
        return $responseBusiness->getResponseCountByDate(self::TYPE_WEB,$from,$to,$businessId);
    }
    protected function getResponseCounts($from,$to,$provinceId){
        $responseBusiness=new Application_Service_ResponseService();
        return $responseBusiness->getResponseCount(self::TYPE_WEB,$from,$to,$provinceId);
    }
    public function getAll(){
        return $this->dao->getAll();
    }
}

