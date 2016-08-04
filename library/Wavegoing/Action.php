<?php

abstract class Wavegoing_Action extends Zend_Controller_Action{
  /**
   * Record the message in local log files, with priority.
   * 
   * @param string $message
   * @param int $priority
   */
  public function log($message,$priority=Zend_Log::INFO){
    $logger=Zend_Registry::get('logger');
    if($logger){
      $logger->setEventItem('currentTime',date('Y-m-d H:i:s'));
      $logger->setEventItem('controller',$this->_request->getControllerName());
      $logger->setEventItem('action',$this->_request->getActionName());
      $logger->log($message,$priority);
    }
  }
  
  protected function logJsonResult($message){
    $logMessage=array();
    $logMessage["uri"]=$_SERVER['REQUEST_URI'];
    $parameters=array();
    foreach($_REQUEST as $key=>$value){
      $parameters[$key]=$value;
    }
    $logMessage["parameters"]=$parameters;
    $logMessage["result"]=$message;
    $this->log($this->customJsonEncode($logMessage));
  }
  
  protected function customJsonEncode($a=false){
    if(is_null($a)) return 'null';
    if($a === false) return 'false';
    if($a === true) return 'true';
    if(is_scalar($a)){
      if(is_float($a)) return floatval(str_replace(",",".",strval($a)));
      if(is_string($a)){
        static $jsonReplaces=array(array("\\","/","\n","\t","\r","\b","\f",'"'),array('\\\\','\\/','\\n','\\t','\\r','\\b','\\f','\"'));
        return '"' . str_replace($jsonReplaces[0],$jsonReplaces[1],$a) . '"';
      }else
        return $a;
    }
    
    $isList=true;
    for($i=0,reset($a);$i < count($a);$i++,next($a)){
      if(key($a) !== $i){
        $isList=false;
        break;
      }
    }
    
    $result=array();
    if($isList){
      foreach($a as $v)
        $result[]=$this->customJsonEncode($v);
      return '[' . join(',',$result) . ']';
    }else{
      foreach($a as $k=>$v)
        $result[]=$this->customJsonEncode($k) . ':' . $this->customJsonEncode($v);
      return '{' . join(',',$result) . '}';
    }
  }
}