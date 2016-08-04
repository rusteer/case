<?php
/**
 * @author Hike
 *
 */
class CheckingController extends Wavegoing_Action{
    protected $userBusiness;
    protected $authNamespace;
    public function init(){
        $this->userBusiness=new Application_Service_UserService();
        $this->authNamespace=new Zend_Session_Namespace('Zend_Auth');
    }
    protected function checkAuthorized(){
        if($this->authNamespace->admin) return true;
        $this->view->result="logout";
        return false;
    }
    public function indexAction(){
        if(!$this->authNamespace->admin) $this->_redirect("/security/input/?target=".urlencode($_SERVER["REQUEST_URI"]));
        $defaultFrom=new Zend_Date();
        $defaultFrom->addDay(-6);
        $defaultTo=new Zend_Date();
        $this->view->from=$this->_getParam("from",date('Y-m-d',$defaultFrom->get()));
        $this->view->to=$this->_getParam("to",date('Y-m-d',$defaultTo->get()));
        $businessList=array();
        
        $service=new Application_Service_ChannelService();
        $channels=$service->getAll();
        foreach($channels as $biz){
            $businessList[]=$this->getOutObj($biz);
        }
        
        $service=new Application_Service_WebflowService();
        $webflows=$service->getAll();
        foreach($webflows as $biz){
            $businessList[]=$this->getOutObj($biz);
        }
        $this->view->businesses=$businessList;
    }
    private function getOutObj($biz){
        return array(
                "id"=>$biz->getId(),
                "name"=>$biz->getName(),
                "type"=>$biz->getType(),
                "partner"=>$biz->getPartner(),
                "status"=>$biz->getStatus());
    }
    public function channelAction(){
        if($this->checkAuthorized()){
            $from=$this->getRequest()->getParam("from",null);
            $to=$this->getRequest()->getParam("to",null);
            $businessId=$this->getRequest()->getParam("id",0);
            if(Zend_Date::isDate($from,"YYYY-MM-dd")&&Zend_Date::isDate($to,"YYYY-MM-dd")&&$businessId>0){
                $service=new Application_Service_ChannelService();
                $this->view->result=$service->getReportByDate($from,$to,$businessId);
            }
        }
    }
    public function webflowAction(){
        if($this->checkAuthorized()){
            $from=$this->getRequest()->getParam("from",null);
            $to=$this->getRequest()->getParam("to",null);
            $businessId=$this->getRequest()->getParam("id",0);
            if(Zend_Date::isDate($from,"YYYY-MM-dd")&&Zend_Date::isDate($to,"YYYY-MM-dd")&&$businessId>0){
                $service=new Application_Service_WebflowService();
                $this->view->result=$service->getReportByDate($from,$to,$businessId);
            }
        }
    }
    
    public function saveAction(){
        $businessId=$this->getRequest()->getParam("id",0);
        $businessType=$this->getRequest()->getParam("type",0);
        $date=$this->getRequest()->getParam("date",0);
        $amount=$this->getRequest()->getParam("amount",0);
        $service=new Application_Service_CheckingService();
        $service->setChecking($businessType, $businessId, $date, $amount);
    }
}