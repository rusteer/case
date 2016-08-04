<?php
class Application_Service_Webflow_ContentHelper extends Application_Service_Webflow_AbstractHelper{
	/*protected function composePreChargeOutput(){
		if(!empty($this->webflow->getPreContent())){
			$this->append($this->webflow->getPreContent());
		}
	}*/
	protected function composeChargeOutput(){
		$this->append($this->webflow->getContent());
		$this->appendResponsePage();
	}
}

