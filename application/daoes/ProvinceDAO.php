<?php
class Application_Dao_ProvinceDAO extends Wavegoing_TableDAO{
	protected $_name='province';
	public function composeEntity($row) {
		$result=new Application_Model_ProvinceModel();
		$result->setId($row->id* 1);
		$result->setName($row->name);
		return $result;
	}
	
	/**
	 *
	 * @see Wavegoing_TableDAO::loadById()
	 * @return Application_Model_ProvinceModel
	 */
	public function loadById($id) {
		return $this->getCachedEntity("province_id_". $id,parent::cacheSeconds,$this->select()->where("id=?",$id));
	}
}

