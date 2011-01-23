<?php

class Neo_View_Helper_ButtonTwitter extends Zend_View_Helper_Abstract
{

    public function buttonTwitter($url,$titulo)
    {
        return "<a href='http://twitter.com/share'
            class='twitter-share-button'
            data-url='".$url."'
            data-text='".$titulo."'
            data-count='horizontal'
            data-via='vpuaoficial' data-related='@Neozeratul:Developer' data-lang='es'>Tweet</a>
            <script type='text/javascript' src='http://platform.twitter.com/widgets.js'></script>";
    }
}
