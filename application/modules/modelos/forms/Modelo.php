<?php

class Modelos_Form_Modelo extends Neo_Doctrine_Form
{
    public function init()
    {
        parent::init('Modelo');

        $this->setName('FormModelo')
             ->setMethod('post')
             ->setAttrib('id', 'FormModelo')
             ->clearDecorators()
             ->addDecorator('FormElements')
             ->addDecorator('HtmlTag', array('tag' => 'div'))
             ->addDecorator('Form')
             ->setElementDecorators(array(
                array('ViewHelper'),
                array('Errors'),
                array('Label', array('tag' => 'div')),
                array('HtmlTag', array('tag' => 'div') ),
            ));

        $guardar = new Zend_Form_Element_Submit('guardar',array('label' => 'Guardar'));
	$guardar->addDecorators(array(
            array('HtmlTag', array('tag' => 'div'))
	));

       	$this->addElement($guardar);
    }
}