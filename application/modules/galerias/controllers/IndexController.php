<?php

class Galerias_IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function verifyGaleria()
    {
        $id = (integer)$this->_request->getParam('galeria');
        $galeria = Galeria::findGaleria($id);
        if ($galeria) {
            return $galeria;
        } else {
            $this->_flashMessenger->addError('Galeria No Existe');
            $this->_redirect('/galerias');
        }
    }

    public function indexAction()
    {
        $galerias = Galeria::findGaleriasActive()->getData();
        $paginator  = new Zend_Paginator(new Zend_Paginator_Adapter_Array($galerias));
        $paginator->setItemCountPerPage(20)
                  ->setPageRange(5)
                  ->setCurrentPageNumber($this->_request->getParam('page', 1));

        $this->view->galerias = $paginator;
    }

    public function viewAction()
    {
        $galeria = $this->verifyGaleria();
        $this->view->galeria = $galeria;
    }

}

