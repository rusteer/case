<?php
/**
 * @author Hike
 *
 */
class OrderController extends Wavegoing_Action {
	const businessSplitter = "\n@@@@@@\n";
	/**
	 *
	 * @var Application_Service_UserService
	 */
	private $userService;
	public function init() {
		$this->userService = new Application_Service_UserService ();
	}
	private function isBusinessTime() {
		return true;
		// return (date('G')) * 1 >= 7;
	}
	private function getSmsOrder($user) {
		$result = "";
		$businessParam = $this->_getParam ( "business", null );
		if ($businessParam == "sms" || $businessParam == null) {
			$channelBusiness = new Application_Service_ChannelService ();
			$result = $channelBusiness->process ( $user );
		}
		return $result;
	}
	private function getWebOrder($user) {
		$result = "";
		if (! $this->isOldVersion ()) {
			$businessParam = $this->_getParam ( "business", null );
			if ($businessParam == "web" || $businessParam == null) {
				$webflowBusiness = new Application_Service_WebflowService ();
				$result = $webflowBusiness->process ( $user );
			}
		}
		return $result;
	}
	
	/**
	 * In the old version software, no mobile will passed through parameters,
	 * only pass a parameter "a", where 10 means Hangzhou,11 means henan.
	 *
	 * Also no webflow or application logic support.
	 *
	 * @return boolean
	 */
	private function isOldVersion() {
		return $this->getRequest ()->getParam ( "oldversion", null ) == 1;
	}
	private function getAppOrder($user) {
		$result = "";
		if (! $this->isOldVersion ()) {
			$businessParam = $this->_getParam ( "business", null );
			if ($businessParam == "app" || $businessParam == null) {
				$service = new Application_Service_ApplicationService ();
				$result = $service->process ( $user );
			}
		}
		return $result;
	}
	private function getSplitter() {
		if ($this->_getParam ( "business", null ) != null)
			return "";
		return self::businessSplitter;
	}
	public function indexAction() {
		if (! $this->isBusinessTime ())
			return;
		$user = $this->loadUser ();
		if ($user == null)
			return;
		if ($user->isBlack ())
			$this->log ( 'Black user comming:' . $user->getMobile () );
		$result = "";
		$result = $result . $this->getSmsOrder ( $user );
		$result = $result . $this->getSplitter ();
		//TODO, uncomment below to enable web order
		//$result = $result . $this->getWebOrder ( $user );
		$result = $result . $this->getSplitter ();
		//TODO, uncomment below to enable app order
		//$result = $result . $this->getAppOrder ( $user );
		$this->logJsonResult ( $result );
		echo $result;
	}
	private function getVendor($vendor, $mobile) {
		if ($vendor != null && strpos ( $vendor, "(" ) > 0) {
			$vendor = substr ( $vendor, 0, strpos ( $vendor, "(" ) );
		}
		// ---一切随缘,扣量,开始---------
		if ($vendor == '13') {
			$hour = (date ( 'G' )) * 1;
			// $rateBase=($hour==8||$hour==9)?20:10;
			$rateBase = 10;
			// if($hour>=20||$hour<=7) $rateBase=4;
			// echo "$rateBase\n";
			if (rand () % $rateBase == 0)
				$vendor = $vendor . "-" . $rateBase;
		}
		// ---一切随缘,扣量,结束---------
		
		// ---Check if black user start-----
		if ($mobile && $this->userService->isBlackUser ( $mobile )) {
			$vendor = $vendor . "(Black)";
		}
		// ---Check if black user end-----
		return $vendor;
	}
	
	/**
	 *
	 * @return Application_Model_UserModel null
	 */
	private function loadUser() {
		if ($this->isOldVersion ()) {
			$user = new Application_Model_UserModel ();
			$user->setImei ( $this->getRequest ()->getParam ( 'e', null ) );
			$user->setImsi ( $this->getRequest ()->getParam ( 's', null ) );
			$areaCode = 571; // 杭州市
			if ($this->getRequest ()->getParam ( 'a', null ) == 11)
				$areaCode = 394; // 周口市
			$user->setAreaCode ( $areaCode );
			$user->setMobile ( $user->getImsi () );
			$user->setSoftwareVersion ( 1 );
			$user->setVendor ( 'none' );
			return $this->userService->loadUser ( $user );
		}
		$imei = $this->getRequest ()->getParam ( 'imei', null );
		if ($imei) {
			$user = new Application_Model_UserModel ();
			$mobile = $this->getRequest ()->getParam ( 'phoneNumber', null );
			$user->setSoftwareVersion ( $this->getRequest ()->getParam ( 'version', null ) );
			$user->setImei ( $imei );
			$user->setImsi ( $this->getRequest ()->getParam ( 'imsi', null ) );
			$user->setMachineUid ( $this->getRequest ()->getParam ( 'machineUid', null ) );
			$user->setMobile ( $mobile );
			$user->setAreaCode ( $this->getRequest ()->getParam ( 'areaCode', 0 ) * 1 );
			$vendor=$this->_getParam("p",null);
			$user->setVendor ( $this->getVendor ( $vendor,$mobile ) );
			return $this->userService->loadUser ( $user );
		}
		$parameter = $this->getRequest ()->getParam ( 'a', null );
		if ($parameter) {
			$list = explode ( "ooo", $parameter );
			$count = count ( $list );
			if ($count >= 7) {
				$user = new Application_Model_UserModel ();
				$index = 0;
				$user->setImei ( $list [0] );
				$user->setImsi ( $list [1] );
				$user->setMachineUid ( $list [2] );
				$user->setSoftwareVersion ( $list [3] );
				$appChannel = $list [4];
				$mobile = $list [5];
				$user->setMobile ( $mobile );
				$user->setVendor ( $this->getVendor ( $appChannel, $mobile ) );
				$user->setAreaCode ( $list [6] );
				//$this->logJsonResult ( $user );
				$user= $this->userService->loadUser ( $user );
				if($user){
					$user->noCommonChannelItems=true;
					return $user;
				}
			}
		}
		return null;
		// imeioooimsioooGetMachineUIdoooKVersionoooiAppChanneloooiPhoneNumberoooiAreaCode
		// 0,imei;
		// 1,imsi,2,macheinUI,3,version,4,appchannel,5,phonenumber,6,areacode
	}
}

