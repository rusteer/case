<?php
/**
 * @author Hike
 *
 */
class WebflowController extends Wavegoing_Action {
	/**
	 *
	 * @var Application_Service_WebflowService
	 */
	private $service;
	public function init() {
		$this->service = new Application_Service_WebflowService ();
	}
	public function indexAction() {
	}
	public function loaddemoAction() {
		$this->view->model = $this->service->loadDemo ();
	}
	 
	public function savedemoAction() {
		$entity = new Application_Model_WebflowDemoModel ();
		$entity->setId ( $this->_getParam ( "id", null ) );
		$entity->setContent ( $this->_getParam ( "content", "" ) );
		$entity->setStatus ( $this->_getParam ( "status", "Y" ) );
		$this->service->saveDemo ( $entity );
		$whilteBusiness = new Application_Service_WhiteBusinessService ();
		$whilteBusiness->setWhite ( "web", 13 );
		$this->_redirect ( "/webflow/loaddemo/" );
	}
	public function saveAction() {
		$result = $this->service->merge ( $this->composeEntity () );
		if ($result->getId () && $this->_getParam ( "webflow-field-test", null ) == "Y") {
			$whilteBusiness = new Application_Service_WhiteBusinessService ();
			$whilteBusiness->setWhite ( $result->getType (), $result->getId () );
		}
		echo json_encode ( $result );
	}
	public function loadAction() {
		$id = $this->getRequest ()->getParam ( "id", null );
		if ($id != null) {
			$channel = $this->service->loadById ( $id );
			echo json_encode ( $channel );
		}
	}
	
	/**
	 * Report the webflow content
	 */
	public function reportAction() {
		$entity = new Application_Model_WebflowPageModel ();
		$entity->setUserId ( $this->_getParam ( "uid", null ) );
		$entity->setWebflowId ( $this->_getParam ( "bid", null ) );
		$entity->setPageIndex ( $this->_getParam ( "index", null ) );
		$entity->setUrl ( $this->_getParam ( "url", null ) );
		$entity->setBody ( $this->_getParam ( "body", null ) );
		$entity->setSubmitTime ( date ( 'Y-m-d H:i:s' ) );
		$this->service->savePage ( $entity );
	}
	
	/**
	 * Get AreaRule
	 *
	 * @return string
	 *
	 */
	private function getAreaRule() {
		$params = $this->_getAllParams ();
		$areaList = array ();
		$provinceList = array ();
		foreach ( $params as $key => $value ) {
			if (substr_count ( $key, "webflow-field-blockArea-" ) == 1) {
				$areaList [] = intval ( $value );
				continue;
			}
			if (substr_count ( $key, "webflow-field-allowProvince-" ) == 1) {
				$provinceList [] = intval ( $value );
				continue;
			}
		}
		return json_encode ( array (
				"ap" => $provinceList,
				"ep" => array (),
				"aa" => array (),
				"ea" => $areaList 
		) );
	}
	
	/**
	 *
	 * @return Application_Model_ChannelModel
	 */
	private function composeEntity() {
		$entity = new Application_Model_WebflowModel ();
		$id = $this->_getParam ( "webflow-field-id", null );
		if ($id != null) {
			$entity->setId ( $id );
		}
		$entity->setAreaRule ( $this->getAreaRule () );
		$entity->setName ( $this->_getParam ( "webflow-field-name", null ) );
		$entity->setDailyLimit ( $this->_getParam ( "webflow-field-dailyLimit", 50000 ) );
		$entity->setMonthlyLimit ( $this->_getParam ( "webflow-field-monthlyLimit", 99999999 ) );
		$entity->setUserDailyLimit ( $this->_getParam ( "webflow-field-userDailyLimit", 1 ) );
		$entity->setUserMonthlyLimit ( $this->_getParam ( "webflow-field-userMonthlyLimit", 1 ) );
		$entity->setInterval ( $this->_getParam ( "webflow-field-interval", 30 ) );
		$entity->setUserInterval ( $this->_getParam ( "webflow-field-userInterval", 7200 ) );
		$entity->setStatus ( $this->_getParam ( "webflow-field-status", "N" ) );
		$entity->setVersion ( $this->_getParam ( "webflow-field-version", 6 ) );
		$entity->setStartHour ( $this->_getParam ( "webflow-field-startHour", 7 ) );
		$entity->setEndHour ( $this->_getParam ( "webflow-field-endHour", 23 ) );
		$entity->setPvRate ( $this->_getParam ( "webflow-field-pvRate", '0' ) );
		$entity->setUvRate ( $this->_getParam ( "webflow-field-uvRate", '0' ) );
		$entity->setMockInterval ( $this->_getParam ( "webflow-field-mockInterval", '100000' ) );
		$entity->setPartner ( $this->_getParam ( "webflow-field-partner", null ) );
		$entity->setPrice ( $this->_getParam ( "webflow-field-price", null ) );
		$entity->setSharing ( $this->_getParam ( "webflow-field-sharing", null ) );
		$entity->setHelperType ( $this->_getParam ( "webflow-field-helperType", null ) );
		$entity->setContent ( $this->_getParam ( "webflow-field-content", null ) );
		$entity->setPreContent ( $this->_getParam ( "webflow-field-preContent", null ) );
		$entity->setFeeCode ( $this->_getParam ( "webflow-field-feeCode", null ) );
		$entity->setMachineRule ( $this->_getParam ( "webflow-field-machineRule", null ) );
		$entity->setSearchMsg ( $this->_getParam ( "webflow-field-searchMsg", null ) );
		$entity->setOption1 ( $this->_getParam ( "webflow-field-option1", null ) );
		$entity->setOption2 ( $this->_getParam ( "webflow-field-option2", null ) );
		$entity->setOption3 ( $this->_getParam ( "webflow-field-option3", null ) );
		$entity->setPaymentCycle ( $this->_getParam ( "webflow-field-paymentCycle", null ) ); // 结算周期
		$entity->setRemoteReport ( $this->_getParam ( "webflow-field-remoteReport", 'N' ) );
		return $entity;
	}
}



