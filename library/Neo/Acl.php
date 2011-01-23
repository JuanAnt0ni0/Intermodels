<?php

/**
 * Description of ACL
 *
 * @package Acl
 * @version v0.1
 * @author Neozeratul
 */
class Neo_Acl extends Zend_Acl
{
    public function __construct($file)  {
        // Carga los roles del archivo INI
        $roles = new Zend_Config_Ini($file, 'roles') ;
        // Crea los Roles dentro del Zend_Acl
        $this->_setRoles($roles);

        // Carga los recursos del archivo INI
        $resources = new Zend_Config_Ini($file, 'resources') ;
        // Crea los Recursos dentro del Zend_Acl
        $this->_setResources($resources) ;

        // Carga los subrecursos del archivo INI
        $subresources = new Zend_Config_Ini($file, 'subresources') ;
        // Crea los Subecursos dentro del Zend_Acl
        $this->_setSubresources($subresources) ;

        // Por cada Rol, se cargan sus Permisos
        foreach ($roles->toArray() as $role => $parents)    {
            $privileges = new Zend_Config_Ini($file, $role) ;
            $this->_setPrivileges($role, $privileges) ;
        }
    }

    /**
     * _setRoles
     *
     * Añade los Roles al Zend_Acl
     *
     * @param   Zend_Config
     * @return  Zend_Acl
     */
    protected function _setRoles($roles)    {
        foreach ($roles as $role => $parents)   {
            if (empty($parents))    {
                $parents = null ;
            } else {
                $parents = explode(',', $parents) ;
            }

            $this->addRole(new Zend_Acl_Role($role), $parents);
        }

        return $this ;
    }

    /**
     * _setResources
     *
     * Añade los Recursos al Zend_Acl
     *
     * @param   Zend_Config
     * @return  Zend_Acl
     */
    protected function _setResources($resources)  {
        foreach ($resources as $resource=>$parent) {
            $this->add(new Zend_Acl_Resource($resource));
        }
        return $this ;
    }

    /**
     * _setSubresources
     *
     * Añade los Subrecursos al Zend_Acl, por debajo de los Recursos
     *
     * @param   Zend_Config
     * @return  Zend_Acl
     */
    protected function _setSubresources($subresources)  {
        foreach ($subresources as $subresource => $resource) {
            $this->add(new Zend_Acl_Resource($subresource), $resource);
        }
        return $this ;
    }

    /**
     * _setPrivileges
     *
     * Añade los Privilegios al Zend_Acl
     *
     * @param   Zend_Config
     * @return  Zend_Acl
     */
    protected function _setPrivileges($role, $privileges)   {
        // Por cada privilegio
        foreach ($privileges as $do => $resources) {
            // Si no tiene Recursos, es un privilegio global
            if (empty($resources)) {
                $this->{$do}($role);
            }
            else {
                // Por cada Recurso
                foreach ($resources as $resources => $actions) {
                    // Si no tiene acciones
                    if (empty($actions))    {
                        $actions = null ;
                    } else {
                        $actions = explode(',', $actions) ;
                    }
                    $this->{$do}($role, $resources, $actions);
                }
            }
        }

        return $this ;
    }
}