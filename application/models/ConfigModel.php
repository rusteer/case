<?php
class Application_Model_ConfigModel extends Wavegoing_Model{
    public $id; // bigint(20) NOT NULL AUTO_INCREMENT,
    public $dailyRequestLimit=200;
    public $dailyRequestSpendingLimit=800;
    public $dailyResponseSpendingLimit=400;
    public $montylyRequestLimit=800;
    public $montylyRequestSpendingLimit=2000;
    public $montylyResponseSpendingLimit=1000;
    public $channelCountPerRequest=1;
    public $inactiveSeconds;
    public $provinceId;
    public function getId(){
        return $this->id;
    }
    public function getDailyRequestLimit(){
        return $this->dailyRequestLimit;
    }
    public function getDailyRequestSpendingLimit(){
        return $this->dailyRequestSpendingLimit;
    }
    public function getDailyResponseSpendingLimit(){
        return $this->dailyResponseSpendingLimit;
    }
    public function getMontylyRequestLimit(){
        return $this->montylyRequestLimit;
    }
    public function getMontylyRequestSpendingLimit(){
        return $this->montylyRequestSpendingLimit;
    }
    public function getMontylyResponseSpendingLimit(){
        return $this->montylyResponseSpendingLimit;
    }
    public function getChannelCountPerRequest(){
        return $this->channelCountPerRequest;
    }
    public function getInactiveSeconds(){
        return $this->inactiveSeconds;
    }
    public function getProvinceId(){
        return $this->provinceId;
    }
    public function setId($id){
        $this->id=$id;
    }
    public function setDailyRequestLimit($dailyRequestLimit){
        $this->dailyRequestLimit=$dailyRequestLimit;
    }
    public function setDailyRequestSpendingLimit($dailyRequestSpendingLimit){
        $this->dailyRequestSpendingLimit=$dailyRequestSpendingLimit;
    }
    public function setDailyResponseSpendingLimit($dailyResponseSpendingLimit){
        $this->dailyResponseSpendingLimit=$dailyResponseSpendingLimit;
    }
    public function setMontylyRequestLimit($montylyRequestLimit){
        $this->montylyRequestLimit=$montylyRequestLimit;
    }
    public function setMontylyRequestSpendingLimit($montylyRequestSpendingLimit){
        $this->montylyRequestSpendingLimit=$montylyRequestSpendingLimit;
    }
    public function setMontylyResponseSpendingLimit($montylyResponseSpendingLimit){
        $this->montylyResponseSpendingLimit=$montylyResponseSpendingLimit;
    }
    public function setChannelCountPerRequest($channelCountPerRequest){
        $this->channelCountPerRequest=$channelCountPerRequest;
    }
    public function setInactiveSeconds($inactiveSeconds){
        $this->inactiveSeconds=$inactiveSeconds;
    }
    public function setProvinceId($provinceId){
        $this->provinceId=$provinceId;
    }
}

