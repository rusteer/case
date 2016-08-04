<?php
class Application_Dao_ResponseMoDAO extends Wavegoing_TableDAO{
    protected $_name='response_mo';
    public function getName(){
        return $this->_name;
    }
    /**
     * @param string $linkId
     * @return Application_Model_ResponseMoModel|NULL
     */
    public function getMoByLinkId($linkId){
        $select=$this->select()->where("link_id=?",$linkId);
        return $this->getEntity($select);
    }
    public function composeEntity($row){
        $entity=new Application_Model_ResponseMoModel();
        $entity->setId($row->id);
        $entity->setLinkId($row->link_id);
        $entity->setMobile($row->mobile);
        $entity->setSpNumber($row->sp_number);
        $entity->setMsg($row->msg);
        $entity->setServiceId($row->service_id);
        $entity->setSubmitTime($row->submit_time);
        return $entity;
    }
    public function composeRow(Application_Model_ResponseMoModel $entity){
        return array(
                'id'=>$entity->getId(),
                'link_id'=>$entity->getLinkId(),
                'mobile'=>$entity->getMobile(),
                'sp_number'=>$entity->getSpNumber(),
                'msg'=>$entity->getMsg(),
                'service_id'=>$entity->getServiceId(),
                'submit_time'=>$entity->getSubmitTime());
    }
}

