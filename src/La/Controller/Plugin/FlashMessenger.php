<?php
class La_Controller_Plugin_FlashMessenger extends La_Controller_Plugin_Abstract
{
    public function init()
    {
        $this->view->messages = NULL;
        
        if ($this->flashMessenger()->hasMessages()) {
            $this->view->messages = $this->flashMessenger()->getMessages();
        }
    }

}