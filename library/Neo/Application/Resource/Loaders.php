<?php

class Neo_Application_Resource_Loaders
{
    public function __construct($loaders)
    {
        foreach ($loaders as $module) {
            $loader = new Zend_Application_Module_Autoloader($module);
        }
    }
}

