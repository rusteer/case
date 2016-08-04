<?php
class Application_Dao_AreaDAO extends Wavegoing_TableDAO{
	protected $_name='area';
	public function composeEntity($row) {
		$entry=new Application_Model_AreaModel();
		$entry->setId($row->id* 1);
		$entry->setName($row->name);
		$entry->setAreaCode($row->area_code);
		$entry->setProvinceId($row->province_id);
		return $entry;
	}
	
	/**
	 *
	 * @param string $areaCode        	
	 * @return Application_Model_AreaModel NULL
	 */
	public function loadArea($areaCode) {
		if($areaCode!= null){
			return $this->getEntity($this->select()->where('area_code = ?',$areaCode));
		}
		return null;
	}
	public function getListByProvince($provinceId) {
		return $this->getCachedEntityList("area_list_by_province_". $provinceId,parent::cacheSeconds,$this->select()->where('province_id = ?',$provinceId));
	}
}

