<?php

class Backend_EventosController extends Neo_Controller_Backend
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
        $eventos = Evento::findEventos()->getData();
        $paginator  = new Zend_Paginator(new Zend_Paginator_Adapter_Array($eventos));
        $paginator->setItemCountPerPage(20)
                  ->setPageRange(5)
                  ->setCurrentPageNumber($this->_request->getParam('page', 1));

        $this->view->eventos = $paginator;
    }

    public function detalleAction()
    {
        $evento = $this->verifyEvento();
        $this->view->evento = $evento;
    }

    public function addAction()
    {
        $formEvento = new Eventos_Form_Evento();
	$formEvento->setAction($this->view->url(array(), 'addEvento'));

	if ($this->getRequest()->isPost()) {
            $formData = $this->_request->getPost();

            if (!$formEvento->isValid($formData)) {
                $this->view->formEvento = $formEvento;
		$formEvento->populate($formData);
		return $this->render('form');
            } else {
                $evento = new Evento();
                $evento->fromArray($formEvento->getValues(true));
                $evento->nuevo();
                $this->_flashMessenger->addSuccess('Evento Agregado');
                $this->_redirect('/backend/eventos');
            }
	}

	$this->view->formEvento = $formEvento;
	$this->render('form');
    }

    public function verifyEvento()
    {
        $id = (integer)$this->_request->getParam('evento');
        $evento = Evento::findEvento($id);
        if ($evento) {
            return $evento;
        } else {
            $this->_flashMessenger->addError('Evento No Existe');
            $this->_redirect('/backend/eventos');
        }
    }

    public function activarAction()
    {
        try{
            $evento = $this->verifyEvento($id);
            $evento->status = true;
            $evento->save();

            $url = $this->view->url(array('evento' => $evento->id), 'eventosPage');
            $url = str_replace($this->view->baseUrl(), '', $url);
            $this->_flashMessenger->addSuccess('Evento Activado');
            $this->_redirect($url);
        } catch (Doctrine_Exception $e) {
            $this->_flashMessenger->addError($e->errorMessage());
        }
    }

    public function editAction()
    {
	$formEvento = new Eventos_Form_Evento();

        $evento = $this->verifyEvento($id);

        $formEvento->setAction($this->view->url(array('evento' => $evento->id), 'editEvento'));

	if ($this->_request->isPost()) {
            $formData = $this->_request->getPost();

            if (!$formEvento->isValid($formData)) {
                $this->view->formEvento = $formEvento;
		$formEvento->populate($formData);
		return $this->render('form');
            }

            $evento->fromArray($formEvento->getValues(true));
            $evento->save();
            $this->_flashMessenger->addSuccess('Evento Editado');
            $this->_redirect('/backend/eventos');
	}
	$formEvento->populate($evento->toArray());
	$this->view->formEvento = $formEvento;
	$this->render('form');
    }

    public function deleteAction()
    {
	$evento = $this->verifyEvento($id);
       	if(null !== $evento) {
            $picasa = new Neo_Gdata_Photo();
            $picasa->deleteAlbum($evento->album_id);
            $evento->delete();
	}
        $this->_flashMessenger->addSuccess('Evento Eliminado');
	$this->_redirect('/backend/eventos');
    }

    public function addphotoAction()
    {
        $formPhoto = new Eventos_Form_Photo();

        $evento = $this->verifyEvento($id);
        $formPhoto->setAction($this->view->url(array('evento' => $evento->id), 'addFotoEvento'));
        if ($this->getRequest()->isPost()) {
            $formData = $this->_request->getPost();
            if (!$formPhoto->isValid($formData)) {
                $this->view->formMedia = $formPhoto;
		$formPhoto->populate($formData);
		return $this->render('formmedia');
            } else {
                $foto = $_FILES['photo'];
                $foto['title']   = $formData['titulo'];
                $foto['summary'] = $formData['descripcion'];
                try{
                    $evento->addPhoto($foto);
                } catch (Zend_Exception $e) {
                    $this->_flashMessenger->addError($e->getMessage());
                }
                $this->_flashMessenger->addSuccess('Foto Agregada');
                $url = $this->view->url(array('evento' => $evento->id), 'detalleEvento');
                $url = str_replace($this->view->baseUrl(), '', $url);
                $this->_redirect($url);
            }
        }

        $this->view->formMedia = $formPhoto;
        $this->render('formmedia');

    }

    public function deletephotoAction()
    {
        $evento = $this->verifyEvento($id);
        $photoId = (integer)$this->_request->getParam('photo');

        $photo = Photo::findPhoto($photoId);

       	if(null !== $photo) {
            $picasa = new Neo_Gdata_Photo();
            $picasa->deletePhoto($evento->album_id, $photo->photo_id);
            $photo->delete();
	}

        $this->_flashMessenger->addSuccess('Foto Eliminada');
        $url = $this->view->url(array('evento' => $evento->id), 'detalleEvento');
        $url = str_replace($this->view->baseUrl(), '', $url);
        $this->_redirect($url);
    }
}