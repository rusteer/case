<?php
class Application_Service_Webflow_ComicsHelper extends Application_Service_Webflow_AbstractHelper{
	protected function composePreChargeOutput() {
		$this->appendPage($this->webflow->getOption1(),'/portalone/^^/prePalyOnlineRead');
		$this->appendPage('http://wap.dm.10086.cn:80/portalone/${v1}/prePalyOnlineRead','/portalone/^^/playResult.action');
	}
	protected function composeChargeOutput() {
		$this->appendPage('http://wap.dm.10086.cn:80/portalone/${v1}/playResult.action',null,2,$this->webflow->getOption2());
		$this->appendResponsePage();
	}
}

