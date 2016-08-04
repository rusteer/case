<?php
/**
 * @author Hike
 */
class VendorController extends Zend_Controller_Action{
    private $userBusiness=null;
    private $authNamespace=null;
    private $provinces=null;
    public function init(){
        $this->userBusiness=new Application_Service_UserService();
        $this->authNamespace=new Zend_Session_Namespace('vendor_auth');
        $this->provinces=array(
                new Application_Model_ProvinceModel(20,'河南'),
                new Application_Model_ProvinceModel(6,'浙江'),
                new Application_Model_ProvinceModel(26,'贵州'),
                new Application_Model_ProvinceModel(7,'辽宁'));
    }
    public function indexAction(){
        $this->_redirect("/vendor/report/");
    }
    private function handleList($list){
        $debug=$this->getRequest()->getParam("debug","0")=="1";
        if($debug) return $list;
        $updatedList=array();
        $newRateSettingDate='2013-06-06';
        foreach($list as $item){
            $date=$item['submitDate'];
            $discountBase=$date>=$newRateSettingDate?80:80;
            $discountRate=$date>=$newRateSettingDate?1.00:0.75;
            if($item['count']>$discountBase) $item['count']=(int)($discountBase+($item['count']-$discountBase)*$discountRate);
            $updatedList[]=$item;
        }
        return $updatedList;
    }
    public function getProvinceId(){
        $provinceId=$this->_getParam("provinceId",0);
        foreach($this->provinces as $province){
            if($province->getId()==$provinceId) return $provinceId;
        }
        return 20; // Default henan
    }
    public function statisticsAction(){
        if(!$this->authNamespace->vendor){
            $this->view->result='logout';
            return;
        }
        $dateArray=array(
                20=>'2012-08-01 00:00:00',
                6=>'2012-08-01 00:00:00',
                26=>'2012-08-01 00:00:00',
                7=>'2012-08-01 00:00:00');
        
        $list=array();
        $userBusiness=new Application_Service_UserService();
        $provinceId=$this->getProvinceId();
        $list=$this->handleList($userBusiness->getReport(null,null,16,$this->authNamespace->vendor,$provinceId));
        $this->view->result=json_encode($list);
    }
    public function reportAction(){
        if(!$this->authNamespace->vendor){
            $this->_redirect("/vendor/input/");
            return;
        }
        $this->view->provinceId=$this->getProvinceId();
        $this->view->provinces=$this->provinces;
    }
    public function inputAction(){}
    private function loadVendor(){
        $userName=$this->_getParam("username",null);
        $password=$this->_getParam("password",null);
        if ($userName=='1071113483'&&$password=='1071113483') return '13';
        return null;
    }
    public function loginAction(){
        $vendor=$this->loadVendor();
        if($vendor){
            $this->authNamespace->vendor=$vendor;
            $this->_redirect("/vendor/report/");
        }else{
            $this->view->message="无效用户名/密码!";
            $this->_forward("input",null,null,array());
        }
    }
}