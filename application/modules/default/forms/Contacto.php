<?php

class Default_Form_Contacto extends Zend_Form
{
    public function init()
    {
        $this->setName('FormContacto')
             ->setMethod('post')
             ->setAttrib('id', 'FormContacto')
             ->addDecorator('FormElements')
             ->addDecorator('HtmlTag', array('tag' => 'div'))
             ->addDecorator('Form')
             ->setElementDecorators(array(
                array('ViewHelper'),
                array('Errors'),
                array('Label', array('tag' => 'div')),
                array('HtmlTag', array('tag' => 'div') ),
            ));

        $this->addElement('text', 'nombre', array(
            'label'     => 'Nombre :',
            'required'  => true,
            'filters'   => array('StringTrim', 'StripTags'),
            'validates' => array('alpha')
        ));

        $this->addElement('text', 'apellido', array(
            'label'     => 'Apellido :',
            'required'  => true,
            'filters'   => array('StringTrim', 'StripTags'),
            'validates' => array('alpha')
        ));

        $this->addElement('text', 'empresa', array(
            'label'     => 'Empresa :',
            'required'  => true,
            'filters'   => array('StringTrim', 'StripTags'),
            'validates' => array('alpha')
        ));

        $this->addElement('text', 'cargo', array(
            'label'     => 'Cargo :',
            'required'  => true,
            'filters'   => array('StringTrim', 'StripTags'),
            'validates' => array('alpha')
        ));
				
		$this->addElement('text', 'telefono', array(
            'label'     => 'Telefono :',
            'required'  => true,
            'filters'   => array('StringTrim', 'StripTags'),
            'validates' => array('digits')
        ));
				
        $this->addElement('text', 'email', array(
            'label'     => 'E-mail :',
            'required'  => true,
            'filters'   => array('StringTrim', 'StripTags')
        ));
        $this->getElement('email')->addValidator('EmailAddress');
		
		$this->addElement('text', 'asunto', array(
            'label'     => 'Asunto :',
            'required'  => true,
            'filters'   => array('StringTrim', 'StripTags'),
            'validates' => array('alpha')
        ));

        $this->addElement('textarea', 'mensaje', array(
            'label'     => 'Mensaje :',
            'required'  => true,
            'attribs'   => array('rows' => 5, 'cols' => 54),
            'filters'   => array('StringTrim', 'StripTags'),
            'validates' => array('alpha')
        ));

        $guardar = new Zend_Form_Element_Submit('guardar',array('label' => 'Enviar'));
	$guardar->addDecorators(array(
            array('HtmlTag', array('tag' => 'div'))
	));

        $this->addElement($guardar);
    }
}