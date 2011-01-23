<?php
/**
*
* @author Neozeratul
* @email neozeratul@gmail.com
*/

class Neo_Form_Element_FileYoutube extends Zend_Form_Element_File
{
    public function init()
    {
        $this->getView()->headLink()->appendStylesheet( $this->getView()->baseUrl() . '/css/uploadify.css');
        $this->getView()->headScript()->appendFile( $this->getView()->baseUrl() . '/scripts/lib/jquery.uploadify.js')
                                      ->appendScript($this->getJavaScript());
        
        $this->addPrefixPath('Neo_Form_Decorator', 'Neo/Form/Decorator/', 'decorator')
             ->setRequired(true)
             ->setDecorators(array(
                 array('Label', array('tag' => 'div')),
                 'File',
                 array('FileYoutube')));
    }

    /**
    * Create JavaScript code to load Uploadify
    * Options http://www.uploadify.com/documentation/
    * Automatically setup options:
    * 'sizeLimit', 'fileExt', 'fileDataName', 'script', 'scriptData'
    * Custom options:
    * 'myShowUpload' - bool - determinates if upload link will be displayed
    *
    * @param array $options
    */
    public function getJavaScript()
    {
        $elementID = $this->getId();
        

        $script = '
            $(function() {
                    $("#' . $elementID . '").fileUpload({
                            \'uploader\': \'' . $this->getView()->baseUrl() . '/flash/uploader.swf' . '\',
                            \'cancelImg\': \'' . $this->getView()->baseUrl() . '/images/uploadify/cancel.png' . '\',
                            \'script\': \''.$this->getView()->baseUrl().'/uploadify.php\',
                            \'folder\': \'public\',
                            \'removeCompleted\' : true,
                            \'auto\' : true,
                            \'buttonText\' : \'Upload\',
                            \'displayData\': \'percentage\',
                            onComplete: function (evt, queueID, fileObj, response, data) {
                                alert("Successfully uploaded: " + data);
                            }
                    });
            });';
        return $script;
    }
}