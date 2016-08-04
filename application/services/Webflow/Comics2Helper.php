<?php
class Application_Service_Webflow_Comics2Helper extends Application_Service_Webflow_MultiItemHelper{
	protected function composeItemPreChargeOutput($item) {
	    $this->appendPage($item->getUrl(),'/portalone/^^/prePalyOnlineRead');
		$this->appendPage('http://wap.dm.10086.cn:80/portalone/${v1}/prePalyOnlineRead','/portalone/^^/contentoperate/playResult');
	
	}
	protected function composeItemChargeOutput($item) {
		$this->appendPage('http://wap.dm.10086.cn:80/portalone/${v1}/contentoperate/playResult');
	}
}

