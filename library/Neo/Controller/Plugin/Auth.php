<?php

class Neo_Controller_Plugin_Auth extends Zend_Controller_Plugin_Abstract
{

    protected $_auth;
    protected $_acl;

    const NO_AUTH_MODULE    = 'default';
    const NO_AUTH_CONTROLLER = 'login';
    const NO_AUTH_ACTION    = 'index';

    const NO_ACL_MODULE     = 'default';
    const NO_ACL_CONTROLLER  = 'error';
    const NO_ACL_ACTION     = 'privileges';

    public function __construct()
    {
        $this->_auth = Zend_Auth::getInstance();
        $this->_acl = Zend_Registry::get('Zend_Acl');
    }

    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        if ($this->_auth->hasIdentity()) {
            $role = $this->_auth->getIdentity()->getUser()->role;
        } else {
            $role = 'guest';
        }

        $controller = $request->controller;
        $action = $request->action;
        $module = $request->module;
        $resource = $controller;

        if (!$this->_acl->has($resource)) {
          $resource = null;
        }

        if (!$this->_acl->isAllowed($role, $resource, $action)) {
          if (!$this->_auth->hasIdentity()) {
            $module     = self::NO_AUTH_MODULE;
            $controller = self::NO_AUTH_CONTROLLER;
            $action     = self::NO_AUTH_ACTION;
          } else {
            $module     = self::NO_ACL_MODULE;
            $controller = self::NO_ACL_CONTROLLER;
            $action     = self::NO_ACL_ACTION;
          }
        }

        $request->setModuleName($module);
        $request->setControllerName($controller);
        $request->setActionName($action);
    }
}