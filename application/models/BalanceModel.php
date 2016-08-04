<?php
class Application_Model_BalanceModel extends Wavegoing_Model{
    private $id; // `id` bigint(20) NOT NULL AUTO_INCREMENT,
    private $userId; // `user_id` bigint(20) NOT NULL,
    private $balance;
    private $submitTime; // //`create_time` timestamp NOT NULL DEFAULT
    
    public function __construct($userId,$balance,$submitTime){
        $this->userId=$userId;
        $this->balance=$balance;
        $this->submitTime=$submitTime;
    }
    
    // CURRENT_TIMESTAMP,
    public function getId(){
        return $this->id;
    }
    public function getUserId(){
        return $this->userId;
    }
    public function getBalance(){
        return $this->balance;
    }
    public function getSubmitTime(){
        return $this->submitTime;
    }
    public function setId($id){
        $this->id=$id;
    }
    public function setUserId($userId){
        $this->userId=$userId;
    }
    public function setBalance($balance){
        $this->balance=$balance;
    }
    public function setSubmitTime($submitTime){
        $this->submitTime=$submitTime;
    }
}

