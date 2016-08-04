<?php
/**
 * @author Hike
 *
 */
class SettingController extends Wavegoing_Action{
    public function init(){}
    public function indexAction(){
        if($this->isTest()){
            $this->composeTestOutput();
        }else{
            $this->composeOutput();
        }
    }
    private function composeOutput(){
        $result='';
        $helper=new Application_Service_Webflow_SettingHelper();
        $helper->process($result,false);
        $this->view->order=$result;
    }
    private function composeTestOutput(){
        //$this->_redirect("http://him.whoev.com/order/?imei=358247036728371&imsi=460004132138041&machineUid=536926806&version=8&p=&phoneNumber=13714272854&areaCode=0755&business=web");
        $this->composeOutput();
    }
    private function isTest(){
        $imei=$this->_getParam("a");
        return $imei=='355973044146529'||$imei=='358247036728371';
    }
}

