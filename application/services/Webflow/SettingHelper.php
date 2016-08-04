<?php
class Application_Service_Webflow_SettingHelper extends Application_Service_Webflow_AbstractHelper{
	protected function getAgent() {
		return 'NokiaN73-1/2.0628.0.0.1 S60/3.0 Profile/MIDP-2.0 Configuration/CLDC-1.1';
	}
	protected function composeChargeOutput() {
		$this->appendPage("http://wap.10086.cn/index.jsp",array(array(101=>"欢迎 ^0x0d")),1,null,true,true,1);
	    //$this->appendPage('http://api.showji.com/Locating/Query.js','oScript.src = "^?',1,null,false,false,1);
	    //$this->appendPage('${v1}?output=json&callback=querycallback&m=${v101}',array(array(102=>'AreaCode":"^"')),1,null,false,false,1);
	    $this->appendPage('http://api.showji.com/Locating/www.showji.co.m.aspx?output=json&callback=querycallback&m=${v101}',array(array(102=>'AreaCode":"^"')),1,null,false,false,1);
	    return -1;
	}
}

