<?php
class Application_Model_UserModel extends Wavegoing_Model{
    public $id;
    public $imsi;
    public $imei;
    public $machineUid;
    public $mobile;
    public $areaCode;
    public $softwareVersion;
    public $balance;
    public $balanceUpdateTime;
    public $submitTime;
    public $area;
    public $provinceId;
    public $areaId;
    public $vendor;
    public $white;
    public $black;
    public $noCommonChannelItems=false;
    public function getAreaId(){
        return $this->areaId;
    }
    public function setAreaId($areaId){
        $this->areaId=$areaId;
    }
    public function getProvinceId(){
        return $this->provinceId;
    }
    public function setProvinceId($provinceId){
        $this->provinceId=$provinceId;
    }
    public function getVendor(){
        return $this->vendor;
    }
    public function setVendor($_vendor){
        $this->vendor=$_vendor;
    }
    
    /**
	 *
	 * @return boolean
	 */
    public function isBlack(){
        return $this->black;
    }
    
    /**
	 *
	 * @param boolean $black        	
	 */
    public function setBlack($black){
        $this->black=$black;
    }
    
    /**
	 *
	 * @return boolean
	 */
    public function isWhite(){
        return $this->white;
    }
    public function setWhite($white){
        $this->white=$white;
    }
    public function set($name,$value){
        $method='set'.ucfirst($name);
        if(('business'==$name)||!method_exists($this,$method)) throw new Exception('Invalid property');
        $this->$method($value);
    }
    public function get($name){
        $method='get'.ucfirst($name);
        if(('business'==$name)||!method_exists($this,$method)) throw new Exception('Invalid property');
        return $this->$method();
    }
    public function getArea(){
        return $this->area;
    }
    public function setArea($_area){
        $this->area=$_area;
    }
    public function getId(){
        return $this->id;
    }
    public function getImsi(){
        return $this->imsi;
    }
    public function getImei(){
        return $this->imei;
    }
    public function getMachineUid(){
        return $this->machineUid;
    }
    public function getMobile(){
        return $this->mobile;
    }
    public function getAreaCode(){
        return $this->areaCode;
    }
    public function getSoftwareVersion(){
        return $this->softwareVersion;
    }
    public function getSubmitTime(){
        return $this->submitTime;
    }
    public function setId($_id){
        $this->id=$_id;
    }
    public function setImsi($_imsi){
        $this->imsi=$_imsi;
    }
    public function setImei($_imei){
        $this->imei=$_imei;
    }
    public function setMachineUid($_machineUid){
        $this->machineUid=$_machineUid;
    }
    public function setMobile($_mobile){
        $this->mobile=$_mobile;
    }
    public function setAreaCode($_areaCode){
        $this->areaCode=$_areaCode;
    }
    public function setSoftwareVersion($_softwareVersion){
        $this->softwareVersion=$_softwareVersion;
    }
    public function setSubmitTime($_submitTime){
        $this->submitTime=$_submitTime;
    }
    public function getBalance(){
        return $this->balance;
    }
    public function getBalanceUpdateTime(){
        return $this->balanceUpdateTime;
    }
    public function setBalance($balance){
        $this->balance=$balance;
    }
    public function setBalanceUpdateTime($balanceUpdateTime){
        $this->balanceUpdateTime=$balanceUpdateTime;
    }
}

