<?php
class Application_Service_BalanceService extends Wavegoing_Service{
    /**
	 *
	 * @var Application_Dao_ConfigDAO
	 */
    private $dao;
    public function __construct(){
        parent::__construct();
        $this->dao=new Application_Dao_BalanceDAO();
    }
    public function save(Application_Model_BalanceModel $entity){
        $this->dao->createEntity($entity);
    }
}

