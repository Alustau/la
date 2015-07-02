<?php

class La_View_Helper_FlashMessenger extends Zend_View_Helper_Abstract
{
    protected $messages;
    
    public function flashMessenger() 
    {
        $this->messages = $this->view->messages ? $this->view->messages : [];
        return $this;
    }
    
    public function __toString() 
    {
        $html  = "<script>";
        $html .= "$(function() {";
        
        foreach ($this->messages as $data) {
            $html .= $data['msg'] 
                   ? 'app.message("'.$data['type'].'", "'. $data['msg'].'");' 
                   : '';
        }
        
        $html .= "});";
        $html .= "</script>";
        
        return $html;
    }
}
