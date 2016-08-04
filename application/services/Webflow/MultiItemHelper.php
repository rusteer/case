<?php

/**
 * Helper for 
 * @author Hike
 *
 */
abstract class Application_Service_Webflow_MultiItemHelper extends Application_Service_Webflow_AbstractHelper{
    private $targetItem;
    protected abstract function composeItemPreChargeOutput($item);
    protected abstract function composeItemChargeOutput($item);
    protected function composePreChargeOutput(){
        $list=$this->dao->getItems($this->webflow->getId());
        if(count($list)>0) $this->targetItem=$list[rand()%count($list)];
        if($this->targetItem) $this->composeItemPreChargeOutput($this->targetItem);
    }
    protected function composeChargeOutput(){
        if($this->targetItem){
            $this->composeItemChargeOutput($this->targetItem);
            $this->appendResponsePage($this->targetItem);
        }else{
            return -1;
        }
    }
}

