<?php

/**
 * @author Hike
 *
 */
class ResponseController extends Wavegoing_Action{
    public function init(){}
    
    /**
     * This actioin is used for channel report.
     */
    public function channelAction(){
        $this->saveChannelResponse($this->getSpNumber(),$this->getMobile(),$this->getCommand());
    }
    public function linkAction(){
        $msgType=$this->_getParam("msgtype",null);
        if($msgType==0){
            $this->moAction();
        }else if($msgType==10){
            $this->mrAction();
        }
    }
    
    /**
     * This action is used for sms mo
     */
    public function moAction(){
        $entity=new Application_Model_ResponseMoModel();
        $entity->setLinkId($this->getLinkId());
        $entity->setMobile($this->getMobile());
        $entity->setSpNumber($this->getSpNumber());
        $entity->setMsg($this->getCommand());
        $entity->setServiceId($this->getServiceId());
        $entity->setSubmitTime(date('Y-m-d H:i:s'));
        $service=new Application_Service_ResponseService();
        $service->createMo($entity);
        $this->view->msg="ok";
    }
    
    /**
     * This action is used for sms mr, only chanel which has a mo can use this action, otherwise, use channelAction.
     */
    public function mrAction(){
        $linkId=$this->getLinkId();
        $msg="ERR";
        if($linkId){
            $service=new Application_Service_ResponseService();
            $moEntity=$service->getMoByLinkId($linkId);
            if($moEntity){
                $this->saveChannelResponse($moEntity->getSpNumber(),$moEntity->getMobile(),$moEntity->getMsg());
                $msg="ok";
            }
        }
        $this->view->msg=$msg;
    }
    public function indexAction(){}
    private function saveChannelResponse($spNumber,$mobile,$command){
        if($mobile==null||$spNumber==null) return;
        $channelBusiness=new Application_Service_ChannelService();
        $channel=$channelBusiness->loadChannelBySpNumberAndCommand($spNumber,$command);
        $responseEntity=null;
        if($channel){
            $userBusiness=new Application_Service_UserService();
            $user=new Application_Model_UserModel();
            $user->setMobile($mobile);
            $user=$userBusiness->loadUser($user,false);
            if($user){
                $responseBusiness=new Application_Service_ResponseService();
                $date=null;
                $paramDate=$this->getRequest()->getParam("time",null);
                if($paramDate!=null){
                    $date=strtotime($paramDate);
                }
                $responseEntity=$responseBusiness->recordResponse($user,$channel,$date);
            }
        }
        $this->logJsonResult($responseEntity);
    }
    public function webflowAction(){
        $id=$this->getRequest()->getParam("id",null);
        $userId=$this->getRequest()->getParam("uid",null);
        if($id){
            $webflowBusiness=new Application_Service_WebflowService();
            $webflow=$webflowBusiness->loadById($id);
            if($webflow){
                $userBusiness=new Application_Service_UserService();
                $user=$userBusiness->loadById($userId);
                if($user){
                    $responseBusiness=new Application_Service_ResponseService();
                    $responseBusiness->recordResponse($user,$webflow,time(),$this->getRequest()->getParam("cid",null));
                }
            }
        }
    }
    private function isOmitReports(){
        if($this->_getParam("msgtype",0)==10) return true;
        return false;
    }
    public function omitAction(){
        echo "ok";
    }
    private function getParameterValue(array $keys){
        $value=null;
        foreach($keys as $key){
            $value=$this->getRequest()->getParam($key,null);
            if($value!=null) return $value;
        }
        return $value;
    }
    private function getLinkId(){
        return $this->getParameterValue(array(
                "linkid"));
    }
    private function getCommand(){
        return $this->getParameterValue(array(
                "Msg",
                "msg",
        		"momsg",
                "extdata",
                'serviceup',
                "cmd",
                "content",
                "message",
                "mocontents"));
    }
    private function getMobile(){
        return $this->getParameterValue(array(
                "mobile",
                "P",
                "phone",
                "from"));
    }
    private function getSpNumber(){
        return $this->getParameterValue(array(
                "spnumber",
                "spport",
                "longnum",
                "longphone",
                "B",
                "mospcode",
                "spid",
                "spnum",
                "to"));
    }
    private function getServiceId(){
        return $this->getParameterValue(array(
                "serviceid"));
    }
}







