<?php
class Application_Dao_WebflowPageDAO extends Wavegoing_TableDAO{
    protected $_name='webflow_page';
    public function composeRow($entity){
        return array(
                "id"=>$entity->getId(),
                "user_id"=>$entity->getUserId(),
                "webflow_id"=>$entity->getWebflowId(),
                "page_index"=>$entity->getPageIndex(),
                "url"=>$entity->getUrl(),
                "submit_time"=>$entity->getSubmitTime());
    }
    public function composeEntity($row){
        $result=new Application_Model_WebflowPageModel();
        $result->setId($row->id*1);
        $result->setUserId($row->user_id);
        $result->setWebflowId($row->webflow_id);
        $result->setPageIndex($row->page_index);
        $result->setUrl($row->url);
        $result->setSubmitTime($row->submit_time);
        return $result;
    }
}

