<?php

class Neo_Controller_Action_Helper_Auth 
    extends Zend_Controller_Action_Helper_Abstract
{
    public function preDispatch()
    {
        $module = $this->getRequest()->getModuleName();
        if ( $module === 'backend' ){
            $auth = Zend_Auth::getInstance();
            
            if ($auth->hasIdentity()) {
                
            } else {
                $message = Zend_Controller_Action_HelperBroker::getStaticHelper('NeoFlashMessenger');
                $message->addError('Session Expirada');
                Zend_Controller_Front::getInstance()->getRequest()->setControllerName('login');
                //$front->setControllerName('login');
                //$this->getRequest()->setParams(array('controller' => 'login'));
                
                //$this->_redirect('/backend/login');
            }
        }
    }
}