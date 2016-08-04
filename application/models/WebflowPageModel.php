<?php
class Application_Model_WebflowPageModel extends Wavegoing_Model{
    private $id;
    private $userId;
    private $webflowId;
    private $pageIndex;
    private $url;
    private $submitTime;
    private $body;
    public function getId(){
        return $this->id;
    }
    public function getUserId(){
        return $this->userId;
    }
    public function getWebflowId(){
        return $this->webflowId;
    }
    public function getPageIndex(){
        return $this->pageIndex;
    }
    public function getUrl(){
        return $this->url;
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
    public function setWebflowId($webflowId){
        $this->webflowId=$webflowId;
    }
    public function setPageIndex($pageIndex){
        $this->pageIndex=$pageIndex;
    }
    public function setUrl($url){
        $this->url=$url;
    }
    public function setSubmitTime($submitTime){
        $this->submitTime=$submitTime;
    }
    public function getBody(){
        return $this->body;
    }
    public function setBody($body){
        $this->body=$body;
    }
}

