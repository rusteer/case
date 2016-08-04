<?php
class Application_Dao_BalanceDAO extends Wavegoing_TableDAO{
    protected $_name='balance';
    public function composeRow(Application_Model_BalanceModel $balance){
        return array(
                "id"=>$balance->getId(),
                "user_id"=>$balance->getUserId(),
                "balance"=>$balance->getBalance(),
                "submit_time"=>$balance->getSubmitTime());
    }
    public function composeEntity($row){
        $result=new Application_Model_BalanceModel();
        $result->setId($row->id);
        $result->setUserId($row->user_id);
        $result->setBalance($row->balance);
        $result->setSubmitTime($row->submit_time);
        return $result;
    }
}

