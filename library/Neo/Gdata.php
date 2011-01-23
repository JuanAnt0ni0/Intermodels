<?php

class Neo_Gdata {

    /**
     * Username
     *
     * @var string
     */  
    protected $_username = null;

    /**
     * Password
     *
     * @var string
     */
    protected $_password = null;

    /**
     * Developer Key
     *
     * @var string
     */
    protected $_developerKey = null;
    
    /**
     * Http Client
     *
     * @var Zend_Http_Client
     */
    protected $_client;

    /**
     * Application Id
     *
     * @var string
     */
    private $_applicationId = null;

    /**
     * Client Id
     *
     * @var string
     */
    private $_clientId = null;
    
    public function  __construct()
    {
        $bootstrap = Zend_Controller_Front::getInstance()->getParam('bootstrap');
        
        $gdata = $bootstrap->getOption('gdata');
        
        $this->_username      = $gdata['username'];
        $this->_password      = $gdata['password'];
        $this->_developerKey  = $gdata['developerKey'];
        $this->_applicationId = $gdata['applicationId'];
        $this->_clientId      = $gdata['clientId'];
    }

    /**
     * Obteniendo username
     *
     * @return string
     */
    protected function getUsername()
    {
        return $this->_username;
    }

    /**
     * Obteniendo password
     *
     * @return string
     */
    protected function getPassword()
    {
        return $this->_password;
    }

     /**
     * Obteniendo developerKey
     *
     * @return string
     */
    protected function getDeveloperKey()
    {
        return $this->_developerKey;
    }

    /**
     * Obteniendo applicationId
     *
     * @return string
     */
    protected function getApplicationId()
    {
        return $this->_applicationId;
    }

    /**
     * Obteniendo clientId
     *
     * @return string
     */
    protected function getClientId()
    {
        return $this->_clientId;
    }
    
}