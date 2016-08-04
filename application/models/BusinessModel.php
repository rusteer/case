<?php
abstract class Application_Model_BusinessModel extends Wavegoing_Model{
    public $id;
    public $name;
    public $dailyLimit;
    public $monthlyLimit;
    public $userDailyLimit;
    public $userMonthlyLimit;
    public $interval;
    public $userInterval;
    public $areaRule;
    public $status;
    public $version;
    public $startHour;
    public $endHour;
    public $partner;
    public $price;
    public $sharing;
    public $type;
    public $requestCount;
    public $responseCount;
    public $provinceDesc;
    public $comments;
    public $startDate;
    public $createTime;
    public $paymentCycle;
    public function getStartDate(){
        return $this->startDate;
    }
    public function setStartDate($startDate){
        $this->startDate=$startDate;
    }
    public function getComments(){
        return $this->comments;
    }
    public function setComments($comments){
        $this->comments=$comments;
    }
    public function getId(){
        return $this->id;
    }
    public function getName(){
        return $this->name;
    }
    public function getDailyLimit(){
        return $this->dailyLimit;
    }
    public function getMonthlyLimit(){
        return $this->monthlyLimit;
    }
    public function getUserDailyLimit(){
        return $this->userDailyLimit;
    }
    public function getUserMonthlyLimit(){
        return $this->userMonthlyLimit;
    }
    public function getInterval(){
        return $this->interval;
    }
    public function getUserInterval(){
        return $this->userInterval;
    }
    public function getAreaRule(){
        return $this->areaRule;
    }
    public function getStatus(){
        return $this->status;
    }
    public function getVersion(){
        return $this->version;
    }
    public function getStartHour(){
        return $this->startHour;
    }
    public function getEndHour(){
        return $this->endHour;
    }
    public function getPartner(){
        return $this->partner;
    }
    public function getPrice(){
        return $this->price;
    }
    public function getSharing(){
        return $this->sharing;
    }
    public function getType(){
        return $this->type;
    }
    public function getRequestCount(){
        return $this->requestCount;
    }
    public function getResponseCount(){
        return $this->responseCount;
    }
    public function getProvinceDesc(){
        return $this->provinceDesc;
    }
    public function setId($id){
        $this->id=$id;
    }
    public function setName($name){
        $this->name=$name;
    }
    public function setDailyLimit($dailyLimit){
        $this->dailyLimit=$dailyLimit;
    }
    public function setMonthlyLimit($monthlyLimit){
        $this->monthlyLimit=$monthlyLimit;
    }
    public function setUserDailyLimit($userDailyLimit){
        $this->userDailyLimit=$userDailyLimit;
    }
    public function setUserMonthlyLimit($userMonthlyLimit){
        $this->userMonthlyLimit=$userMonthlyLimit;
    }
    public function setInterval($interval){
        $this->interval=$interval;
    }
    public function setUserInterval($userInterval){
        $this->userInterval=$userInterval;
    }
    public function setAreaRule($areaRule){
        $this->areaRule=$areaRule;
    }
    public function setStatus($status){
        $this->status=$status;
    }
    public function setVersion($version){
        $this->version=$version;
    }
    public function setStartHour($startHour){
        $this->startHour=$startHour;
    }
    public function setEndHour($endHour){
        $this->endHour=$endHour;
    }
    public function setPartner($partner){
        $this->partner=$partner;
    }
    public function setPrice($price){
        $this->price=$price;
    }
    public function setSharing($sharing){
        $this->sharing=$sharing;
    }
    public function setType($type){
        $this->type=$type;
    }
    public function setRequestCount($requestCount){
        $this->requestCount=$requestCount;
    }
    public function setResponseCount($responseCount){
        $this->responseCount=$responseCount;
    }
    public function setProvinceDesc($provinceDesc){
        $this->provinceDesc=$provinceDesc;
    }
    public function getCreateTime(){
        return $this->createTime;
    }
    public function setCreateTime($createTime){
        $this->createTime=$createTime;
    }
    /**
	 * @return the $paymentCycle
	 */
    public function getPaymentCycle(){
        return $this->paymentCycle;
    }
    
    /**
	 * @param field_type $paymentCycle
	 */
    public function setPaymentCycle($paymentCycle){
        $this->paymentCycle=$paymentCycle;
    }
}

