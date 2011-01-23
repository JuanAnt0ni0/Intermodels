<?php

class Backend_Form_Login extends Zend_Form
{
    public function init()
    {
        $this->setName('FormLogin')
             ->setMethod('post')
             ->setAttrib('id', 'FormLogin')
             ->clearDecorators()
             ->setAttrib('accept-charset', 'UTF-8')
             ->addDecorator('FormElements')
             ->addDecorator('HtmlTag', array('tag' => 'fieldset'))
             ->addDecorator('Form')
             ->setElementDecorators(array(
                array('Label', array('tag' => 'strong')),
                array('Description', array('tag' => 'span')),
                array('ViewHelper', array('tag' => 'div')),
                array('Errors'),
                array('HtmlTag', array('tag' => 'div'))
            ));

        $this->addElement('text', 'username', array(
            'label' => 'Username',
            'description' => '*',
            'required' => true,
            'filters' => array('StringTrim', 'StripTags', 'StringToLower'),
            'validators' => array('EmailAddress')
        ));

        $this->addElement('password', 'password', array(
            'label' => ' Password',
            'description' => '*',
            'required' => true,
            'filters' => array('StringTrim', 'StripTags')
        ));

        $this->addElement('submit', 'login', array(
            'label' => 'Login',
            'decorators' => array(
                array('ViewHelper'),
                array('HtmlTag', array('tag' => 'div'))
            )
        ));
    }
}