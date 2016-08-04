<?php
class Application_Service_Webflow_ListenHelper extends Application_Service_Webflow_AbstractHelper{
    protected function composePreChargeOutput(){
        $url=$this->webflow->getContent();
        $keyword=$this->webflow->getOption2();
        $preKeyword=$this->webflow->getOption1();
        $postKeyword=$this->webflow->getOption3();
        $this->appendPage($url,array(
                "/iread/wml/l/readbook.jsp^^\">$preKeyword",
                "/iread/wml/l/readbook.jsp^^\">$keyword",
                "/iread/wml/l/readbook.jsp^^\">$postKeyword"));
        $this->appendPage('http://wap.cmread.com/iread/wml/l/readbook.jsp${v1}');
        $this->appendPage('http://wap.cmread.com/iread/wml/l/readbook.jsp${v2}','/iread/wml/l/order.jsp^^">按部购买');
    }
    protected function composeChargeOutput(){
        $this->appendPage('http://wap.cmread.com/iread/wml/l/order.jsp${v1}');
        $this->appendResponsePage();
    }
    protected function composePostChargeOutput(){
        $this->appendPage('http://wap.cmread.com/iread/wml/l/readbook.jsp${v3}');
    }
}

