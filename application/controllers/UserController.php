<?php
/**
 * @author Hike
 *
 */
class UserController extends Wavegoing_Action{
    public function init(){}
    public function indexAction(){}
    public function balanceAction(){
        $id=$this->_getParam("id",null);
        $mobile=$this->_getParam("mobile",null);
        $balance=$this->_getParam("balance",null);
        if(strlen($id)>0&&strlen($mobile)==11&&strlen($balance)>0){
            $id=$id*1;
            $balance=$balance*1;
            $service=new Application_Service_UserService();
            $user=$service->loadById($id);
            if($user){
                $user->setBalance($balance);
                $user->setBalanceUpdateTime(date('Y-m-d H:i:s'));
                $service->saveUser($user);
                $service=new Application_Service_BalanceService();
                $service->save(new Application_Model_BalanceModel($id,$balance,date('Y-m-d H:i:s')));
            }
        }
    }
}

