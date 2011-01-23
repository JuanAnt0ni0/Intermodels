<?php

class Neo_Form_Youtube extends Zend_Form
{
    function init()
    {
        $this->setName('FormYoutube')
             ->setMethod('post')
             ->setAttrib('accept-charset', 'UTF-8')
             ->setAttrib('enctype', 'multipart/form-data')
             ->setAttrib('id', 'FormYoutube')
             ->clearDecorators()
             ->addDecorator('FormElements')
             ->addDecorator('HtmlTag', array('tag' => 'div'))
             ->addDecorator('Form')
             ->setElementDecorators(array(
                array('ViewHelper'),
                array('Errors'),
                array('Label', array('tag' => 'div')),
                array('HtmlTag', array('tag' => 'div')),
            ));

        $this->addElement('text', 'titulo', array(
            'label'     => 'Titulo :',
            'required'  => true,
            'filters'   => array('StringTrim', 'StripTags'),
            'validates' => array('alpha')
        ));

        $this->addElement('textarea', 'descripcion', array(
            'label'     => 'Descripción :',
            'required'  => true,
            'filters'   => array('StringTrim', 'StripTags'),
            'validates' => array('alpha'),
            'attribs' => array('rows' => 3, 'cols' => 18)
        ));

        $file = new Neo_Form_Element_FileYoutube('video');
        $file->setLabel('File : ');
        $this->addElement($file);

        
    }
}