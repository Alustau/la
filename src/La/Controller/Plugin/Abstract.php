<?php

abstract class La_Controller_Plugin_Abstract extends Zend_Controller_Plugin_Abstract
{
    protected $view;
    protected $request;
    protected $module;
    protected $controller;
    protected $action;
    
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        $this->request = $request;
        
        $this->module     = $this->request->getModuleName();
        $this->controller = $this->request->getControllerName();
        $this->action     = $this->request->getActionName();
        
        $this->view = Zend_Controller_Action_HelperBroker
                ::getStaticHelper('ViewRenderer')->view;
        
        $this->init();
    }
    
    public function __call($name, $arguments) 
    {
        return $this->getHelper(ucfirst($name));
    }
    
    protected function getHelper($name) 
    {
        return Zend_Controller_Action_HelperBroker::getStaticHelper($name);
        
    }


    public function addScript($src) 
    {
        $this->view->headScript()->appendFile($src);
        return $this;
    }
    
    public function addCss($src) 
    {
        $this->view->headLink()->appendStylesheet($src);
        return $this;
    }
    
    abstract public function init();
}
