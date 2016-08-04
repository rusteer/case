<?php
/**
 *
 * Helper for Bbx_W 
 * @author Hike
 *
 */
class Application_Service_Webflow_OnlineDownloadHelper extends Application_Service_Webflow_AbstractHelper{
	protected function getAgent() {
		return 'Nokia7370/2.0 (03.56) Profile/MIDP-2.0 Configuration/CLDC-1.1';
	}
	protected function composePreChargeOutput() {
		$this->appendPage($this->webflow->getOption1(),'redirect_url = ^');
		$this->appendPage('${v1}','go href="^"');
		$this->appendPage('${v1}',array(
				'entry=^0x0e',
				null,
				'pay=^0x0e'
		));
		$this->appendPage('${v1}','href="^^">[确认下载]');
	}
	protected function composeChargeOutput() {
		$this->appendPage('http://g.10086.cn${v1}','ontimer="^"');
		$this->appendPage('${v1}',array(
				'MIDlet-Jar-URL: ^0x0d',
				'MIDlet-Install-Notify: ^0x0d'
		));
		$this->appendPage('${v1}');
		$this->appendPage('${v2}',null,3,'900 Success');
		$this->appendPage('${v3}','status=^0x0e');
		$this->appendPage('http://w.nqkia.com/response/webflow/?id='. $this->webflow->getId(). '&uid='. $this->user->getId(). '&status=${v1}');
	}
}

