<?php
class Application_Service_WhiteBusinessService extends Wavegoing_Service{
	/**
	 *
	 * @var Application_Dao_WhiteBusinessDAO
	 */
	private $dao;
	public function __construct() {
		parent::__construct();
		$this->dao=new Application_Dao_WhiteBusinessDAO();
	}
	
		/**
	 * @param string $type
	 * @param integer $id
	 */
	public function setWhite($type,$id){
		$this->dao->setWhite($type, $id);
	}
}

