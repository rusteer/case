<?php
class Application_Service_ConfigService extends Wavegoing_Service{
	/**
	 *
	 * @var Application_Dao_ConfigDAO
	 */
	private $dao;
	public function __construct() {
		parent::__construct();
		$this->dao=new Application_Dao_ConfigDAO();
	}
	
	/**
	 * Get Cached Config
	 * 
	 * @return Application_Model_ConfigModel
	 */
	public function getCachedConfig($provinceId=0) {
		return $this->dao->getCachedConfig($provinceId);
	}
	
	public function getConfig($provinceId=0) {
		return $this->dao->getConfig($provinceId);
	}
	
	public function saveConfig(Application_Model_ConfigModel $config){
	    if($config->getId()==null){
	        $this->dao->createEntity($config);
	    }else{
	        $this->dao->updateEntity($config);
	    }
	}
	
	public function getAllowedProvinces($includeAreas) {
		$provinceDao=new Application_Dao_ProvinceDAO();
		$areaDao=new Application_Dao_AreaDAO();
		$idList=explode(",", '6,26,7,5,13,16,15,24,10,30,2,3,4,8,9,11,12,14,17,18,19,21,22,23,25,27,28,29,20,31');
		//$idList=explode(",", '6,26,7,5,10');
		$result=array();
		foreach($idList as $id){
			$province=$provinceDao->loadById($id);
			if($includeAreas)
				$province->setAreaList($areaDao->getListByProvince($id));
			$result[]=$province;
		}
		return $result;
	}
}

