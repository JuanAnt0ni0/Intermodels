<?php

class Modelos_Bootstrap extends Zend_Application_Module_Bootstrap
{
    protected function _initRouter()
    {
        $frontcontroller = Zend_Controller_Front::getInstance();
        $router = $frontcontroller->getRouter();

        $router->addRoute('PerfilesChicos',  new Zend_Controller_Router_Route(
            '/perfiles/chicos',
            array(
                'module' => 'modelos',
                'controller' => 'index',
                'action' => 'index',
                'genero' => 'chicos'
            )
           ));

        $router->addRoute('PerfilesChicas',  new Zend_Controller_Router_Route(
            '/perfiles/chicas',
            array(
                'module' => 'modelos',
                'controller' => 'index',
                'action' => 'index',
                'genero' => 'chicas')
           ));
    }
}