<?php
/**
* Zend Framework Uplaodify Extension
*
* @author gondo
* @email gondo@webdesigners.sk
* @link http://gondo.webdesigners.sk/zend-framework-uploadify-extension
* @license WTFPL http://en.wikipedia.org/wiki/WTFPL
*
*/

class Neo_Form_Decorator_Uploadify extends Zend_Form_Decorator_Abstract
{
    public function render( $content )
    {
        $text = $this->getOption('text');
        if($text == '')
            $text = 'Upload';
        $elementID = $this->getElement()->getId();
        $link = '<a href="javascript:$(\'#'.$elementID.'\').fileUploadStart()>'.$text.'</a>';
        
        return $content . $link;
    }
}