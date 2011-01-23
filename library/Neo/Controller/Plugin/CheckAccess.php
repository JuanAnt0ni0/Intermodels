<?php

/**
 * Description of CheckAccess
 * @package Controller
 * @subpackage Plugin
 * @author Neozeratul
 */
class Neo_Controller_Plugin_CheckAccess extends Zend_Controller_Plugin_Abstract
{
    /**
     * Contiene el objeto Zend_Auth
     *
     * @var Zend_Auth
     */
    private $_auth;

    /**
     * Contiene el objeto Zend_Acl
     *
     * @var Zend_Acl
     */
    private $_acl;

    /**
     * El objeto de la clase singleton
     *
     * @var Plugin_CheckAccess
     */
    static private $instance = NULL;

    /**
     * Constructor
     */
    private function __construct()
    {
        $this->_auth =  Zend_Auth::getInstance();
        $this->_acl =   new Neo_Acl(APPLICATION_PATH . "/configs/permissions.ini");
    }

    /**
     * Devuelve el objeto de la clase singleton
     *
     * @return Plugin_CheckAccess
     */
    static public function getInstance() {
       if (self::$instance == NULL) {
          self::$instance = new Neo_Controller_Plugin_CheckAccess();
       }
       return self::$instance;
    }

    /**
     * Retorna el Rol del usuario actual
     *
     * @return string
     */
    private function getRol()
    {
        return ($this->_auth->hasIdentity())
               ? $this->_auth->getIdentity()->rol
               : 'invitado';
    }

    /**
     * preDispatch
     *
     * Funcion que se ejecuta antes de que lo haga el FrontController
     *
     * @param Zend_Controller_Request_Abstract $request Peticion HTTP realizada
     * @return
     * @uses Zend_Auth
     */
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        $controllerName = $request->getControllerName();
        $actionName     = $this->getRequest()->getActionName();

        // Si el usuario esta autentificado
        if ($this->_auth->hasIdentity()) {

            // Si tiene autorización para el controlador
            if (!$this->isAllowed( $controllerName, $actionName) ) {
                // Mostramos el error de que no tiene permisos
                $request->setControllerName("error");
                $request->setActionName("deniedpermission");
            }
        } else {
            // El usuario no esta autentificado
            // Si el Usuario no esta identificado y no se dirige a la página de Login
            if ($controllerName != 'login') {
                // Mostramos al usuario el Formulario de Login
                $request->setModuleName("auth");
                $request->setControllerName("index");
                $request->setActionName("index");
            }
        }
    }

    /**
     * isAllowed
     *
     * Retorna si tiene los permisos necesarios para el recurso y el permiso
     * solicitado
     *
     * @param  string  $resource
     * @param  string  $permission optional
     * @return bool
     */
    public function isAllowed ($resource, $permission = null)
    {
        // Por defecto, no tiene permisos
        $allow = false;

        // Si solo pregunta por el recurso
        if (is_null($permission)) {
            $allow = $this->_acl->isAllowed($this->getRol(), $resource);
        }
        // Si pregunta por el recurso y el permiso
        else {
            $allow = $this->_acl->isAllowed($this->getRol(), $resource, $permission);
        }

        return $allow;
    }
}