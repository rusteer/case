<?php
class Application_Model_ChannelModel extends Application_Model_BusinessModel{
    public $spNumber;
    public $command;
    public $type='sms';
    public $requestPerTime;
    public function getSpNumber(){
        return $this->spNumber;
    }
    public function getCommand(){
        return $this->command;
    }
    public function getType(){
        return $this->type;
    }
    public function setSpNumber($spNumber){
        $this->spNumber=$spNumber;
    }
    public function setCommand($command){
        $this->command=$command;
    }
    public function setType($type){
        $this->type=$type;
    }
    public function getRequestPerTime(){
        return $this->requestPerTime;
    }
    public function setRequestPerTime($requestPerTime){
        $this->requestPerTime=$requestPerTime;
    }
}

