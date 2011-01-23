<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function _initView()
    {
        $view = new Zend_View();
        $view->doctype('XHTML1_TRANSITIONAL');
	$view->headMeta()->appendHttpEquiv('Content-type', 'text/html;charset=utf-8');
	$view->headTitle('· Intermodels · Un deseo...hecho realidad · Modelos · Gogós · Azafatas · Agencia · Barcelona ·')
             ->setSeparator(' - ');

        $view->headScript()
             //->prependFile('http://connect.facebook.net/en_US/all.js')
             ->prependFile('http://ajax.googleapis.com/ajax/libs/swfobject/2.2/swfobject.js');

        $view->addHelperPath('Neo/View/Helper', 'Neo_View_Helper');
        $view->addHelperPath('ZendX/JQuery/View/Helper/', 'ZendX_JQuery_View_Helper');
        
        $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer');
        $viewRenderer->setView($view);
        return $view;
    }

    protected function _initActionHelper()
    {
        //Zend_Controller_Action_HelperBroker::addPath('Neo/Controller/Action/Helper','Neo_Controller_Action_Helper');
        Zend_Controller_Action_HelperBroker::addHelper(new Neo_Controller_Action_Helper_NeoFlashMessenger());
    }

    protected function _initDoctrine()
    {
        $this->getApplication()
             ->getAutoloader()
             ->pushAutoloader(array('Doctrine', 'autoload'));
        spl_autoload_register(array('Doctrine', 'modelsAutoload'));

        $manager = Doctrine_Manager::getInstance();
        $manager->setAttribute(Doctrine::ATTR_AUTO_ACCESSOR_OVERRIDE, true);
        $manager->setAttribute(
            Doctrine::ATTR_MODEL_LOADING,
            Doctrine::MODEL_LOADING_CONSERVATIVE
        );

        $manager->setAttribute(Doctrine::ATTR_AUTOLOAD_TABLE_CLASSES, true);
        $doctrine = $this->getOption('doctrine');
        Doctrine::loadModels($doctrine['models_path']);
        $conn = Doctrine_Manager::connection($doctrine['dsn'], 'doctrine');
        $conn->setAttribute(Doctrine::ATTR_USE_NATIVE_ENUM, true);
        return $conn;
    }

    protected function _initResourceAutoloader()
    {
        $resourceLoader = new Neo_Application_Resource_Loaders(array(
            array(
                 'basePath' => APPLICATION_PATH . '/modules/default',
                 'namespace' => 'Default'),
            array(
                 'basePath' => APPLICATION_PATH . '/modules/backend',
                 'namespace' => 'Backend'),
            array(
                 'basePath' => APPLICATION_PATH . '/modules/modelos',
                 'namespace' => 'Modelos'),
            array(
                 'basePath' => APPLICATION_PATH . '/modules/galerias',
                 'namespace' => 'Galerias'),
            array(
                 'basePath' => APPLICATION_PATH . '/modules/eventos',
                 'namespace' => 'Eventos')
            ));

        return $resourceLoader;
    }

    protected function _initCurrency()
    {
        $currency = new Zend_Currency('es_ES');
        Zend_Registry::set('Zend_Currency', $currency);
    }

    protected function _initTranslateValidation()
    {
        $translator = new Zend_Translate(
            'array',
            APPLICATION_PATH . '/data/locales/es/Zend_Validate.php',
            'es'
        );
        //Zend_Validate_Abstract::setDefaultTranslator($translator);
    }

}