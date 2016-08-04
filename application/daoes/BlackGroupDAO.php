<?php
class Application_Dao_BlackGroupDAO extends Wavegoing_TableDAO{
	protected $_name='black_group';
	const cacheKey="black_group_all";
	public function composeEntity($row) {
		$result=new Application_Model_BlackGroupModel();
		$result->setMobilePrefix($row->mobile_prefix);
		return $result;
	}
	private function getAll() {
		return $this->getCachedEntityList(self::cacheKey,parent::cacheSeconds);
	}
	public function isBlack($mobile) {
		$list=$this->getAll();
		foreach($list as $entity){
			$prefix=$entity->getMobilePrefix();
			if(substr($mobile,0,strlen($prefix))== $prefix)
				return true;
		}
		return false;
	}
}

