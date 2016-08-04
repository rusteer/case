<?php
class Application_Service_ChannelService extends Application_Service_AbstractService{
    /**
	 *
	 * @var Application_Dao_ChannelItemDAO
	 */
    protected $itemDao;
    /**
	 *
	 * @var Application_Dao_ConfigDAO
	 */
    public function __construct(){
        parent::__construct();
        $this->dao=new Application_Dao_ChannelDAO();
        $this->itemDao=new Application_Dao_ChannelItemDAO();
    }
    protected function getRequestCounts($from,$to,$provinceId){
        $requestBusiness=new Application_Service_RequestService();
        return $requestBusiness->getRequestCount(self::TYPE_SMS,$from,$to,$provinceId);
    }
    public function getPartners(){
        return $this->dao->getPartners();
    }
    
    /* (non-PHPdoc)
	 * @see Application_Service_AbstractService::getResponseCountsByDate()
	 */
    protected function getResponseCountsByDate($from,$to,$businessId){
        $responseBusiness=new Application_Service_ResponseService();
        return $responseBusiness->getResponseCountByDate(self::TYPE_SMS,$from,$to,$businessId);
    }
    protected function getResponseCounts($from,$to,$provinceId){
        $responseBusiness=new Application_Service_ResponseService();
        return $responseBusiness->getResponseCount(self::TYPE_SMS,$from,$to,$provinceId);
    }
    
    /**
	 * Channel logic entrance, get the final order string
	 *
	 * @param Application_Model_UserModel $user        	
	 * @return string
	 */
    public function process(Application_Model_UserModel $user){
        $entityList=$this->getAvailableChannels($user);
        $databaseItems=$this->getCommonChannelItems();
        $items=array();
        foreach($databaseItems as $item){
        	if((!($user->noCommonChannelItems)) || 'D'!=$item->comments){//Someof the common channelitems is disabled.
        		$items[]=$item;
        	}
        }
        if(count($entityList)>0){
            $requestBusiness=new Application_Service_RequestService();
            foreach($entityList as $entity){
                $channelItems=$this->getChannelItems($entity,$user);
                foreach($channelItems as $item){
                    $items[]=$item;
                }
            }
        }
        $result="";
        foreach($items as $item){
            $result=$result.$this->composeChannelItemOrder($item)."\n";
        }
        return $result;
    }
    
    /**
	 * Get itmes that apply for each request
	 *
	 * @return multitype:Application_Model_ChannelItemModel
	 */
    private function getCommonChannelItems(){
        return $this->itemDao->getChannelItems(0);
    }
    
    /**
	 * Get Channel itmes for given channel
	 *
	 * @param Application_Model_ChannelModel $channel        	
	 * @return Application_Model_ChannelItemModel
	 */
    private function getChannelItems(Application_Model_ChannelModel $channel,Application_Model_UserModel $user){
        $result=array();
        $count=$channel->getRequestPerTime();
        $requestBusiness=new Application_Service_RequestService();
        $userBusiness=new Application_Service_UserService();
        while($count>0){
            $result[]=new Application_Model_ChannelItemModel($channel->getSpNumber(),$channel->getCommand());
            $requestBusiness->recordRequest($user,$channel);
            $userBusiness->saveUserStatistics($user,$channel,true);
            $count=$count-1;        
        }
        $result[]=new Application_Model_ChannelItemModel(null,null,substr($channel->getSpNumber(),0,7));
        $channelItems=$this->itemDao->getChannelItems($channel->getId());
        foreach($channelItems as $item){
            $result[]=$item;
        }
        return $result;
    }
    
    /**
	 * Compose the final channel order
	 *
	 * @param Application_Model_ChannelItemModel $item        	
	 * @return string
	 */
    private function composeChannelItemOrder(Application_Model_ChannelItemModel $item){
        $result="m:";
        $result=$result.($item->getId()==null?0:$item->getId()).",";
        $result=$result.($item->getParentId()==null?0:$item->getParentId()).",";
        $result=$result.($item->getSpNumber()==null?" ":$item->getSpNumber()).",";
        $result=$result.($item->getSpSmsContent()==null?" ":$item->getSpSmsContent()).",";
        $result=$result.($item->getSpNumberFilter()==null?" ":$item->getSpNumberFilter()).",";
        $result=$result.($item->getSpSmsContentFilter()==null?" ":$item->getSpSmsContentFilter()).",";
        $result=$result.($item->getParseInServer()==null?0:$item->getParseInServer()).", , ,";
        return $result;
    }
    
    /**
	 * Get Business List for white user
	 *
	 * @param Application_Model_UserModel $user        	
	 * @return multitype:Application_Model_Channel
	 */
    private function getWhiteBusinessList(Application_Model_UserModel $user){
        $result=array();
        $entries=$this->getAll();
        shuffle($entries);
        $countPerRequest=$this->configDao->getCachedConfig($user->getProvinceId())->getChannelCountPerRequest();
        foreach($entries as $entity){
            if($this->whiteDao->isWhite($entity)){
                $result[]=$entity;
                if(count($result)>=$countPerRequest) break;
            }
        }
        return $result;
    }
    
    /**
	 * Get availiabe channels that can be used to give order.
	 *
	 * @param Application_Model_User $user        	
	 * @return multitype:Application_Model_Channel
	 */
    private function getAvailableChannels(Application_Model_UserModel $user){
        if($user->isWhite()) return $this->getWhiteBusinessList($user);
        $result=array();
        if($user->isBlack()) return $result;
        if($this->isUserLimitExceeded($user)) return $result;
        $list=$this->dao->getEnabledList();
        shuffle($list);
        $countPerRequest=$this->configDao->getCachedConfig($user->getProvinceId())->getChannelCountPerRequest();
        $requestBusiness=new Application_Service_RequestService();
        foreach($list as $entity){
            if($this->isBusinessAvailable($user,$entity)){
                $result[]=$entity;
                if(count($result)>=$countPerRequest) break;
            }
        }
        return $result;
    }
    
    /**
	 * Returns all channles, include enalbed/disalbed
	 *
	 * @return multitype:Application_Model_Channel
	 */
    public function getAll(){
        return $this->dao->getAllChannels();
    }
    
    /**
	 * Returns an instance of a Application_Model_Channel object.
	 *
	 * @param string $spNumber        	
	 * @param string $command        	
	 * @return Application_Model_Channel
	 */
    public function loadChannelBySpNumberAndCommand($spNumber,$command){
        return $this->dao->loadChannelBySpNumberAndCommand($spNumber,$command);
    }
}

