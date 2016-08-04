<?php
class Application_Service_Webflow_BbxHelper extends Application_Service_Webflow_AbstractHelper{
	protected function getAgent() {
		return 'NokiaN73-1/2.0628.0.0.1 S60/3.0 Profile/MIDP-2.0 Configuration/CLDC-1.1';
	}
	protected function composeChargeOutput() {
		$this->appendPage('http://g.10086.cn/gamecms/wap/game/gameinfo/'. $this->webflow->getFeeCode());
		$this->appendPage('http://g.10086.cn/gamecms/wap/game/downGameWait?id='. $this->webflow->getFeeCode(). '&amp;channelId=&amp;cardId=','ontimer="^">');
		$this->appendPage('${v1}',array(
				'MIDlet-Jar-URL: ^0x0d',
				'MIDlet-Install-Notify: ^0x0d'
		));
		$this->appendPage('${v1}');
		$this->appendPage('${v2}',null,3,'900 Success');
		$this->appendResponsePage();
		return $this->result;
	}
}

