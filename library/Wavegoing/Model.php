<?php
/**
 * @author Hike
 * 
 * Provide three basic functions:__set,__get,__setOptions
 *
 */
abstract class Wavegoing_Model{
  
  /**
   * Set property value;
   * 
   * @param string $name
   * @param unknown_type $value
   * @throws Exception
   */
  public function __set($name,$value){
    $method='set' . $name;
    if(!method_exists($this,$method)){throw new Exception('Invalid property');}
    $this->$method($value);
  }
  
  /**
   * Get property value by property name;
   * 
   * @param string $name
   * @throws Exception
   */
  public function __get($name){
    $method='get' . $name;
    if(!method_exists($this,$method)){throw new Exception('Invalid property');}
    return $this->$method();
  }
  
  /**
   * Buntch set property values;
   * 
   * @param array $options
   * @return Wavegoing_Model
   */
  public function setOptions(array $options){
    $methods=get_class_methods($this);
    foreach($options as $key=>$value){
      $method='set' . ucfirst($key);
      if(in_array($method,$methods)){
        $this->$method($value);
      }
    }
    return $this;
  }
}

