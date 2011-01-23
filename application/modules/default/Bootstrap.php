<?php

class Default_Bootstrap extends Zend_Application_Module_Bootstrap
{    

    protected function _initRouter()
    {
        $frontcontroller = Zend_Controller_Front::getInstance();
        $router = $frontcontroller->getRouter();

        $router->addRoute('Home',  new Zend_Controller_Router_Route(
            '/',
            array(
                'module' => 'default',
                'controller' => 'index',
                'action' => 'index')
           ));

	$router->addRoute('Privacidad',  new Zend_Controller_Router_Route(
            '/privacidad',
            array(
                'module' => 'default',
                'controller' => 'index',
                'action' => 'privacidad')
           ));

        $router->addRoute('About',  new Zend_Controller_Router_Route(
            '/sobre-intermodels',
            array(
                'module' => 'default',
                'controller' => 'index',
                'action' => 'about')
           ));

        $router->addRoute('Services',  new Zend_Controller_Router_Route(
            '/servicios',
            array(
                'module' => 'default',
                'controller' => 'index',
                'action' => 'services')
           ));

        $router->addRoute('Join',  new Zend_Controller_Router_Route(
            '/join',
            array(
                'module' => 'default',
                'controller' => 'index',
                'action' => 'join')
           ));

        $router->addRoute('Contact',  new Zend_Controller_Router_Route(
            '/contacto',
            array(
                'module' => 'default',
                'controller' => 'index',
                'action' => 'contact')
           ));

        $router->addRoute('Perfiles',  new Zend_Controller_Router_Route(
            '/perfiles',
            array(
                'module' => 'default',
                'controller' => 'index',
                'action' => 'perfiles')
           ));
    }
}