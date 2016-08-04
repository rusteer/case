<?php
class Application_Dao_UserDAO extends Wavegoing_TableDAO{
	protected $_name='user';
	public function getName() {
		return $this->_name;
	}
	public function getReport($from, $to, $dayCount=1, $vendor, $provinceId) {
		$select=$this->select();
		$select->from($this,array(
				'COUNT(1) as business_count',
				"DATE_FORMAT(submit_time, '%Y-%m-%d') as submit_date",
				"vendor"
		));
		if($vendor)
			$select->where("vendor=?",$vendor);
		if($provinceId!= 0)
			$select->where("province_id=?",$provinceId);
		$select->where("imsi is not null");
		$hasDayLimit=false;
		if($from){
			$select->where('submit_time >=?',$from);
			$hasDayLimit=true;
		}
		if($to){
			$select->where('submit_time <=?',$to);
			$hasDayLimit=true;
		}
		if( ! $hasDayLimit&& $dayCount> 0){
		    $defaultFrom=new Zend_Date();
		    //$defaultFrom->subDate($dayCount*1);
		    $defaultFrom->subDay($dayCount*1);
			$select->where("submit_time>?",$defaultFrom->get('YYYY-MM-dd'));
		}
		//$select->where("software_version>=?",7);
		$select->group(array(
				"DATE_FORMAT(submit_time, '%Y-%m-%d')",
				"vendor"
		));
		//var_dump((string)$select);
		$rows=$this->fetchAll($select);
		$result=array();
		foreach($rows as $row){
			$count=$row->business_count* 1;
			if($count>3)
			$result[]=array(
					"vendor"=>$row->vendor,
					"submitDate"=>$row->submit_date,
					"count"=>$count
			);
		}
		return $result;
	}
	public function composeRow(Application_Model_UserModel $user) {
		return array(
				'submit_time'=>($user->getSubmitTime()!= null?$user->getSubmitTime():date('Y-m-d H:i:s')),
				'id'=>$user->getId(),
				'province_id'=>$user->getProvinceId(),
				'area_id'=>$user->getAreaId(),
				'area_code'=>$user->getAreaCode(),
				'imei'=>$user->getImei(),
				'imsi'=>$user->getImsi(),
				'machine_uid'=>$user->getMachineUid(),
				'mobile'=>$user->getMobile(),
				'vendor'=>$user->getVendor(),
		        'balance'=>$user->getBalance(),
		        'balance_update_time'=>$user->getBalanceUpdateTime(),
				'software_version'=>$user->getSoftwareVersion()
		);
	}
	public function createUser(Application_Model_UserModel $user) {
		$this->createEntity($user);
	}
	public function updateUser(Application_Model_UserModel $user) {
		$this->updateEntity($user);
	}
	
	/**
	 *
	 * @param string $mobile        	
	 * @return
	 *
	 *
	 */
	public function loadUserByMobile($mobile) {
		if($mobile){
			return $this->getEntity($this->select()->where('mobile = ?',$mobile));
		}
		return null;
	}
	public function loadUserByImsi($imsi) {
		if($imsi){
			return $this->getEntity($this->select()->where('imsi = ?',$imsi));
		}
		return null;
	}
	
	/**
	 *
	 * @see Wavegoing_TableDAO::composeEntity()
	 * @return Application_Model_UserModel
	 */
	public function composeEntity($row) {
		$result=new Application_Model_UserModel();
		$result->setId($row->id* 1);
		$result->setAreaCode($row->area_code);
		$result->setImei($row->imei);
		$result->setImsi($row->imsi);
		$result->setMachineUid($row->machine_uid);
		$result->setMobile($row->mobile);
		$result->setSoftwareVersion($row->software_version* 1);
		$result->setSubmitTime($row->submit_time);
		$result->setProvinceId($row->province_id);
		$result->setAreaId($row->area_id);
		$result->setVendor($row->vendor);
		$result->setBalance($row->balance);
		$result->setBalanceUpdateTime($row->balance_update_time);
		return $result;
	}
}

