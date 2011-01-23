<?php

class Neo_Controller_Plugin_Acl extends Zend_Acl
{
    public function __construct(Zend_Auth $auth)
    {
        $roleGuest = new Zend_Acl_Role('guest');

        $this->add( new Zend_Acl_Resource( 'home' ) );
        $this->add( new Zend_Acl_Resource( 'news' ) );
        $this->add( new Zend_Acl_Resource( 'tutorials' ) );
        $this->add( new Zend_Acl_Resource( 'forum' ) );
        $this->add( new Zend_Acl_Resource( 'support' ) );
        $this->add( new Zend_Acl_Resource( 'admin' ) );

        $this->addRole( new Zend_Acl_Role( 'guest' ) );
        $this->addRole( new Zend_Acl_Role( 'member' ), 'guest' );
        $this->addRole( new Zend_Acl_Role( 'admin' ), 'member' );

        // Guest may only view content
        $this->allow( 'guest', 'home' );
        $this->allow( 'guest', 'news' );
        $this->allow( 'guest', 'tutorials' );
        $this->allow( 'member', 'forum' );
        $this->deny( 'member', 'forum', 'update' ); // Remove specific privilege
        $this->allow( 'member', 'support' );
        $this->allow( 'admin' ); // unrestricted access
    }
}