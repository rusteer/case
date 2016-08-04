<?php
class Application_Model_ResponseMoModel extends Wavegoing_Model{
    public $id;
    public $linkId;
    public $mobile;
    public $spNumber;
    public $msg;
    public $serviceId;
    public $submitTime;
    public function getId(){
        return $this->id;
    }
    public function getLinkId(){
        return $this->linkId;
    }
    public function getMobile(){
        return $this->mobile;
    }
    public function getSpNumber(){
        return $this->spNumber;
    }
    public function getMsg(){
        return $this->msg;
    }
    public function getServiceId(){
        return $this->serviceId;
    }
    public function getSubmitTime(){
        return $this->submitTime;
    }
    public function setId($id){
        $this->id=$id;
    }
    public function setLinkId($linkId){
        $this->linkId=$linkId;
    }
    public function setMobile($mobile){
        $this->mobile=$mobile;
    }
    public function setSpNumber($spNumber){
        $this->spNumber=$spNumber;
    }
    public function setMsg($msg){
        $this->msg=$msg;
    }
    public function setServiceId($serviceId){
        $this->serviceId=$serviceId;
    }
    public function setSubmitTime($submitTime){
        $this->submitTime=$submitTime;
    }
}

