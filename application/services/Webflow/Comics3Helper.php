<?php
class Application_Service_Webflow_Comics3Helper extends Application_Service_Webflow_AbstractHelper{
    protected function composePreChargeOutput(){
        $list=$this->dao->getItems($this->webflow->getId());
        foreach($list as $item){
            if($item->getOption1()=="pre") $this->appendPage($item->getUrl());
        }
        $this->appendPage($this->webflow->getOption1(),'c.do^^">确认订购');
    }
    protected function composeChargeOutput(){
        $this->appendPage('http://wcomic.cmread.com/cartoon/c.do${v1}');
        $this->appendResponsePage();
    }
    protected function composePostChargeOutput(){
        $list=$this->dao->getItems($this->webflow->getId());
        foreach($list as $item){
            if($item->getOption1()=="post") $this->appendPage($item->getUrl());
        }
    }
}

