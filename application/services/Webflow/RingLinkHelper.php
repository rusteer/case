<?php

/**
 * 
 * Helper for Ring.
 * @author Hike
 *
 */
class Application_Service_Webflow_RingLinkHelper extends Application_Service_Webflow_MultiItemHelper{
    protected function getAgent(){
        return 'NokiaN73-1/2.0628.0.0.1 S60/3.0 Profile/MIDP-2.0 Configuration/CLDC-1.1';
    }
    protected function composeItemPreChargeOutput($item){
        $this->appendPage($item->getUrl(),"/s3/i/or/rt/^^'>快速下载MP3高潮版");
    }
    protected function composeItemChargeOutput($item){
        $this->appendPage('http://m.10086.cn/s3/i/or/rt/${v1}','go href="^"');
        $this->appendPage('${v1}');
    }
}

