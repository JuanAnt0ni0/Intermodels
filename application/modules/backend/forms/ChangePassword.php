<?php

class Backend_Form_ChangePassword extends Zend_Form
{
    public function init()
    {
        $this->setName('formPassword')
            ->setMethod('post')
            ->setAttrib('id', 'formPassword')
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

        $this->addElement('password', 'password', array(
            'label' => 'Nueva Password :',
            'required' => true,
            'filters' => array('StringTrim', 'StripTags')
        ));

        $this->addElement('password', 'passwordConfirm', array(
            'label' => 'Confirmación Password :',
            'required' => true,
            'filters' => array('StringTrim', 'StripTags'),
            'validators' => array(
                array('identical', false, array('token' => 'password'))
             )
        ));

        $this->addElement('submit', 'cambiar', array(
            'label' => 'Cambiar',
            'decorators' => array(
                array('ViewHelper'),
                array('HtmlTag', array('tag' => 'div'))
            )
        ));
    }
        
}