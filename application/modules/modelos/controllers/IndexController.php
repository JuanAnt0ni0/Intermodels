<?php

class Modelos_IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $genero = $this->_request->getParam('genero', 'chicos');
        $modelos = ($genero == 'chicos') ? Modelo::findModelosChicosActive()->getData() : Modelo::findModelosChicasActive()->getData();
        $paginator  = new Zend_Paginator(new Zend_Paginator_Adapter_Array($modelos));
        $paginator->setItemCountPerPage(20)
                  ->setPageRange(5)
                  ->setCurrentPageNumber($this->_request->getParam('page', 1));

        $this->view->modelos = $paginator;
    }

}