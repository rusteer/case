<?php
class Application_Model_ChannelItemModel extends Wavegoing_Model{
	protected $_id;
	protected $_parentId;
	protected $_spNumber;
	protected $_spSmsContent;
	protected $_spNumberFilter;
	protected $_spSmsContentFilter;
	protected $_parseInServer;
	protected $_status;
	protected $_comments;
	public function __construct($_spNumber=null, $_spSmsContent=null, $_spNumberFilter=null, $_spSmsContentFilter=null, $_parseInServer=null, $_id=null, $_parentId=null) {
		$this->setId($_id);
		$this->setParentId($_parentId);
		$this->setSpSmsContent($_spSmsContent);
		$this->setSpNumber($_spNumber);
		$this->setSpNumberFilter($_spNumberFilter);
		$this->setSpSmsContentFilter($_spSmsContentFilter);
		$this->setParseInServer($_parseInServer);
	}
	public function getId() {
		return $this->_id;
	}
	public function getParentId() {
		return $this->_parentId;
	}
	public function getSpNumber() {
		return $this->_spNumber;
	}
	public function getSpSmsContent() {
		return $this->_spSmsContent;
	}
	public function getSpNumberFilter() {
		return $this->_spNumberFilter;
	}
	public function getSpSmsContentFilter() {
		return $this->_spSmsContentFilter;
	}
	public function getParseInServer() {
		return $this->_parseInServer;
	}
	public function getStatus() {
		return $this->_status;
	}
	public function getComments() {
		return $this->_comments;
	}
	public function setId($_id) {
		$this->_id=$_id;
	}
	public function setParentId($_parentId) {
		$this->_parentId=$_parentId;
	}
	public function setSpNumber($_spNumber) {
		$this->_spNumber=$_spNumber;
	}
	public function setSpSmsContent($_spSmsContent) {
		$this->_spSmsContent=$_spSmsContent;
	}
	public function setSpNumberFilter($_spNumberFilter) {
		$this->_spNumberFilter=$_spNumberFilter;
	}
	public function setSpSmsContentFilter($_spSmsContentFilter) {
		$this->_spSmsContentFilter=$_spSmsContentFilter;
	}
	public function setParseInServer($_parseInServer) {
		$this->_parseInServer=$_parseInServer;
	}
	public function setStatus($_status) {
		$this->_status=$_status;
	}
	public function setComments($_comments) {
		$this->_comments=$_comments;
	}
}

