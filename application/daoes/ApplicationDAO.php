<?php
class Application_Dao_ApplicationDAO extends Wavegoing_TableDAO{
    protected $_name='application';
    const cacheAllEnabled='application_all_enabled';
    
    /* (non-PHPdoc)
     * @see Wavegoing_TableDAO::composeEntity()
     * 
     */
    public function composeEntity($row){
        $entity=new Application_Model_ApplicationModel();
        $entity->setId($row->id*1);
        $entity->setName($row->name);
        $entity->setUid($row->uid);
        $entity->setPath($row->path);
        $entity->setVersion($row->version*1);
        $entity->setMinUpgradeVersion($row->min_upgrade_version*1);
        $entity->setMaxUpgradeVersion($row->max_upgrade_version*1);
        $entity->setStatus($row->status);
        return $entity;
    }
    
    /**
	 *
	 * @param Application_Model_ApplicationModel $entity        	
	 * @see Wavegoing_TableDAO::composeRow()
	 */
    public function composeRow($entity){
        return array(
                "id"=>$entity->id,
                "name"=>$entity->name,
                "uid"=>$entity->uid,
                "path"=>$entity->path,
                "version"=>$entity->version,
                "min_upgrade_version"=>$entity->minUpgradeVersion,
                "max_upgrade_version"=>$entity->maxUpgradeVersion,
                "status"=>$entity->status);
    }
    /**
     * @return  multitype:Application_Model_ApplicationModel
     */
    public function getEnabledList(){
        return $this->getCachedEntityList(self::cacheAllEnabled,parent::cacheSeconds,$this->select()->where("status=?",'Y'));
    }
}

