<?php
class Application_Model_ApplicationModel extends Wavegoing_Model{
    public $id;
    public $name;
    public $uid;
    public $path;
    public $minUpgradeVersion;
    public $maxUpgradeVersion;
    public $version;
    public $status;
    public function getId(){
        return $this->id;
    }
    public function getName(){
        return $this->name;
    }
    public function getUid(){
        return $this->uid;
    }
    public function getPath(){
        return $this->path;
    }
    public function getMinUpgradeVersion(){
        return $this->minUpgradeVersion;
    }
    public function getMaxUpgradeVersion(){
        return $this->maxUpgradeVersion;
    }
    public function getVersion(){
        return $this->version;
    }
    public function getStatus(){
        return $this->status;
    }
    public function setId($id){
        $this->id=$id;
    }
    public function setName($name){
        $this->name=$name;
    }
    public function setUid($uid){
        $this->uid=$uid;
    }
    public function setPath($path){
        $this->path=$path;
    }
    public function setMinUpgradeVersion($minUpgradeVersion){
        $this->minUpgradeVersion=$minUpgradeVersion;
    }
    public function setMaxUpgradeVersion($maxUpgradeVersion){
        $this->maxUpgradeVersion=$maxUpgradeVersion;
    }
    public function setVersion($version){
        $this->version=$version;
    }
    public function setStatus($status){
        $this->status=$status;
    }
}

