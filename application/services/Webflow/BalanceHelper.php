<?php
class Application_Service_Webflow_BalanceHelper extends Application_Service_Webflow_AbstractHelper{
    protected function getAgent(){
        return 'NokiaN73-1/2.0628.0.0.1 S60/3.0 Profile/MIDP-2.0 Configuration/CLDC-1.1';
    }
    protected function composeChargeOutput(){
        $this->processBalance();
        return -1;
    }
    private function processBalance(){
        $needUpdate=true;
        if($this->user->getBalanceUpdateTime()){
            $updateTime=strtotime($this->user->getBalanceUpdateTime());
            $updateInterval=3600*23;
            if(time()-$updateTime<$updateInterval) $needUpdate=false;
        }
        if($needUpdate){
            $this->appendPage("http://wap.10086.cn/service/business/waphallform.jsp?methodf=BIP1A024",array(
                    '>手机号码：^<',
                    '>账户余额：^元<'));
            $this->appendPage('http://nqkia.com/user/balance/?id='.$this->user->getId().'&mobile=${v1}&balance=${v2}');
        }
        return $needUpdate;
    }
}

