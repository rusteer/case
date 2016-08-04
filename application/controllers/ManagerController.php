<?php
class ManagerController extends Zend_Controller_Action {
	/**
	 *
	 * @var Zend_Session_Namespace
	 */
	private $authNamespace;
	public function init() {
		$this->authNamespace = new Zend_Session_Namespace ( 'Zend_Auth' );
	}
	public function indexAction() {
	}
	public function clearwhiteAction() {
	}
	
	/**
	 * Svn Update
	 */
	public function svnupdateAction() {
		if (! $this->authNamespace->admin) {
			$this->_redirect ( "/security/input/?target=" . urlencode ( "/manager/svnupdate/" ) );
			return;
		}
		/**
		 * /var/www/.subversion/servers
		 * [global]
		 * store-plaintext-passwords = no/yes
		 */
		$this->view->result = exec ( "svn update /var/www/case/ --username hike --password svnpass!23" );
	}
}







