<?php
class Application_Model_WebflowUvModel extends Wavegoing_Model{
    protected $id;
    protected $businessId;
    protected $userId;
    protected $statTime;
    protected $createTime;
    public function getId(){
        return $this->id;
    }
    public function getBusinessId(){
        return $this->businessId;
    }
    public function getUserId(){
        return $this->userId;
    }
    public function getStatTime(){
        return $this->statTime;
    }
    public function getCreateTime(){
        return $this->createTime;
    }
    public function setId($id){
        $this->id=$id;
    }
    public function setBusinessId($businessId){
        $this->businessId=$businessId;
    }
    public function setUserId($userId){
        $this->userId=$userId;
    }
    public function setStatTime($statTime){
        $this->statTime=$statTime;
    }
    public function setCreateTime($createTime){
        $this->createTime=$createTime;
    }
}

