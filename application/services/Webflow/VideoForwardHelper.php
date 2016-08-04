<?php

/**
 * Helper for Video
 * @author Hike
 *
 */
class Application_Service_Webflow_VideoForwardHelper extends Application_Service_Webflow_MultiItemHelper{
	protected function composeItemPreChargeOutput($item) {
		$link=$item->getUrl();
		if(strlen($this->webflow->getOption1())> 0){
			$this->appendPage($link,$this->webflow->getOption1());
			$link='${v1}';
		}
	    $this->appendPage($link,'href="^"');
		$this->appendPage('${v1}',$this->webflow->getOption2());
	}
	protected function composeItemChargeOutput($item) {
		$this->appendPage();
	}
}

