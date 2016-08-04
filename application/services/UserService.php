<?php
class Application_Service_UserService extends Wavegoing_Service{
	private $areaTable;
	private $userTable;
	private $userAccessLogTable;
	private $userStatisticsTable;
	private $whiteUserTable;
	private $blackUserTable;
	private $blackGroupTable;
	public function __construct() {
		parent::__construct();
		$this->areaTable=new Application_Dao_AreaDAO();
		$this->userTable=new Application_Dao_UserDAO();
		$this->userAccessLogTable=new Application_Dao_UserAccessLogDAO();
		$this->userStatisticsTable=new Application_Dao_UserStatisticsDAO();
		$this->whiteUserTable=new Application_Dao_WhiteUserDAO();
		$this->blackUserTable=new Application_Dao_BlackUserDAO();
		$this->blackGroupTable=new Application_Dao_BlackGroupDAO();
	}
	public function isBlackUser($mobile) {
		return $this->blackGroupTable->isBlack($mobile)|| $this->blackUserTable->isBlack($mobile);
	}
	public function saveUserStatistics($user, $entity, $forRequest=true) {
		$this->saveUserStatisticsByStatTime($user,$entity,date('Ymd'),$forRequest);
		$this->saveUserStatisticsByStatTime($user,$entity,date('Ym'),$forRequest);
	}
	private function saveUserStatisticsByStatTime($user, $entity, $statTime, $forRequest) {
		$statistics=$this->getUserStatistics($user,$statTime);
		if($statistics== null){
			$statistics=new Application_Model_UserStatisticsModel();
			$statistics->createTime=date('Y-m-d H:i:s');
			$statistics->statTime=$statTime;
			$statistics->userId=$user->getId();
		}
		if($forRequest){
			$statistics->requestCount=$statistics->requestCount+ 1;
			$statistics->requestSpending=$statistics->requestSpending+ $entity->price;
			$statistics->requestSharing=$statistics->requestSharing+ $entity->sharing;
		}else{
			$statistics->responseCount=$statistics->responseCount+ 1;
			$statistics->responseSpending=$statistics->responseSpending+ $entity->price;
			$statistics->responseSharing=$statistics->responseSharing+ $entity->sharing;
		}
		if($statistics->id){
			$this->userStatisticsTable->updateUserStatistics($statistics);
			$this->cache->save($statistics,$this->userStatisticsTable->getCacheKey($user,$statTime),array(
					$this->userStatisticsTable->getName()
			),$this->userStatisticsTable->cacheTime);
		}else{
			$this->userStatisticsTable->createUserStatistics($statistics);
		}
	}
	public function getUserStatistics(Application_Model_UserModel $user, $statTime) {
		return $this->userStatisticsTable->getUserStatistics($user,$statTime);
	}
	
	private function recordAccessLog($user) {
		$this->userAccessLogTable->insert(array(
				'user_id'=>$user->getId(),
				'submit_time'=>date('Y-m-d H:i:s')
		));
	}
	
	public function getReport($from, $to, $dayCount=1, $vendor, $provinceId=null) {
		return $this->userTable->getReport($from,$to,$dayCount,$vendor,$provinceId);
	}
	private function loadDBUser(Application_Model_UserModel $requestUser) {
		$user=null;
		if($requestUser->getImsi()!= null)
			$user=$this->userTable->loadUserByImsi($requestUser->getImsi());
		if($user== null&& $requestUser->getMobile()!= null)
			$user=$this->userTable->loadUserByMobile($requestUser->getMobile());
		return $user;
	}
	
	/**
	 *
	 * @param Application_Model_UserModel $user        	
	 * @param boolean $recordLog        	
	 * @return Application_Model_UserModel NULL
	 */
	public function loadUser($user, $recordLog=true) {
		$result=null;
		$areaModel=null;
		if($user->getAreaCode()){
			$areaModel=$this->loadArea($user->getAreaCode());
			if($areaModel){
				$user->setProvinceId($areaModel->getProvinceId());
				$user->setAreaId($areaModel->getId());
			}
		}
		$result=$this->loadDBUser($user);
		if($result!= null)
			$result=$this->updateUser($result,$user);
		else{
			$this->userTable->createUser($user);
			$result=$this->loadDBUser($user);
		}
		if($result!= null){
			$result->setArea($areaModel);
			if($recordLog)
				$this->recordAccessLog($result);
			if($result->getImei())
				$result->setWhite($this->whiteUserTable->isWhite($result));
			if($result->getMobile())
				$result->setBlack($this->isBlackUser($result->getMobile()));
		}
		return $result;
	}
	
	
	public function saveUser(Application_Model_UserModel $user){
	    $this->userTable->updateEntity($user);
	}
	private function updateUser(Application_Model_UserModel $user, Application_Model_UserModel $requestUser) {
		$needUpdate=false;
		foreach(array(
				"imsi",
				'imei',
				'machineUid',
				'mobile',
				'areaCode',
				//'vendor',
				'softwareVersion',
				'provinceId',
				'areaId'
		) as $property){
			$newValue=$requestUser->get($property);
			$oldValue=$user->get($property);
			if($newValue && $newValue!= $oldValue){
				$user->set($property,$newValue);
				$needUpdate=true; 
			}
		}
		
		if($needUpdate){
			$this->userTable->updateUser($user);
		}
		return $user;
	}
	
	/**
	 *
	 * @param String $areaCode        	
	 * @return Application_Model_AreaModel null
	 */
	private function loadArea($areaCode) {
		$cacheKey="area_". $areaCode;
		$result=$this->cache->load($cacheKey);
		if($result)
			return $result;
		$result=$this->areaTable->loadArea($areaCode);
		if($result)
			$this->cache->save($result,$cacheKey,array(
					"forever"
			),null);
		return $result;
	}
	public function loadById($id) {
		return $this->userTable->loadById($id);
	}
}

