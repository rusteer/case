<?php
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap{
    protected function _initResourceLoader(){
        $this->_resourceLoader->addResourceType('dao','daoes','Dao');
    }
    /**
   * Initialize doc type
   */
    protected function _initDoctype(){
        $this->bootstrap('view');
        $view=$this->getResource('view');
        $view->doctype('XHTML1_STRICT');
    }
    
    /**
   * Initialize memeCached cache.
   */
    protected function _initCache(){
        $options=$this->getOptions();
        if(isset($options['cache'])){
            Zend_Registry::set('cache',Zend_Cache::factory($options['cache']['frontend']['type'],$options['cache']['backend']['type'],$options['cache']['frontend']['options'],$options['cache']['backend']['options']));
        }
    }
    
    /**
   * Initialize logger
   */
    protected function _initLog(){
        $options=$this->getOptions();
        if(isset($options['logger'])){
            $writer=new Zend_Log_Writer_Stream($options['logger']['dir'].'/'.$options['logger']['name'].".".date('Y-m-d').'.log');
            $writer->setFormatter(new Zend_Log_Formatter_Simple('%currentTime% %controller%/%action%,%priorityName%,%message%'.PHP_EOL));
            $logger=new Zend_Log($writer);
            $logger->addFilter((int)$options['logger']['priority']);
            Zend_Registry::set('logger',$logger);
        }
    }
}

