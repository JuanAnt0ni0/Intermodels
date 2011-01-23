<?php

class Neo_Form_Decorator_FileYoutube extends Zend_Form_Decorator_Abstract
{
    protected $_placement = 'PREPEND';
    
    public function render( $content )
    {
        $elementID = $this->getElement()->getId();

        $button = new Zend_Form_Element_Button('upload', array(
            'Label'   => 'Upload',
            'decorators' => array(
                array('ViewHelper' , array('tag' => 'div')),
                array('HtmlTag', array('tag' => 'div'))
            ),
            'attribs' => array('onclick' => 'javascript:$(\'#'.$elementID.'\').fileUploadStart()')
        ));

        return $content . $button;
    }
}