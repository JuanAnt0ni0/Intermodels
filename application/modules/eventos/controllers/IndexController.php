<?php

class Eventos_IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function verifyEvento()
    {
        $id = (integer)$this->_request->getParam('evento');
        $evento = Evento::findEvento($id);
        if ($evento) {
            return $evento;
        } else {
            $this->_flashMessenger->addError('Evento No Existe');
            $this->_redirect('/eventos');
        }
    }

    public function indexAction()
    {
        $eventos = Evento::findEventosActive()->getData();
        $paginator  = new Zend_Paginator(new Zend_Paginator_Adapter_Array($eventos));
        $paginator->setItemCountPerPage(20)
                  ->setPageRange(5)
                  ->setCurrentPageNumber($this->_request->getParam('page', 1));

        $this->view->eventos = $paginator;
    }

    public function viewAction()
    {
        $evento = $this->verifyEvento();
        $this->view->evento = $evento;
    }

}

