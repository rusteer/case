<?php

/**
 * 
 * Helper for Customized flow.
 * @author Hike
 *
 */
class Application_Service_Webflow_Custom19Helper extends Application_Service_Webflow_AbstractHelper{
	protected function composeChargeOutput() {
		$list=$this->dao->getItems($this->webflow->getId());
		$item=$list[rand()% count($list)];
		$this->appendPage('http://112.25.8.228:8001/wap/login.ashx','func.jsp^^?f='. $item->getOption1());
		$this->appendPage('http://112.25.8.228/wgame/func.jsp${v1}?f='. $item->getOption1());
		$this->appendResponsePage($item);
	}
}

