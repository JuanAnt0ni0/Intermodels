<?php

class Neo_Mail extends Zend_Mail
{
    protected $_view;
    protected $_layout;

    /**
     * @var Zend_Config Configuration object
     */
    protected $_configuration ;

    /**
     * @var string chemin vers les scripts de vue
     */
    protected $_path ;
    
    /**
     * Constructeur
     *
     * @param string $path Chemin vers les scripts de vue, par défaut, on prend
     *                     le répertoire "mails" dans le répertoire de vue courant
     *                     du layout d'affichage des pages.
     */
    public function __construct($charset = 'utf-8') {
        parent::__construct($charset);
    }
}