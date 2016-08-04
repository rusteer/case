<?php

/**
 * 
 * Helper for online game
 * @author Hike
 *
 */
class Application_Service_Webflow_OnlineGameHelper extends Application_Service_Webflow_AbstractHelper{
    protected function getAgent(){
        return 'NokiaN73-1/2.0628.0.0.1 S60/3.0 Profile/MIDP-2.0 Configuration/CLDC-1.1';
    }
    protected function composePreChargeOutput(){
        //$this->appendPage('http://gamepie.g188.net/gamecms/wap/game/wyinfo/700018728000?channelId=10005000','href="^^">[免费下载]');
        $this->appendPage($this->webflow->getOption1(),'href="^^">[免费下载]');
    }
    protected function composeChargeOutput(){
        $this->appendPage('http://gamepie.g188.net${v1}','ontimer="^">');
        $this->appendPage('${v1}',array(
                'MIDlet-Jar-URL: ^0x0d',
                'MIDlet-Install-Notify: ^0x0d'));
        $this->appendPage('${v1}');
        $this->appendPage('${v2}',null,3,'900 Success');
        //$url="http://gmp.i139.cn/bizcontrol/LoginOnlineGame?sender=202&cpId=C00165&cpServiceId=614410043408&fid=1000&channelId=10005000";
        $url=$this->webflow->getOption2();
        $this->appendPage($url,array(
                'userId=^0x0d',
                'key=^0x0d'));
        //$url='http://211.99.213.46:8080/pay';
        $url=$this->webflow->getOption3();
        $this->appendPage($url.'?cpid=10013&userid=${v1}&key=${v2}&money=800',array('<ret>^</ret>','<status>^</status>'));
        $url='http://w.nqkia.com/response/webflow/?ret=${v1}&status=${v2}&id='.$this->webflow->getId().'&uid='.$this->user->getId();
        $this->appendPage($url);
    }
}

