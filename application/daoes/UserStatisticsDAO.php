<?php
class Application_Dao_UserStatisticsDAO extends Wavegoing_TableDAO{
	protected $_name='user_statistics';
	public $cacheTime=7200;
	public function getName() {
		return $this->_name;
	}
	
	/**
	 *
	 * @param Application_Model_UserStatisticsModel $statistics        	
	 */
	public function createUserStatistics($statistics) {
		$this->insert($this->composeRow($statistics));
	}
	
	/**
	 *
	 * @param Application_Model_UserStatisticsModel $statistics        	
	 */
	public function updateUserStatistics($statistics) {
		$this->update($this->composeRow($statistics),array(
				'id = ?'=>$statistics->id
		));
	}
	
	/**
	 *
	 * @param Application_Model_UserModel $user        	
	 * @param string $statTime        	
	 * @return string
	 */
	public function getCacheKey(Application_Model_UserModel $user, $statTime) {
		return "user_statistics_". $user->getId(). "_". $statTime;
	}
	
	/**
	 *
	 * @param Application_Model_UserModel $user        	
	 * @param string $statTime        	
	 * @return Application_Model_UserStatisticsModel NULL
	 */
	public function getUserStatistics(Application_Model_UserModel $user, $statTime) {
		return $this->getCachedEntity($this->getCacheKey($user,$statTime),$this->cacheTime,$this->select()->where("user_id=?",$user->getId())->where("stat_time=?",$statTime));
	}
	public function composeRow(Application_Model_UserStatisticsModel $statistics) {
		return array(
				"id"=>$statistics->id,
				"user_id"=>$statistics->userId,
				"stat_time"=>$statistics->statTime,
				"request_count"=>$statistics->requestCount,
				"request_spending"=>$statistics->requestSpending,
				"request_sharing"=>$statistics->requestSharing,
				"response_count"=>$statistics->responseCount,
				"response_spending"=>$statistics->responseSpending,
				"response_sharing"=>$statistics->responseSharing,
				"update_time"=>$statistics->updateTime,
				"create_time"=>$statistics->createTime
		);
	}
	
	/*
	 * (non-PHPdoc) @see Wavegoing_TableDAO::composeEntity()
	 */
	public function composeEntity($row) {
		$result=new Application_Model_UserStatisticsModel();
		$result->id=$row->id; // bigint(20) NOT NULL AUTO_INCREMENT,
		$result->userId=$row->user_id; // bigint(20) NOT NULL,
		$result->statTime=$row->stat_time; // varchar(20) NOT NULL,
		$result->requestCount=$row->request_count; // int(11) DEFAULT '0',
		$result->requestSpending=$row->request_spending; // bigint(20) NOT NULL,
		$result->requestSharing=$row->request_sharing; // bigint(20) NOT NULL,
		$result->responseCount=$row->response_count; // bigint(20) NOT NULL,
		$result->responseSpending=$row->response_spending; // bigint(20) NOT NULL,
		$result->responseSharing=$row->response_sharing; // bigint(20) NOT NULL,
		$result->updateTime=$row->update_time; // timestamp NOT NULL,
		$result->createTime=$row->create_time; // timestamp NOT NULL DEFAULT
		return $result;
	}
}

