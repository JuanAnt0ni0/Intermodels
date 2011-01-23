<?php

class Backend_Bootstrap extends Zend_Application_Module_Bootstrap
{    
    protected function _initActionHelper()
    {
        //Zend_Controller_Action_HelperBroker::addHelper(new Neo_Controller_Action_Helper_Auth());
        Zend_Controller_Action_HelperBroker::addHelper(new Neo_Controller_Action_Helper_LayoutBackend());
    }

    protected function _initRouter()
    {
        $frontcontroller = Zend_Controller_Front::getInstance();
        $router = $frontcontroller->getRouter();

        //Index
        $router->addRoute('backendLogout',  new Zend_Controller_Router_Route(
            'backend/logout',
                array(
                    'module' => 'backend',
                    'controller' => 'login',
                    'action' => 'logout')
                ));

        $router->addRoute('backendChange',  new Zend_Controller_Router_Route(
            'backend/change',
                array(
                    'module' => 'backend',
                    'controller' => 'index',
                    'action' => 'change')
                ));

        //Modelos
        $router->addRoute('modelosPage',
            new Zend_Controller_Router_Route_Regex(
            'backend/modelos/(\d+)',
            array(
                'module'     => 'backend',
                'controller' => 'modelos',
                'action'     => 'index',
                'page'       => 1
            ),
            array(
                1 => 'page',
            ),
            'backend/modelos/%d'));

        $router->addRoute('activarModelo',
            new Zend_Controller_Router_Route_Regex(
            'backend/modelo-(\d+)/activar',
            array(
                'module'     => 'backend',
                'controller' => 'modelos',
                'action'     => 'activar'
            ),
            array(
                1 => 'modelo'
            ),
            'backend/modelo-%d/activar'));

        $router->addRoute('detalleModelo',
            new Zend_Controller_Router_Route_Regex(
            'backend/modelo-(\d+)',
            array(
                'module'     => 'backend',
                'controller' => 'modelos',
                'action'     => 'detalle'
            ),
            array(
                1 => 'modelo'
            ),
            'backend/modelo-%d'));

        $router->addRoute('addModelo',  new Zend_Controller_Router_Route(
            'backend/modelo/add',
                array(
                    'module' => 'backend',
                    'controller' => 'modelos',
                    'action' => 'add')
                ));

        $router->addRoute('editModelo',
            new Zend_Controller_Router_Route_Regex(
            'backend/modelo/edit/(\d+)',
            array(
                'module'     => 'backend',
                'controller' => 'modelos',
                'action'     => 'edit'
            ),
            array(
                1 => 'modelo'
            ),
            'backend/modelo/edit/%d'));

        $router->addRoute('deleteModelo',
            new Zend_Controller_Router_Route_Regex(
            'backend/modelo/delete/(\d+)',
            array(
                'module'     => 'backend',
                'controller' => 'modelos',
                'action'     => 'delete'
            ),
            array(
                1 => 'modelo'
            ),
            'backend/modelo/delete/%d'));

        $router->addRoute('addVideo',
            new Zend_Controller_Router_Route_Regex(
            'backend/modelo-(\d+)/addvideo',
            array(
                'module'     => 'backend',
                'controller' => 'modelos',
                'action'     => 'addVideo'
            ),
            array(
                1 => 'modelo'
            ),
            'backend/modelo-%d/addVideo'));

        //Fotos
        $router->addRoute('addFotoModelo',
            new Zend_Controller_Router_Route_Regex(
            'backend/modelo-(\d+)/addPhoto',
            array(
                'module'     => 'backend',
                'controller' => 'modelos',
                'action'     => 'addphoto'
            ),
            array(
                1 => 'modelo'
            ),
            'backend/modelo-%d/addPhoto'));
        
        $router->addRoute('deleteFotoModelo',
            new Zend_Controller_Router_Route_Regex(
            'backend/modelo-(\d+)/deletePhoto/(\d+)',
            array(
                'module'     => 'backend',
                'controller' => 'modelos',
                'action'     => 'deletephoto'
            ),
            array(
                1 => 'modelo',
                2 => 'photo'
            ),
            'backend/modelo-%d/deletePhoto/%d'));


        //Eventos
        $router->addRoute('eventosPage',
            new Zend_Controller_Router_Route_Regex(
            'backend/eventos/(\d+)',
            array(
                'module'     => 'backend',
                'controller' => 'eventos',
                'action'     => 'index',
                'page'       => 1
            ),
            array(
                1 => 'page',
            ),
            'backend/eventos/%d'));
        
        $router->addRoute('addEvento',  new Zend_Controller_Router_Route(
            'backend/evento/add',
                array(
                    'module' => 'backend',
                    'controller' => 'eventos',
                    'action' => 'add')
                ));

        $router->addRoute('detalleEvento',
            new Zend_Controller_Router_Route_Regex(
            'backend/evento-(\d+)',
            array(
                'module'     => 'backend',
                'controller' => 'eventos',
                'action'     => 'detalle'
            ),
            array(
                1 => 'evento'
            ),
            'backend/evento-%d'));

        $router->addRoute('editEvento',
            new Zend_Controller_Router_Route_Regex(
            'backend/evento/edit/(\d+)',
            array(
                'module'     => 'backend',
                'controller' => 'eventos',
                'action'     => 'edit'
            ),
            array(
                1 => 'evento'
            ),
            'backend/evento/edit/%d'));

        $router->addRoute('activarEvento',
            new Zend_Controller_Router_Route_Regex(
            'backend/evento-(\d+)/activar',
            array(
                'module'     => 'backend',
                'controller' => 'eventos',
                'action'     => 'activar'
            ),
            array(
                1 => 'evento'
            ),
            'backend/evento-%d/activar'));

        $router->addRoute('deleteEvento',
            new Zend_Controller_Router_Route_Regex(
            'backend/evento/delete/(\d+)',
            array(
                'module'     => 'backend',
                'controller' => 'eventos',
                'action'     => 'delete'
            ),
            array(
                1 => 'evento'
            ),
            'backend/evento/delete/%d'));

        $router->addRoute('addFotoEvento',
            new Zend_Controller_Router_Route_Regex(
            'backend/evento-(\d+)/addPhoto',
            array(
                'module'     => 'backend',
                'controller' => 'eventos',
                'action'     => 'addphoto'
            ),
            array(
                1 => 'evento'
            ),
            'backend/evento-%d/addPhoto'));

        $router->addRoute('deleteFotoEvento',
            new Zend_Controller_Router_Route_Regex(
            'backend/evento-(\d+)/deletePhoto/(\d+)',
            array(
                'module'     => 'backend',
                'controller' => 'eventos',
                'action'     => 'deletephoto'
            ),
            array(
                1 => 'evento',
                2 => 'photo'
            ),
            'backend/evento-%d/deletePhoto/%d'));

        //Galerias
        $router->addRoute('galeriasPage',
            new Zend_Controller_Router_Route_Regex(
            'backend/galerias/(\d+)',
            array(
                'module'     => 'backend',
                'controller' => 'galerias',
                'action'     => 'index',
                'page'       => 1
            ),
            array(
                1 => 'page',
            ),
            'backend/galerias/%d'));

        $router->addRoute('addGaleria',  new Zend_Controller_Router_Route(
            'backend/galeria/add',
                array(
                    'module' => 'backend',
                    'controller' => 'galerias',
                    'action' => 'add')
                ));

        $router->addRoute('detalleGaleria',
            new Zend_Controller_Router_Route_Regex(
            'backend/galeria-(\d+)',
            array(
                'module'     => 'backend',
                'controller' => 'galerias',
                'action'     => 'detalle'
            ),
            array(
                1 => 'galeria'
            ),
            'backend/galeria-%d'));

        $router->addRoute('editGaleria',
            new Zend_Controller_Router_Route_Regex(
            'backend/galeria/edit/(\d+)',
            array(
                'module'     => 'backend',
                'controller' => 'galerias',
                'action'     => 'edit'
            ),
            array(
                1 => 'galeria'
            ),
            'backend/galeria/edit/%d'));

        $router->addRoute('activarGaleria',
            new Zend_Controller_Router_Route_Regex(
            'backend/galeria-(\d+)/activar',
            array(
                'module'     => 'backend',
                'controller' => 'galerias',
                'action'     => 'activar'
            ),
            array(
                1 => 'galeria'
            ),
            'backend/galeria-%d/activar'));

        $router->addRoute('deleteGaleria',
            new Zend_Controller_Router_Route_Regex(
            'backend/galeria/delete/(\d+)',
            array(
                'module'     => 'backend',
                'controller' => 'galerias',
                'action'     => 'delete'
            ),
            array(
                1 => 'galeria'
            ),
            'backend/galeria/delete/%d'));

        $router->addRoute('addFotoGaleria',
            new Zend_Controller_Router_Route_Regex(
            'backend/galeria-(\d+)/addPhoto',
            array(
                'module'     => 'backend',
                'controller' => 'galerias',
                'action'     => 'addphoto'
            ),
            array(
                1 => 'galeria'
            ),
            'backend/galeria-%d/addPhoto'));

        $router->addRoute('deleteFotoGaleria',
            new Zend_Controller_Router_Route_Regex(
            'backend/galeria-(\d+)/deletePhoto/(\d+)',
            array(
                'module'     => 'backend',
                'controller' => 'galerias',
                'action'     => 'deletephoto'
            ),
            array(
                1 => 'galeria',
                2 => 'photo'
            ),
            'backend/galeria-%d/deletePhoto/%d'));
    }
}