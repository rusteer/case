<?php
/**
 * @author Hike
 *
 */
class AreaController extends Zend_Controller_Action{
    public function init(){}
    public function indexAction(){}
    public function treeAction(){
        $provinces=$this->getProvinces(true);
        $result=array();
        $blockedArea=null;
        $businessId=$this->getRequest()->getParam("businessId",0);
        $businessType=$this->getRequest()->getParam("businessType","sms");
        if($businessId>0){
            $service=$businessType=='sms'?new Application_Service_ChannelService():new Application_Service_WebflowService();
            $channel=$service->loadById($businessId);
            if($channel){
                $blockedArea=array();
                $rule=json_decode($channel->getAreaRule());
                foreach($rule->ea as $areaId){
                    $blockedArea[]=$areaId;
                }
            }
        }
        foreach($provinces as $province){
            $provinceArray=array(
                    "text"=>$province->getName(),
                    "cls"=>"folder",
                    "expanded"=>false,
                    "children"=>array(),
                    "value"=>$province->getId());
            $areaList=$province->getAreaList();
            foreach($areaList as $area){
                $checked=false;
                if($blockedArea!=null){
                    foreach($blockedArea as $areaId){
                        if($areaId==$area->getId()) $checked=true;
                    }
                }
                $provinceArray["children"][]=array(
                        "id"=>$area->getId(),
                        "text"=>$area->getName(),
                        "value"=>$area->getId(),
                        "leaf"=>true,
                        "checked"=>$checked);
            }
            $result[]=$provinceArray;
        }
        echo json_encode($result);
    }
    public function provincesAction(){
        echo json_encode($this->getProvinces(false));
    }
    private function getProvinces($includeAreas=false){
        $configService=new Application_Service_ConfigService();
        return $configService->getAllowedProvinces($includeAreas);
    }
}



