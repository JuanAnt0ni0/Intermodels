<?php

class Neo_Form_Element_Time extends Zend_Form_Element_Text
{
    public function init()
    {
        $this->getView()->headScript()->appendFile( $this->getView()->baseUrl() . '/scripts/lib/timeentry.js')
             ->appendScript($this->getJavaScript($options));
    }

    /**
    *
    * @param array $options
    */
    public function getJavaScript($options = null) 
    {
        $elementID    = $this->getId();
        
        $script = '
            $(document).ready(function() {
                $("#' . $elementID . '").timeEntry({
                    show24Hours: true,
                    appendText: \' &nbsp; Ejm: 13:45\',
                    spinnerImage: \'\'
                });
            });';
        
        return $script;
    }
}