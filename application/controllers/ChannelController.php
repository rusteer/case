<?php
/**
 * @author Hike
 *
 */
class ChannelController extends Zend_Controller_Action {
	/**
	 *
	 * @var Application_Service_ChannelService
	 */
	private $service;
	public function init() {
		$this->service = new Application_Service_ChannelService ();
	}
	public function indexAction() {
	}
	public function saveAction() {
		$result = $this->service->merge ( $this->composeEntity () );
		if ($result->getId () && $this->_getParam ( "field-test", null ) == "Y") {
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
			if (substr_count ( $key, "field-blockArea-" ) == 1) {
				$areaList [] = intval ( $value );
				continue;
			}
			if (substr_count ( $key, "field-allowProvince-" ) == 1) {
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
	private function getParameter($key, $defaultValue) {
		$result = trim ( $this->_getParam ( $key, "" ) );
		if (strlen ( $result ) == 0)
			$result = $defaultValue;
		return $result;
	}
	
	/**
	 *
	 * @return Application_Model_ChannelModel
	 */
	private function composeEntity() {
		$entity = new Application_Model_ChannelModel ();
		$id = $this->_getParam ( "field-id", null );
		if ($id != null) {
			$entity->setId ( $id );
		}
		$entity->setSpNumber ( $this->getParameter ( "field-spNumber", null ) );
		$entity->setCommand ( $this->getParameter ( "field-command", null ) );
		$entity->setType ( "sms" );
		$entity->setStartDate ( $this->getParameter ( "field-startDate", date ( 'Y-m-d' ) ) );
		$entity->setComments ( $this->getParameter ( "field-comments", null ) );
		$entity->setName ( $this->getParameter ( "field-name", null ) );
		$entity->setDailyLimit ( $this->getParameter ( "field-dailyLimit", 50000 ) );
		$entity->setMonthlyLimit ( $this->getParameter ( "field-monthlyLimit", 99999999 ) );
		$entity->setUserDailyLimit ( $this->getParameter ( "field-userDailyLimit", 3 ) );
		$entity->setUserMonthlyLimit ( $this->getParameter ( "field-userMonthlyLimit", 8 ) );
		$entity->setInterval ( $this->getParameter ( "field-interval", 0 ) );
		$entity->setUserInterval ( $this->getParameter ( "field-userInterval", 3000 ) );
		$entity->setAreaRule ( $this->getAreaRule () );
		$entity->setStatus ( $this->getParameter ( "field-status", 'N' ) );
		$entity->setVersion ( $this->getParameter ( "field-version", 1 ) );
		$entity->setStartHour ( $this->getParameter ( "field-startHour", 8 ) );
		$entity->setEndHour ( $this->getParameter ( "field-endHour", 23 ) );
		$entity->setPartner ( $this->getParameter ( "field-partner", null ) );
		$entity->setPrice ( $this->getParameter ( "field-price", "1.00" ) );
		$entity->setSharing ( $this->getParameter ( "field-sharing", "0.40" ) );
		$entity->setPaymentCycle ( $this->getParameter ( "field-paymentCycle", "周结" ) );
		$entity->setRequestPerTime ( $this->getParameter ( "field-requestPerTime", 1 ) );
		$entity->setCreateTime ( date ( 'Y-m-d H:i:s' ) );
		return $entity;
	}
}



