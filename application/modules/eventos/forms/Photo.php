<?php

class Eventos_Form_Photo extends Zend_Form
{

    public function init()
    {

        $this->setName('FormPhoto')
             ->setMethod('post')
             ->setAttrib('enctype', 'multipart/form-data')
             ->setAttrib('id', 'FormPhoto')
             ->clearDecorators()
             ->setAttrib('accept-charset', 'UTF-8')
             ->addDecorator('FormElements')
             ->addDecorator('HtmlTag', array('tag' => 'div'))
             ->addDecorator('Form')
             ->setElementDecorators(array(
                array('ViewHelper'),
                array('Errors'),
                array('Label', array('tag' => 'div')),
                array('HtmlTag', array('tag' => 'div') ),
            ));

        $this->addElement('text', 'descripcion', array(
            'label'     => 'Descripcion :',
            'required'  => true,
            'filters'   => array('StringTrim', 'StripTags'),
            'validates' => array('alpha')
        ));

        $foto = new Zend_Form_Element_File('photo');
        $foto->setLabel('Foto :')
             ->setRequired(true)
             //->setValueDisabled(true)
             ->setDestination( APPLICATION_PATH . '/../public/' )
             ->addValidator('Count', true, 1)
             ->addValidator('Size', true, 5120000)
             ->addValidator('Extension', true, 'jpg,png,gif')
             ->addPrefixPath('Neo_Form_Decorator', 'Neo/Form/Decorator/', 'decorator');
             //->create();
        $this->addElement($foto);

         $this->addElement('submit', 'guardar', array(
            'label' => 'Guardar',
            'decorators' => array(
                array('ViewHelper'),
                array('HtmlTag', array('tag' => 'div'))
            )
        ));

    }

}