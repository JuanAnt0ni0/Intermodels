<?php
/**
* Zend Framework Uplaodify Extension
*
* @author gondo
* @email gondo@webdesigners.sk
* @link http://gondo.webdesigners.sk/zend-framework-uploadify-extension
* @license WTFPL http://en.wikipedia.org/wiki/WTFPL
*
*/

class Neo_Form_Element_File extends Neo_Form_Element_Uploadify
{
    public function setup()
    {
        $elementID = $this->getId();

        $options = array(
            'uploader' => $this->getView()->baseUrl() . '/flash/uploader.swf',
            'cancelImg' => $this->getView()->baseUrl() . '/images/uploadify/cancel.png',
            'multi' => 0,
            'auto' => 0,
            'removeCompleted' => 0,
            'buttonText' => 'buttonText',
            'displayData' => 'percentage',
            'queueSizeLimit' => 1,
            'scriptData' => "{'modelo' : '1'}",
            'onProgess'  => 'function(event,ID,fileObj,data) {
                var bytes = Math.round(data.bytesLoaded / 1024);
                $(\'#\' + $(event.target).attr(\''.$elementID.'\') + ID).find(\'.percentage\').text(\' - \' + bytes + \'KB Uploaded\');
                return false;
             }',
            'onComplete' => 'function(evt, queueID, fileObj, response, data) {
                alert("Successfully uploaded: " + response);
             }'
        );
        
        $this->getView()->headLink()->appendStylesheet( $this->getView()->baseUrl() . '/css/uploadify.css', 'screen');
        $this->getView()->headScript()->appendFile( $this->getView()->baseUrl() . '/scripts/lib/jquery.uploadify.js')
                                      ->appendScript($this->getJavaScript($options));

        $this->addFilter('rename', $this->getRandomFileName());
    }
}