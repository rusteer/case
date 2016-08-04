<?php
class Application_Dao_WhiteUserDAO extends Wavegoing_TableDAO{
	protected $_name='white_user';
	const cacheKey="white_user_all";
	private function fetchAllWhiteUsers() {
		return $this->getCachedEntityList(self::cacheKey,parent::cacheSeconds);
	}
	public function isWhite(Application_Model_UserModel $user) {
		$list=$this->fetchAllWhiteUsers();
		foreach($list as $whiteUser){
			if($whiteUser->getImei()== $user->getImei())
				return true;
		}
		return false;
	}
	public function composeEntity($row) {
		$result=new Application_Model_WhiteUserModel();
		$result->setImei($row->imei);
		$result->setStatus($row->status);
		return $result;
	}
}

