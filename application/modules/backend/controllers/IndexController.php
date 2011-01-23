<?php

class Backend_IndexController extends Neo_Controller_Backend
{
    public function preDispatch()
    {
        parent::preDispatch();
    }

    public function init()
    {
        parent::init();
    }

    public function indexAction()
    {
        $this->_redirect('backend/modelos');
    }

    public function changeAction()
    {
        $formPassword = new Backend_Form_ChangePassword();
        
        if ($this->getRequest()->isPost()) {
            if(!$formPassword->isValid($this->_request->getPost())){
                $formPassword->populate($this->_request->getPost());
                $this->view->formPassword = $formPassword;
            } else {
                $password = md5($this->getRequest()->getParam('password'));
                $user = Usuario::findUsuario();
                $user->password = $password;
                $user->save();
                $this->_flashMessenger->addSuccess('Se realizo el cambio de Password');
                $this->_redirect('/backend');
            }
        }
        $this->view->formPassword = $formPassword;
    }


}

