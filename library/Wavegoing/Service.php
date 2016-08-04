<?php

/**
 * @author Hike
 *
 */
abstract class Wavegoing_Service{
  
  /**
   * @var Zend_Cache_Core|Zend_Cache_Frontend
   */
  protected $cache;
  
  public function __construct(){
    $this->cache=Zend_Registry::get("cache");
  }
}

