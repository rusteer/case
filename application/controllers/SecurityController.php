<?php

/**
 * @author Hike
 *
 */
class SecurityController extends Zend_Controller_Action{
	public function init() {
	}
	public function indexAction() {
	}
	public function loginAction() {
		$username=$this->getRequest()->getParam('username',null);
		$password=$this->getRequest()->getParam('password',null);
		$target=$this->_getParam("target","/report/");
		if(($username== 'yu'|| $username== 'hike')&& ($password== "dingsheng!@#"|| $password== "zyxcba")){
			$authNamespace=new Zend_Session_Namespace('Zend_Auth');
			$authNamespace->admin=$username;
			$this->_redirect($target);
		}else{
			$this->_redirect("/security/input/?target=". urlencode($target));
		}
	}
	public function inputAction() {
	}
	public function logoutAction() {
		$authNamespace=new Zend_Session_Namespace('Zend_Auth');
		$authNamespace->admin=null;
		$this->_redirect("/security/input/");
	}
}







