<?php

class La_Controller_Action_Helper_Delete extends Zend_Controller_Action_Helper_Abstract 
{
    /**
     * 
     * @param La_Db_Table $table
     */
    public function direct(La_Db_Table $table = null, $redirectUrl = null)
    {
        $controller = $this->getActionController();
        $data       = $this->getRequest()->getParams();
        $table      = $table ?: $controller->table;
        $url        = sprintf('%s/%s/index/parent_id/%s/table/%s', $data['module'], 
                                                                   $data['controller'], 
                                                                   $data['parent_id'], 
                                                                   $table->getName());
        if (!$table) {
            $table = $controller->table;
        }
        
        if ($redirectUrl) {
            $url = $redirectUrl;
        }
        
        $id = $data['id'];
        
        if ($id) {
            $ids = (array) $id;
            
            try{
                foreach ($ids as $id) {
                    $where = array('id = ?' => Zend_Filter::filterStatic($id, 'int'));
                    $table->logicDelete($where);
                }
                
                $controller->getHelper('flashMessenger')->addMessage([
                    'type' => 'success',
                    'msg'  => 'Registro(s) deletado(s) com sucesso.'
                ]);
                
                $controller->redirect($url);
            } catch (Exception $e) {
                $controller->getHelper('flashMessenger')->addMessage([
                    'type' => 'error',
                    'msg'  => 'O registro não foi excluído.'
                            . ' Verifique os dados e tente novamente.'
                ]);
                $controller->redirect($url);
            }
        }
        
        $controller->getHelper('flashMessenger')->addMessage([
            'type' => 'error',
            'msg'  => 'O registro não foi excluído.'
                    . ' Verifique os dados e tente novamente.'
        ]);
        $controller->redirect($url);
    }
}