<?php
class Application_Model_WebflowPvStatisticsModel extends Wavegoing_Model{
    protected $id;
    protected $businessId;
    protected $statTime;
    protected $statCount;
    protected $updateTime;
    public function getId(){
        return $this->id;
    }
    public function getBusinessId(){
        return $this->businessId;
    }
    public function getStatTime(){
        return $this->statTime;
    }
    public function getStatCount(){
        return $this->statCount;
    }
    public function getUpdateTime(){
        return $this->updateTime;
    }
    public function setId($id){
        $this->id=$id;
    }
    public function setBusinessId($businessId){
        $this->businessId=$businessId;
    }
    public function setStatTime($statTime){
        $this->statTime=$statTime;
    }
    public function setStatCount($statCount){
        $this->statCount=$statCount;
    }
    public function setUpdateTime($updateTime){
        $this->updateTime=$updateTime;
    }
}

