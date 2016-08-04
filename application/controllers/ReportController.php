<?php
/**
 * @author Hike
 *
 */
class ReportController extends Wavegoing_Action{
	protected $userBusiness;
	protected $authNamespace;
	public function init() {
		$this->userBusiness=new Application_Service_UserService();
		$this->authNamespace=new Zend_Session_Namespace('Zend_Auth');
	}
	protected function checkAuthorized() {
		if($this->authNamespace->admin)
			return true;
		$this->view->result="logout";
		return false;
	}
	public function indexAction() {
		if( ! $this->authNamespace->admin)
			$this->_redirect("/security/input/?target=". urlencode($_SERVER["REQUEST_URI"]));
		$this->view->provinceId=$this->_getParam("provinceId",0);
		$this->view->from=$this->_getParam("from",date('Y-m-d'));
		$this->view->to=$this->_getParam("to",date('Y-m-d'));
		$this->view->tabId=$this->_getParam("tabId","channel");
		$configService=new Application_Service_ConfigService();
		$provinces=$configService->getAllowedProvinces(false);
		$result=array();
		$allProvince=new Application_Model_ProvinceModel();
		$allProvince->setId(0);
		$allProvince->setName("综合");
		$result[]=$allProvince;
		foreach($provinces as $province){
			$result[]=$province;
		}
		$this->view->provinces=$result;
	}
	public function exportAction() {
		if($this->checkAuthorized()){
			header("Content-Type: application/vnd.ms-excel");
			header("Content-Disposition: attachment; filename=export.csv");
			header("Pragma: no-cache");
			header("Expires: 0");
			echo "mobile,time\n";
			$businessType=$this->_getParam("type",'music');
			$businessId=$this->_getParam("id",4);
			$from=$this->_getParam("from",'2012-01-01');
			$to=$this->_getParam("to",null);
			if($businessType!= null&& $businessId!= null){
				$service=new Application_Service_ResponseService();
				$list=$service->getExportData($businessType,$businessId,$from,$to);
				foreach($list as $record){
					echo $record['mobile']. ",". $record['submit_time']. "\n";
				}
			}
		}
	}
	public function userAction() {
		if($this->checkAuthorized()){
			$from=$this->getRequest()->getParam("from",null);
			$to=$this->getRequest()->getParam("to",null);
			$provinceId=$this->_getParam("provinceId",0);
			echo json_encode($this->userBusiness->getReport($from,$to,1,null,$provinceId));
		}
	}
	public function channelAction() {
		if($this->checkAuthorized()){
			$from=$this->getRequest()->getParam("from",null);
			$to=$this->getRequest()->getParam("to",null);
			$channelBusiness=new Application_Service_ChannelService();
			$this->view->result=$channelBusiness->getReport($from,$to,$this->_getParam("provinceId",0));
		}
	}
	public function webflowAction() {
		if($this->checkAuthorized()){
			$from=$this->getRequest()->getParam("from",null);
			$to=$this->getRequest()->getParam("to",null);
			$webflowBusiness=new Application_Service_WebflowService();
			$this->view->result=$webflowBusiness->getReport($from,$to,$this->_getParam("provinceId",0));
		}
	}
}