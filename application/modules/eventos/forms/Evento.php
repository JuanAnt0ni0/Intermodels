<?php

class Eventos_Form_Evento extends Neo_Doctrine_Form
{
    public function init()
    {
        parent::init('Evento');
        
        $this->setName('FormEvento')
             ->setMethod('post')
             ->setAttrib('id', 'FormEvento')
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

