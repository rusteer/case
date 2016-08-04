<?php
class Application_Service_RequestService extends Wavegoing_Service{
	protected $dao;
	protected $statisticDao;
	public function __construct() {
		parent::__construct();
		$this->dao=new Application_Dao_RequestDAO();
		$this->statisticDao=new Application_Dao_RequestStatisticsDAO();
	}
	public function getRequestCount($type, $from, $to, $provinceId) {
		return $this->dao->getRequestCount($type,$from,$to,$provinceId);
	}
	
	/**
	 *
	 * @param Application_Model_UserModel $user        	
	 * @param Application_Model_ChannelModel|Application_Model_WebflowModel $entity        	
	 */
	public function recordRequest($user, $entity) {
		$this->dao->createEntity(new Application_Model_RequestModel($entity->getType(),$entity->getId(),$user->getId(),date('Y-m-d H:i:s'),$user->getProvinceId()));
		$stat=$this->statisticDao->getBusinessStatistics($entity,date('Ymd'));
		if($stat)
			$this->statisticDao->increaseStatistics($stat);
		else
			$this->statisticDao->createEntity(new Application_Model_RequestStatisticsModel($entity->getType(),$entity->getId(),0,date("Ymd",time()),1,date('Y-m-d H:i:s')));
		
		$stat=$this->statisticDao->getBusinessStatistics($entity,date('Ym'));
		if($stat)
			$this->statisticDao->increaseStatistics($stat);
		else
			$this->statisticDao->createEntity(new Application_Model_RequestStatisticsModel($entity->getType(),$entity->getId(),0,date("Ym",time()),1,date('Y-m-d H:i:s')));
		
		$stat=$this->statisticDao->getUserStatistics($user,$entity,date('Ymd'));
		if($stat)
			$this->statisticDao->increaseStatistics($stat);
		else
			$this->statisticDao->createEntity(new Application_Model_RequestStatisticsModel($entity->getType(),$entity->getId(),$user->getId(),date("Ymd",time()),1,date('Y-m-d H:i:s')));
		
		$stat=$this->statisticDao->getUserStatistics($user,$entity,date('Ym'));
		if($stat)
			$this->statisticDao->increaseStatistics($stat);
		else
			$this->statisticDao->createEntity(new Application_Model_RequestStatisticsModel($entity->getType(),$entity->getId(),$user->getId(),date("Ym",time()),1,date('Y-m-d H:i:s')));
	}
	public function getUserRequestStatistics($userId) {
		return $this->statisticDao->getUserStatistics($userId);
	}
}

