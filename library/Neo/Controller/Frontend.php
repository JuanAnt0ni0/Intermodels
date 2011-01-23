<?php
class Neo_Controller_Frontend extends Zend_Controller_Action
{
    /**
     * FlashMessenger
     *
     * @var Zend_Controller_Action_Helper_NeoFlashMessenger
     */
    protected $_flashMessenger = null;

    public function init()
    {
        $this->_flashMessenger = $this->_helper->getHelper('NeoFlashMessenger');
    }

}