<?php

class Neo_View_Helper_ReplaceSpace extends Zend_View_Helper_Abstract{

    public function replaceSpace($string)
    {
        return str_replace(" ", "_", $string);
    }
}
