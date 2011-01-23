<?php

class Galerias_Bootstrap extends Zend_Application_Module_Bootstrap
{
     protected function _initRouter()
    {
        $frontcontroller = Zend_Controller_Front::getInstance();
        $router = $frontcontroller->getRouter();

        $router->addRoute('galeriaView',
            new Zend_Controller_Router_Route_Regex(
            'galerias/(.+)-(\d+)',
            array(
                'module'     => 'galerias',
                'controller' => 'index',
                'action'     => 'view'
            ),
            array(
                1 => 'titulo',
                2 => 'galeria'
            ),
            'galerias/%s-%d'));
    }
}