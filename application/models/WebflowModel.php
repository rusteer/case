<?php
class Application_Model_WebflowModel extends Application_Model_BusinessModel{
    public $feeCode;
    public $machineRule;
    public $searchMsg;
    public $option1;
    public $option2;
    public $option3;
    public $pvRate;
    public $uvRate;
    public $mockInterval;
    public $preContent;
    public $content;
    public $remoteReport;
    public $type='web';
    public $helperType;
    public function getFeeCode(){
        return $this->feeCode;
    }
    public function getMachineRule(){
        return $this->machineRule;
    }
    public function getSearchMsg(){
        return $this->searchMsg;
    }
    public function getOption1(){
        return $this->option1;
    }
    public function getOption2(){
        return $this->option2;
    }
    public function getOption3(){
        return $this->option3;
    }
    public function setFeeCode($feeCode){
        $this->feeCode=$feeCode;
    }
    public function setMachineRule($machineRule){
        $this->machineRule=$machineRule;
    }
    public function setSearchMsg($searchMsg){
        $this->searchMsg=$searchMsg;
    }
    public function setOption1($option1){
        $this->option1=$option1;
    }
    public function setOption2($option2){
        $this->option2=$option2;
    }
    public function setOption3($option3){
        $this->option3=$option3;
    }
    public function getMockInterval(){
        return $this->mockInterval;
    }
    public function setMockInterval($mockInterval){
        $this->mockInterval=$mockInterval;
    }
    public function getPreContent(){
        return $this->preContent;
    }
    public function setPreContent($preContent){
        $this->preContent=$preContent;
    }
    public function getContent(){
        return $this->content;
    }
    public function setContent($content){
        $this->content=$content;
    }
    public function getRemoteReport(){
        return $this->remoteReport;
    }
    public function setRemoteReport($remoteReport){
        $this->remoteReport=$remoteReport;
    }
    public function getPvRate(){
        return $this->pvRate;
    }
    public function getUvRate(){
        return $this->uvRate;
    }
    public function setPvRate($pvRate){
        $this->pvRate=$pvRate;
    }
    public function setUvRate($uvRate){
        $this->uvRate=$uvRate;
    }
    public function getType(){
        return $this->type;
    }
    public function setType($type){
        $this->type=$type;
    }
    public function getHelperType(){
        return $this->helperType;
    }
    public function setHelperType($helperType){
        $this->helperType=$helperType;
    }
}

