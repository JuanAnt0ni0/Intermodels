<?php
class Neo_Controller_Backend extends Zend_Controller_Action
{
    /**
     * FlashMessenger
     *
     * @var Zend_Controller_Action_Helper_NeoFlashMessenger
     */
    protected $_flashMessenger = null;

    public function preDispatch()
    {
        $auth = Zend_Auth::getInstance();
        
        if (!$auth->hasIdentity()) {
            $this->_redirect('/backend/login');
        } else {
            $authNamespace = new Zend_Session_Namespace($auth->getStorage()->getNamespace());
            //$authNamespace->setExpirationSeconds(300);
            //$this->view->cliente = Cliente::getCliente($auth->getIdentity()->id);
        }
    }

    public function init()
    {
        $this->_flashMessenger = $this->_helper->getHelper('NeoFlashMessenger');
    }

}