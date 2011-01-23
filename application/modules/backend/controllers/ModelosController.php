<?php

class Backend_ModelosController extends Neo_Controller_Backend
{
    private $_session;

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
        $modelos = Modelo::findModelos()->getData();
        $paginator  = new Zend_Paginator(new Zend_Paginator_Adapter_Array($modelos));
        $paginator->setItemCountPerPage(20)
                  ->setPageRange(5)
                  ->setCurrentPageNumber($this->_request->getParam('page', 1));

        $this->view->modelos = $paginator;
    }   

    public function activarAction()
    {
        try{
            $modelo = $this->verifyModelo($id);
            $modelo->status = true;
            $modelo->save();

            $url = $this->view->url(array('modelo' => $modelo->id), 'modelosPage');
            $url = str_replace($this->view->baseUrl(), '', $url);
            $this->_flashMessenger->addSuccess('Modelo Activado');
            $this->_redirect($url);
        } catch (Doctrine_Exception $e) {
            $this->_flashMessenger->addError($e->errorMessage());
        }
    }

    public function detalleAction()
    {
        $modelo = $this->verifyModelo();
        $this->view->modelo = $modelo;
    }

    public function addAction()
    {
        $formModelo = new Modelos_Form_Modelo();
	$formModelo->setAction($this->view->url(array(), 'addModelo'));

	if ($this->getRequest()->isPost()) {
            $formData = $this->_request->getPost();

            if (!$formModelo->isValid($formData)) {
                $this->view->formModelo = $formModelo;
		$formModelo->populate($formData);
		return $this->render('form');
            } else {
                $modelo = new Modelo();
                $modelo->fromArray($formModelo->getValues(true));
                $modelo->nuevo();
                $this->_flashMessenger->addSuccess('Modelo Agregada');
                $this->_redirect('/backend/modelos');
            }
	}

	$this->view->formModelo = $formModelo;
	$this->render('form');
    }

    public function editAction()
    {       
	$formModelo = new Modelos_Form_Modelo();

        $modelo = $this->verifyModelo();
        
        $formModelo->setAction($this->view->url(array('modelo' => $modelo->id), 'editModelo'));

	if ($this->_request->isPost()) {
            $formData = $this->_request->getPost();

            if (!$formModelo->isValid($formData)) {
                $this->view->formModelo = $formModelo;
		$formModelo->populate($formData);
		return $this->render('form');
            }

            $modelo->fromArray($formModelo->getValues(true));
            $modelo->save();
            $this->_flashMessenger->addSuccess('Modelo Editada');
            $this->_redirect('/backend/modelos');
	}
	$formModelo->populate($modelo->toArray());
	$this->view->formModelo = $formModelo;
	$this->render('form');
    }

    public function deleteAction()
    {
	$modelo = $this->verifyModelo($id);
       	if(null !== $modelo) {
            $picasa = new Neo_Gdata_Photo();
            $picasa->deleteAlbum($modelo->album_id);
            $modelo->delete();
	}
        $this->_flashMessenger->addSuccess('Modelo Eliminada');
	$this->_redirect('/backend/modelos');
    }

    public function addphotoAction()
    {
        $formPhoto = new Modelos_Form_Photo();
        
        $modelo = $this->verifyModelo($id);
        $formPhoto->setAction($this->view->url(array('modelo' => $modelo->id), 'addFotoModelo'));
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
                    $modelo->addPhoto($foto);
                } catch (Zend_Exception $e) {
                    $this->_flashMessenger->addError($e->getMessage());
                }
                $this->_flashMessenger->addSuccess('Foto Agregada');
                $url = $this->view->url(array('modelo' => $modelo->id), 'detalleModelo');
                $url = str_replace($this->view->baseUrl(), '', $url);
                $this->_redirect($url);
            }
	}

        $this->view->formMedia = $formPhoto;
        $this->render('formmedia');
    }

    public function deletephotoAction()
    {
        $modelo = $this->verifyModelo($id);
        $photoId = (integer)$this->_request->getParam('photo');

        $photo = Photo::findPhoto($photoId);
        
       	if(null !== $photo) {
            $picasa = new Neo_Gdata_Photo();
            $picasa->deletePhoto($modelo->album_id, $photo->photo_id);
            $photo->delete();
	}

        $this->_flashMessenger->addSuccess('Foto Eliminada');
        $url = $this->view->url(array('modelo' => $modelo->id), 'detalleModelo');
        $url = str_replace($this->view->baseUrl(), '', $url);
        $this->_redirect($url);

    }

    public function addvideoAction()
    {
        $formVideo = new Neo_Form_Youtube();

        if ($this->getRequest()->isPost()) {
            $formData = $this->_request->getPost();

            if (!$formVideo->isValid($formData)) {
                $this->view->formModelo = $formVideo;
		$formVideo->populate($formData);
		return $this->render('formmedia');
            } else {
                
                /*
                $modelo = new Modelo();
                $modelo->fromArray($formPhoto->getValues(true));
                $modelo->save();
                */

                $this->_flashMessenger->addSuccess('Video Agregado');
                $this->_redirect('/backend/modelos');
            }
	}

        $this->view->formMedia = $formVideo;
        $this->render('formmedia');
    }

    public function uploadifyAction()
    {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        
        if (! empty ( $_FILES ))
        {
            $tempFile = $_FILES ['video'] ['tmp_name'];
            $targetFile = APPLICATION_PATH . DS . 'uploads'
			. DS . $_FILES ['video'] ['name'];

            move_uploaded_file ( $tempFile, $targetFile );
            echo "1";
        } else {
            echo 'No files sent';
        }

    }

    public function uploadvideoAction()
    {
        //Verificación de la existencia del Modelo
        $modelo = $this->verifyModelo($id);
        
        if ($this->getRequest()->isPost()) {
            $video = new Neo_Gdata_Video();
            $video->addVideo($file);
        }
    }

    public function verifyModelo()
    {
        $id = (integer)$this->_request->getParam('modelo');
        $modelo = Modelo::findModelo($id);
        if ($modelo) {
            return $modelo;
        } else {
            $this->_flashMessenger->addError('Modelo No Existe');
            $this->_redirect('/backend/modelos');
        }
    }

}