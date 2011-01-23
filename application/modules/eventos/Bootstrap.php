<?php

class Eventos_Bootstrap extends Zend_Application_Module_Bootstrap
{
     protected function _initRouter()
    {
        $frontcontroller = Zend_Controller_Front::getInstance();
        $router = $frontcontroller->getRouter();

        $router->addRoute('eventoView',
            new Zend_Controller_Router_Route_Regex(
            'eventos/(.+)-(\d+)',
            array(
                'module'     => 'eventos',
                'controller' => 'index',
                'action'     => 'view'
            ),
            array(
                1 => 'titulo',
                2 => 'evento'
            ),
            'eventos/%s-%d'));
    }
}