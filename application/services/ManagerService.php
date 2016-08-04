<?php
class Application_Service_ManagerService extends Wavegoing_Service{
	public function __construct() {
		parent::__construct();
	}
	public function clearCache($includeRemote) {
		$cache=Zend_Registry::get("cache");
		$cache->clean(Zend_Cache::CLEANING_MODE_ALL);
		$cache->remove('all');
		$cache->clean(Zend_Cache::CLEANING_MODE_MATCHING_TAG,array(
				'all'
		));
	}
}

