<?php
/**
 * @author Hike
 *
 */
abstract class Wavegoing_TableDAO extends Zend_Db_Table_Abstract{
	const cacheSeconds=120;//120seconds
  /**
   * Fetches one entity in an object of type Wavegoing_Model,
   * or returns null if no row matches the specified criteria.
   *
   * @param string|array|Zend_Db_Table_Select $where  OPTIONAL An SQL WHERE clause or Zend_Db_Table_Select object.
   * @param string|array                      $order  OPTIONAL An SQL ORDER clause.
   * @param int                               $offset OPTIONAL An SQL OFFSET value.
   * @return mixed
   */
  public function getEntity($where=null,$order=null,$offset=null){
    $row=$this->fetchRow($where,$order,$offset);
    if($row) return $this->composeEntity($row);
    return null;
  }
  
  /**
   * @param int $id
   * @return Ambigous <mixed, NULL, Wavegoing_Model,, Zend_Db_Table_Row_Abstract|null,>
   */
  public function loadById($id){
    return $this->getEntity($this->select()->where("id=?",$id));
  }
  
  /**
   * @param string $cacheKey
   * @param int $time
   * @param string $where
   * @param unknown_type $order
   * @param unknown_type $offset
   * @return unknown|Ambigous <NULL, Wavegoing_Model,, Zend_Db_Table_Row_Abstract|null,>
   */
  public function getCachedEntity($cacheKey,$time=null,$where=null,$order=null,$offset=null){
    $cache=Zend_Registry::get("cache");
    if($cache){
      $result=$cache->load($cacheKey);
      if($result) return $result;
      $result=$this->getEntity($where,$order,$offset);
      if(!$time) $time=self::cacheSeconds;
      $cache->save($result,$cacheKey,array($this->_name),$time);
      return $result;
    }
    return $this->getEntity($where,$order,$offset);
  }
  
  /**
   * Fetches all matchable entities from database.
   *
   * Honors the Zend_Db_Adapter fetch mode.
   *
   * @param string|array|Zend_Db_Table_Select $where  OPTIONAL An SQL WHERE clause or Zend_Db_Table_Select object.
   * @param string|array                      $order  OPTIONAL An SQL ORDER clause.
   * @param int                               $count  OPTIONAL An SQL LIMIT count.
   * @param int                               $offset OPTIONAL An SQL LIMIT offset.
   * @return array The entity results per the Zend_Db_Adapter fetch mode.
   */
  public function getEntityList($where=null,$order=null,$count=null,$offset=null){
    $rowSet=$this->fetchAll($where,$order,$count,$offset);
    $result=array();
    if($rowSet){
      foreach($rowSet as $row){
        $result[]=$this->composeEntity($row);
      }
    }
    return $result;
  }
  
  /**
   * Fetches all matchable entities from database. Firstly get from cache,if result is false, then get from database
   *
   * Honors the Zend_Db_Adapter fetch mode.
   *
   * @param string                            $cacheKey
   * @param int                               $time
   * @param string|array|Zend_Db_Table_Select $where  OPTIONAL An SQL WHERE clause or Zend_Db_Table_Select object.
   * @param string|array                      $order  OPTIONAL An SQL ORDER clause.
   * @param int                               $count  OPTIONAL An SQL LIMIT count.
   * @param int                               $offset OPTIONAL An SQL LIMIT offset.
   * @return array The entity results per the Zend_Db_Adapter fetch mode.
   */
  public function getCachedEntityList($cacheKey,$time=null,$where=null,$order=null,$count=null,$offset=null){
    $cache=Zend_Registry::get("cache");
    if($cache){
      $result=$cache->load($cacheKey);
      if($result) return $result;
      $result=$this->getEntityList($where,$order,$count,$offset);
      if(!$time) $time=self::cacheSeconds;
      $cache->save($result,$cacheKey,array($this->_name),$time);
      return $result;
    }
    return $this->getEntityList($where,$order,$count,$offset);
  }
  
