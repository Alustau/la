<?php

class La_View_Helper_Altabs extends Zend_View_Helper_Abstract
{
    /**
     *
     * @var int 
     */
    protected $_id;
    
    /**
     *
     * @var array 
     */
    protected $tab = [];
    
    /**
     *
     * @var array 
     */
    protected $namespace = "default";
    
    /**
     *
     * @var array 
     */
    protected $tabId = "";

    /**
     * 
     * @return \La_View_Helper_Altabs 
     */
    public function altabs($tabId)
    {
        $this->tabId = $tabId;
        
        $this->_id = $this->view->id ? $this->view->id : null;
        return $this;
    }

    /**
     * @return \La_View_Helper_Altabs 
     */
    public function setNamespace($name)
    {
        $this->namespace = $name;
        return $this; 
    }

    /**
     * 
     * @return int
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * 
     * @return int
     */
    public function setId($id)
    {
        $this->_id = $id;
        return $this; 
    }
    
    protected function prev() 
    {
        $html  = '<li class="prev-button">';
        $html .= '<a href="javascript:;" data-click="prev-tab" class="text-inverse">';
        $html .= '<i class="fa fa-arrow-left"></i>';
        $html .= '</a>';
        $html .= '</li>';
        return $html; 
    }
    
    protected function next() 
    {
        $html  = '<li class="next-button">';
        $html .= '<a href="javascript:;" data-click="next-tab" class="text-inverse">';
        $html .= '<i class="fa fa-arrow-right"></i>';
        $html .= '</a>';
        $html .= '</li>';
        
        return $html; 
    }
    
    private function href(array $attr) 
    {
        if (!isset($attr['data-type'])) {
            if (!$this->countTab()) {
                return "tabs-main-" . $this->namespace;
            }
            
            return "tabs-parent-" . $this->namespace;
        }
        
        return "tabs-" . $attr['data-type'] . "-" . $this->namespace;
    }
    
    protected function countTab() 
    {
        return count($this->tab);
    }


    public function tab($name, array $attr = []) 
    {
        if (!isset($attr['action']) && $this->countTab()) {
            throw new Exception('That tab requires an action to send a request');
        }
        
        $html  = "<li class='". (isset($attr['active']) && $attr['active'] ? "active" : "")."'>";
        $html .= "<a data-toggle='tab' data-action='".
                (isset($attr['action']) && $attr['action'] ? $attr['action'] : "")
                ."' href='#{$this->href($attr)}' {$this->renderAttr($attr)}>";
        $html .= $name;
        $html .= "</a>";
        $html .= "</li>";
        
        if ($this->_id || !$this->countTab()) {
            $this->tab[] = $html;
            return $this;
        }
        
        return $this;
    }
    
    private function renderAttr(array $attr = [])
    {
        $html = "";
        
        if (!$attr) {
            return $html;
        }
        
        foreach ($attr as $prop => $value) {
            if ($prop == 'action' || $prop == 'active') {
                continue;
            }
            
            $html .= $prop."='". $value."' ";
        }
        
        
        return $html;
    }
    
    protected function _renderTabs() 
    {
        $html = "";
        
        if (!$this->tab) {
            return $html;
        }
        
        foreach ($this->tab as $tab) {
            $html .= $tab;
        }
        
        return $html;
    }
    
    public function __toString()
    {
        $html  = '<ul class="nav nav-tabs" data-namespace="' . $this->namespace . '">';
        $html .= $this->prev();
        
        $html .= $this->_renderTabs();
        
        $html .= $this->next();
        $html .= '</ul>';
        
        return $html;
    }
}