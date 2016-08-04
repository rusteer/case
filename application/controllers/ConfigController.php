<?php
/**
 * @author Hike
 *
 */
class ConfigController extends Wavegoing_Action{
    /**
	 *
	 * @var Application_Service_ConfigService
	 */
    private $service;
    public function init(){
        $this->service=new Application_Service_ConfigService();
    }
    public function indexAction(){}
    public function loadAction(){
        $this->view->result=$this->service->getConfig($this->getRequest()->getParam("provinceId",0));;
    }
    public function saveAction(){
        $config=$this->composeEntity();
        $this->service->saveConfig($config);
    }
    
    /**
	 *
	 * @return Application_Model_ChannelModel
	 */
    private function composeEntity(){
        $entity=new Application_Model_ConfigModel();
        $id=$this->_getParam("config-id",null);
        if($id!=null){
            $entity->setId($id);
        }
        $entity->setDailyRequestLimit($this->_getParam("config-daily_request_limit"));
        $entity->setDailyRequestSpendingLimit($this->_getParam("config-daily_request_spending_limit"));
        $entity->setDailyResponseSpendingLimit($this->_getParam("config-daily_response_spending_limit"));
        $entity->setMontylyRequestLimit($this->_getParam("config-montyly_request_limit"));
        $entity->setMontylyRequestSpendingLimit($this->_getParam("config-montyly_request_spending_imit"));
        $entity->setMontylyResponseSpendingLimit($this->_getParam("config-montyly_response_spending_limit"));
        $entity->setChannelCountPerRequest($this->_getParam("config-channel_count_per_request"));
        $entity->setInactiveSeconds($this->_getParam("config-inactive_seconds"));
        $entity->setProvinceId($this->_getParam("provinceId"));
        return $entity;
    }
}