  /**
   * Creates entity to database.
   *
   * @param  mixed $entity
   */
  public function createEntity($entity){
  	return $this->insert($this->composeRow($entity));
  }
  
  /**
   * Updates entity to database.
   *
   * @param  string       $cacheKey
   * @param  int          $time
   * @param  mixed        $entity
   * 
   */
  public function updateAndCacheEntity($cacheKey,$time,$entity){
    $this->updateEntity($entity);
    $cache=Zend_Registry::get("cache");
    if($cache){
      if(!$time) $time=self::cacheSeconds;
      $cache->save($entity,$cacheKey,array($this->_name),$time);
    }
  }
  
  /**
   * Updates entity to database.
   *
   * @param  mixed        $entity
   */
  public function updateEntity($entity){
    $this->update($this->composeRow($entity),array('id = ?'=>$entity->getId()));
  }
  
  /**
   * Inserts a new row.
   *
   * @param  array  $data  Column-value pairs.
   * @return mixed         The primary key of the row inserted.
   */
  public function insert(array $data){
    //$this->log(Zend_Json::encode($data),"insert");
    return parent::insert($data);
  }
  
  /**
   * Updates existing rows.
   *
   * @param  array        $data  Column-value pairs.
   * @param  array|string $where An SQL WHERE clause, or an array of SQL WHERE clauses.
   * @return int          The number of rows updated.
   */
  public function update(array $data,$where){
    //$this->log(Zend_Json::encode($data) . "\t" . (Zend_Json::encode($where)),"update");
    return parent::update($data,$where);
  }
  
  /**
   * Fetches one row in an object of type Zend_Db_Table_Row_Abstract,
   * or returns null if no row matches the specified criteria.
   *
   * @param string|array|Zend_Db_Table_Select $where  OPTIONAL An SQL WHERE clause or Zend_Db_Table_Select object.
   * @param string|array                      $order  OPTIONAL An SQL ORDER clause.
   * @param int                               $offset OPTIONAL An SQL OFFSET value.
   * @return Zend_Db_Table_Row_Abstract|null The row results per the
   *     Zend_Db_Adapter fetch mode, or null if no row found.
   */
  public function fetchRow($where=null,$order=null,$offset=null){
    //$this->log((string)$where,"fetchRow");
    return parent::fetchRow($where,$order,$offset);
  }
  
  /**
   * Fetches all rows.
   *
   * Honors the Zend_Db_Adapter fetch mode.
   *
   * @param string|array|Zend_Db_Table_Select $where  OPTIONAL An SQL WHERE clause or Zend_Db_Table_Select object.
   * @param string|array                      $order  OPTIONAL An SQL ORDER clause.
   * @param int                               $count  OPTIONAL An SQL LIMIT count.
   * @param int                               $offset OPTIONAL An SQL LIMIT offset.
   * @return Zend_Db_Table_Rowset_Abstract The row results per the Zend_Db_Adapter fetch mode.
   */
  public function fetchAll($where=null,$order=null,$count=null,$offset=null){
    //$this->log((string)$where,"fetchAll");
    return parent::fetchAll($where,$order,$count,$offset);
  }
  
  /**
   * Compose a Wavegoing_Model instance by given row.
   * 
   * @param Zend_Db_Table_Row_Abstract|null, $row
   * @return Wavegoing_Model, a child of Wavegoing_Model.
   */
  public function composeEntity($row){
    return $row;
  }
  
  /**
   * @param mixed $entity, a instrnace of Wavegoing_Model
   * @return Zend_Db_Table_Row_Abstract|null
   */
  public function composeRow($entity){
    return $entity;
  }
  
  /**
   * Log the message;
   * 
   * @param string $message
   * @param string $action
   */
  private function log($message,$action){
    $logger=Zend_Registry::get('logger');
    if($logger){
      $logger->setEventItem('currentTime',date('Y-m-d H:i:s'));
      $logger->setEventItem('controller',"mysql:" . $this->_name);
      $logger->setEventItem('action',$action);
      $logger->log($message,Zend_Log::INFO);
    }
  }

}

