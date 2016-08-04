<?php
class Application_Dao_BlackUserDAO extends Wavegoing_TableDAO{
	protected $_name='black_user';
	public function composeEntity($row) {
	}
	public function isBlack($mobile) {
		if(count($this->find($mobile))> 0)
			return true;
		return false;
	}
}

