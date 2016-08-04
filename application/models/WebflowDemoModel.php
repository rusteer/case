<?php
class Application_Model_WebflowDemoModel extends Wavegoing_Model{
	public $id;
	public $content;
	public $status;
	public function getId() {
		return $this->id;
	}
	public function getContent() {
		return $this->content;
	}
	public function getStatus() {
		return $this->status;
	}
	public function setId($id) {
		$this->id=$id;
	}
	public function setContent($content) {
		$this->content=$content;
	}
	public function setStatus($status) {
		$this->status=$status;
	}
}

