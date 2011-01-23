<?php

class Neo_Controller_Action_Helper_LayoutBackend
    extends Zend_Controller_Action_Helper_Abstract
{
    public function preDispatch()
    {
        $layout = Zend_Layout::startMvc();
        $module = $this->getRequest()->getModuleName();
        $controller = $this->getRequest()->getControllerName();
        if ( $module === 'backend' )
        {
            $layout->setLayout('backend');
            if ( $controller == 'login' )
            {
                $layout->setLayout('login');
            }
        }
    }
}