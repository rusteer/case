<?php
class Application_Service_Webflow_MmHelper extends Application_Service_Webflow_AbstractHelper{
	protected function getAgent() {
		return 'NokiaN73-1/2.0628.0.0.1 S60/3.0 Profile/MIDP-2.0 Configuration/CLDC-1.1';
	}
	protected function composeChargeOutput() {
		$this->appendPage('http://a.10086.cn/pams2/m/s.do?c=148&j=l&bUrl=p%3D72&p=72','href="^^">'. $this->webflow->getOption1(). '</a>');
		$this->appendPage('${v1}','form action=\'^\'');
		$this->appendPage('http://a.10086.cn:6060/pams2/s.do?c=211&j=l&mmsType=0&p=72','s.do?gId='. $this->webflow->getFeeCode().'^"',2,'mmsg='. urlencode($this->webflow->getName()));
		$this->appendPage('http://a.10086.cn:6060/pams2/m/s.do?gId='. $this->webflow->getFeeCode().'${v1}','href="^"^s.do~gFeeType~'. $this->webflow->getFeeCode());
		$this->appendPage('${v1}',array(
				'src="^"^validateProgramServlet',
				'form action=\'^\''
		));
		$this->appendPage('${v1}','');
		$this->appendPage('http://119.147.23.195:8080/mi/mmide','',2,'${v1}',false);
		$this->appendPage('${v2}','url=^"',2,'${v1}');
		$this->appendPage('${v1}',array(
				'MIDlet-Jar-URL: ^0x0d',
				'MIDlet-Install-Notify: ^0x0d'
		));
		$this->appendPage('${v1}');
		$this->appendPage('${v2}',null,3,'900 Success');
		$this->appendResponsePage();
	}
}

