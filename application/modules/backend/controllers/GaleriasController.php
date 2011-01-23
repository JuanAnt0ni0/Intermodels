<?php

class Backend_GaleriasController extends Neo_Controller_Backend
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
        $galerias = Galeria::findGalerias()->getData();
        $paginator  = new Zend_Paginator(new Zend_Paginator_Adapter_Array($galerias));
        $paginator->setItemCountPerPage(20)
                  ->setPageRange(5)
                  ->setCurrentPageNumber($this->_request->getParam('page', 1));

        $this->view->galerias = $paginator;
    }

    public function detalleAction()
    {
        $galeria = $this->verifyGaleria();
        $this->view->galeria = $galeria;
    }

    public function addAction()
    {
        $formGaleria = new Galerias_Form_Galeria();
	$formGaleria->setAction($this->view->url(array(), 'addGaleria'));

	if ($this->getRequest()->isPost()) {
            $formData = $this->_request->getPost();

            if (!$formGaleria->isValid($formData)) {
                $this->view->formGaleria = $formGaleria;
		$formGaleria->populate($formData);
		return $this->render('form');
            } else {
                $galeria = new Galeria();
                $galeria->fromArray($formGaleria->getValues(true));
                $galeria->nuevo();
                $this->_flashMessenger->addSuccess('Galeria Agregado');
                $this->_redirect('/backend/galerias');
            }
	}

	$this->view->formGaleria = $formGaleria;
	$this->render('form');
    }

    public function verifyGaleria()
    {
        $id = (integer)$this->_request->getParam('galeria');
        $galeria = Galeria::findGaleria($id);
        if ($galeria) {
            return $galeria;
        } else {
            $this->_flashMessenger->addError('Galeria No Existe');
            $this->_redirect('/backend/galerias');
        }
    }

    public function activarAction()
    {
        try{
            $galeria = $this->verifyGaleria();
            $galeria->status = true;
            $galeria->save();

            $url = $this->view->url(array('galeria' => $galeria->id), 'galeriasPage');
            $url = str_replace($this->view->baseUrl(), '', $url);
            $this->_flashMessenger->addSuccess('Galeria Activado');
            $this->_redirect($url);
        } catch (Doctrine_Exception $e) {
            $this->_flashMessenger->addError($e->errorMessage());
        }
    }

    public function editAction()
    {
	$formGaleria = new Galerias_Form_Galeria();

        $galeria = $this->verifyGaleria();

        $formGaleria->setAction($this->view->url(array('galeria' => $galeria->id), 'editGaleria'));

	if ($this->_request->isPost()) {
            $formData = $this->_request->getPost();

            if (!$formGaleria->isValid($formData)) {
                $this->view->formGaleria = $formGaleria;
		$formGaleria->populate($formData);
		return $this->render('form');
            }

            $galeria->fromArray($formGaleria->getValues(true));
            $galeria->save();
            $this->_flashMessenger->addSuccess('Galeria Editado');
            $this->_redirect('/backend/galerias');
	}
	$formGaleria->populate($galeria->toArray());
	$this->view->formGaleria = $formGaleria;
	$this->render('form');
    }

    public function deleteAction()
    {
	$galeria = $this->verifyGaleria();
       	if(null !== $galeria) {
            $picasa = new Neo_Gdata_Photo();
            $picasa->deleteAlbum($galeria->album_id);
            $galeria->Photos->delete();
            $galeria->delete();
	}
        $this->_flashMessenger->addSuccess('Galeria Eliminado');
	$this->_redirect('/backend/galerias');
    }

    public function addphotoAction()
    {
        $formPhoto = new Galerias_Form_Photo();

        $galeria = $this->verifyGaleria($id);
        $formPhoto->setAction($this->view->url(array('galeria' => $galeria->id), 'addFotoGaleria'));
        if ($this->getRequest()->isPost()) {
            $formData = $this->_request->getPost();
            if (!$formPhoto->isValid($formData)) {
                $this->view->formMedia = $formPhoto;
		$formPhoto->populate($formData);
		return $this->render('formmedia');
            } else {
                $foto = $_FILES['photo'];
                $foto['summary'] = $formData['descripcion'];
                try{
                    $galeria->addPhoto($foto);
                } catch (Zend_Exception $e) {
                    $this->_flashMessenger->addError($e->getMessage());
                }
                $this->_flashMessenger->addSuccess('Foto Agregada');
                $url = $this->view->url(array('galeria' => $galeria->id), 'detalleGaleria');
                $url = str_replace($this->view->baseUrl(), '', $url);
                $this->_redirect($url);
            }
        }

        $this->view->formMedia = $formPhoto;
        $this->render('formmedia');

    }

    public function deletephotoAction()
    {
        $galeria = $this->verifyGaleria();
        $photoId = (integer)$this->_request->getParam('photo');

        $photo = Photo::findPhoto($photoId);

       	if(null !== $photo) {
            $picasa = new Neo_Gdata_Photo();
            $picasa->deletePhoto($galeria->album_id, $photo->photo_id);
            $photo->delete();
	}

        $this->_flashMessenger->addSuccess('Foto Eliminada');
        $url = $this->view->url(array('galeria' => $galeria->id), 'detalleGaleria');
        $url = str_replace($this->view->baseUrl(), '', $url);
        $this->_redirect($url);
    }
}