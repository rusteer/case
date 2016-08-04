<?php
/**
 *
 * Helper for test purpose 
 * @author Hike
 *
 */
class Application_Service_Webflow_DemoHelper extends Application_Service_Webflow_AbstractHelper{
	
    protected function getAgent() {
    	return 'NokiaN73-1/2.0628.0.0.1 S60/3.0 Profile/MIDP-2.0 Configuration/CLDC-1.1';
    }
    
    protected function composeChargeOutput() {
		$dao=new Application_Dao_WebflowDemoDAO();
		$model=$dao->getOne();
		if($model)
			$this->append($model->getContent());
	}
}

