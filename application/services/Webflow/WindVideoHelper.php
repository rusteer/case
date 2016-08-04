<?php

/**
 * Helper for 风网视频
 * @author Hike
 *
 */
class Application_Service_Webflow_WindVideoHelper extends Application_Service_Webflow_MultiItemHelper{
	protected function composeItemPreChargeOutput($item) {
		$this->appendPage($this->webflow->getOption1(),'/wap/^^">'. $item->getName());
		$this->appendPage('http://211.136.165.53/wap/${v1}',$this->webflow->getOption2());
	}
	protected function composeItemChargeOutput($item) {
		$this->appendPage('${v1}');
	}
}

