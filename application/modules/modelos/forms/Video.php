<?php

class Modelos_Form_Video extends Zend_Form
{

    public function init()
    {

        $this->setName('FormVideo')
             ->setMethod('post')
             ->setAttrib('enctype', 'multipart/form-data')
             ->setAttrib('id', 'FormVideo')
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

        $this->addElement('text', 'titulo', array(
            'label'     => 'Titulo :',
            'required'  => true,
            'filters'   => array('StringTrim', 'StripTags'),
            'validates' => array('alpha')
        ));
        
        $video = new Neo_Form_Element_Youtube('video');

        $video->setLabel('File :')
             ->setRequired(true)
             ->setValueDisabled(true)
             ->setDestination( APPLICATION_PATH . '/../public/' )
             ->addValidator('Count', true, 1)
             //->addValidator('Extension', true, 'mp4,avi,mpg')
             ->addPrefixPath('Neo_Form_Decorator', 'Neo/Form/Decorator/', 'decorator')
             ->setDecorators(array('File', 'Label', array('Uploadify', array( 'text' => 'Upload' ))))
             ->create();
        $this->addElement($video);
    }
}