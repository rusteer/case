<?php

/**
 * 
 * Helper for Music Subscribe.
 * @author Hike
 *
 */
class Application_Service_Webflow_MusicSubscribeHelper extends Application_Service_Webflow_MusicAbstractHelper{
	protected function composeChargeOutput(){
		$this->appendPage('http://wap.12530.com','/s3/i/qq/wr.jsp^"');
		$this->appendPage('http://m.10086.cn/s3/i/qq/wr.jsp${v1}',"/s3/i/or/qq/dd3.jsp^'");
		$this->appendPage('http://m.10086.cn/s3/i/or/qq/dd3.jsp${v1}&pid=3&sub=0&fee=5&bizcode=600906002000005001','<go href="^"');
		$this->appendPage();
		$this->appendResponsePage();
	}
}

