<?php

/**
 * Helper for Video
 * @author Hike
 *
 */
class Application_Service_Webflow_ReadingHelper extends Application_Service_Webflow_AbstractHelper{
	
	/**
	 * @param Application_Model_WebflowItemModel $item
	 */
	private function composeItem($item){
		$this->appendPage($item->getUrl());
	}
	
	protected function composePreChargeOutput(){
		$list=$this->dao->getItems($this->webflow->getId());
		foreach ($list as $item){
			if($item->getOption1()=="pre") $this->composeItem($item);
		}
	}
	protected function composeChargeOutput(){
		$this->appendPage($this->webflow->getOption1(),'/iread/^^">确认订购',2);
		$this->appendPage('http://wap.cmread.com/iread/${v1}');
		$this->appendResponsePage();
	}
	protected function composePostChargeOutput(){
		$list=$this->dao->getItems($this->webflow->getId());
		foreach ($list as $item){
			if($item->getOption1()=="post") $this->composeItem($item);
		}
	}
}

