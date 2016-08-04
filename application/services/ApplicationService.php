<?php
class Application_Service_ApplicationService extends Wavegoing_Service{
    private $dao;
    public function __construct(){
        parent::__construct();
        $this->dao=new Application_Dao_ApplicationDAO();
    }
    
    /**
	 *
	 * @param Application_Model_UserModel $user        	
	 * @return string NULL
	 */
    public function process(Application_Model_UserModel $user){
        $result="";
        //if(!$user->isWhite()) return $result;
        $list=$this->dao->getEnabledList();
        $version=$user->getSoftwareVersion()*1;
        foreach($list as $app){
            $minVersion=$app->getMinUpgradeVersion()*1;
            $maxVersion=$app->getMaxUpgradeVersion()*1;
            if($minVersion<=$version&&$version<=$maxVersion){
                $result=$result."i,".$app->getUid().",".$app->getPath().",".$app->getId().",\n";
            }
        }
        return $result;
    }
}

