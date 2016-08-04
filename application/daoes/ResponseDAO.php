<?php
class Application_Dao_ResponseDAO extends Wavegoing_TableDAO{
    protected $_name='response';
    public function getName(){
        return $this->_name;
    }
    
    /**
	 *
	 * @param integer $userId        	
	 * @param string $bussinessType        	
	 * @param integer $bussinessId        	
	 * @param integer $childId        	
	 * @return multitype:Application_Model_ResponseModel
	 */
    public function getResponses($userId,$bussinessType,$bussinessId){
        return $this->getEntityList($this->select()->where("user_id=$userId")->where('business_type=?',$bussinessType)->where("business_id=$bussinessId"));
    }
    public function getExportData($businessType,$businessId,$from,$to){
        $select="select b.mobile,a.submit_time from response a,user b where a.user_id=b.id and a.business_type='$businessType' and a.business_id=$businessId ";
        if($from){
            $select="$select and a.submit_time>='$from'";
        }
        if($to){
            $select="$select and a.submit_time<='$to'";
        }
        $rowSet=$this->getAdapter()->fetchAll($select);
        $result=array();
        if($rowSet){
            foreach($rowSet as $row){
                $result[]=array(
                        'mobile'=>$row["mobile"],
                        "submit_time"=>$row["submit_time"]);
            }
        }
        return $result;
    }
    public function composeEntity($row){
        $result=new Application_Model_ResponseModel();
        $result->setId($row->id);
        $result->setProvinceId($row->province_id);
        $result->setBusinessId($row->business_id);
        $result->setBusinessType($row->business_type);
        $result->setSubmitTime($row->submit_time);
        $result->setUserId($row->user_id);
        $result->setChildId($row->child_id);
        return $result;
    }
    public function composeRow(Application_Model_ResponseModel $entity){
        return array(
                'id'=>$entity->getId(),
                'province_id'=>$entity->getProvinceId(),
                'business_id'=>$entity->getBusinessId(),
                'business_type'=>$entity->getBusinessType(),
                'submit_time'=>$entity->getSubmitTime(),
                'user_id'=>$entity->getUserId(),
                'child_id'=>$entity->getChildId());
    }
    public function getResponseCountByDate($type,$from,$to,$businessId){
        $result=array();
        if(Zend_Date::isDate($from,"YYYY-MM-dd")&&Zend_Date::isDate($to,"YYYY-MM-dd")){
            $sql="select 
                    COUNT(business_id) as business_count,
                    business_id,
                    DATE_FORMAT(submit_time,'%Y-%m-%d') as business_date 
                  from response  
                  where business_type ='$type'  and business_id=$businessId and submit_time>='".$from."'  and submit_time<='".$to."' 
                  group by business_id,business_date order by business_id,business_date";
            $rows=$this->getAdapter()->fetchAll($sql);
            foreach($rows as $row){
                $result[$row["business_date"]]=$row["business_count"];
            }
        }
        
        return $result;
    }
    public function getResponseCount($type,$from,$to,$provinceId){
        $select=$this->select();
        $select->from($this,array(
                'COUNT(business_id) as business_count',
                'business_id'));
        if($provinceId!=0){
            $select->where("province_id=?",$provinceId);
        }
        $select->where('business_type = ?',$type);
        if($from) $select->where('submit_time >=?',$from);
        if($to) $select->where('submit_time <=?',$to);
        $select->group('business_id');
        $rows=$this->fetchAll($select);
        $result=array();
        foreach($rows as $row){
            $result[$row->business_id]=$row->business_count;
        }
        return $result;
    }
}

