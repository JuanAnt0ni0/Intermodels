<?php

class Neo_View_Helper_PlayerMedia extends Zend_View_Helper_Abstract
{
    
    public function playerMedia($elementId, $options = null)
    {
        //$this->view->headScript()->prependFile( 'http://ajax.googleapis.com/ajax/libs/swfobject/2.2/swfobject.js' );
        
        $script  = '<div id=\'' . $elementId . '\' class="' . $options['class'] . '"></div>';
        $script .= '<script type=\'text/javascript\'>';
        $script .= 'var flashvars = {};' . "\n";

        $script .= $this->getOpciones($options);

        if($options['type'] == 'music'){
            //$swf = 'playerAudio';
            $swf = 'playerMedia';            
            $options['width']  = 300;
            $options['height'] = 30;
        } else {
            $swf = 'playerMedia';
            $options['width']  = (int) ($options['width']) ? $opcions['width']  : '480';
            $options['height'] = (int) ($options['height'])? $options['height'] : '270';
        }

        $script .= '
                flashvars.author = "Intermodels";
                var params = {};
                params.wmode = "transparent";
                params.allowfullscreen = "true";
                params.allowscriptaccess = "always";
                var attributes = {};
                attributes.id = "playerJW";
                swfobject.embedSWF("'.$this->view->baseUrl().'/flash/' . $swf . '.swf",
                    "' . $elementId .'",
                    "' . $options['width'] . '",
                    "' . $options['height'] . '",
                    "9.0.0",
                    false,
                    flashvars,
                    params,
                    attributes);';
        $script .= '</script>';

        return $script;
    }

    private function getOpciones($options = null)
    {
        foreach ($options as $k => $v)
        {
            if( !( ($k == 'width') || ($k == 'height') || ($k == 'type') || ($k == 'class') ) ){
                $script .= 'flashvars.'.$k.' = "' . $v . '",' . "\n";
            }
        }
        
        return $script;
        /*
        opciones['width', '480'];
        opciones['height, '270'];
        opciones['author','Autor'];
        opciones['description','Descripcion'];
        opciones['file','http://www.youtube.com/watch%3Fv%3DIBTE-RoMsvw'];
        opciones['image','http://url del la image'];
        opciones['start','start'];
        opciones['title','Titulo'];
        opciones['provider','provedor'];
        opciones['backcolor','666666'];
        opciones['frontcolor','003300'];
        opciones['lightcolor','0000CC'];
        opciones['screencolor','AAAAAA'];
        opciones['volume','10'];
        opciones['controlbar','top'];
        opciones['playlist','right'];
        */
    }
}