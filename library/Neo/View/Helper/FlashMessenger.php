<?php

class Neo_View_Helper_FlashMessenger extends Zend_View_Helper_FormElement
{
    private $_types = array(
        Neo_Controller_Action_Helper_NeoFlashMessenger::ERROR,
        Neo_Controller_Action_Helper_NeoFlashMessenger::WARNING,
        Neo_Controller_Action_Helper_NeoFlashMessenger::NOTICE,
        Neo_Controller_Action_Helper_NeoFlashMessenger::SUCCESS
    );

    public function flashMessenger()
    {
        $flashMessenger = Zend_Controller_Action_HelperBroker::getStaticHelper('NeoFlashMessenger');
	$html = '';

        foreach ($this->_types as $type) {
            $messages = $flashMessenger->getMessages($type);
            if (!$messages){
                $messages = $flashMessenger->getCurrentMessages($type);
            }

            if ($messages) {
                if ( !$html ) {
                    $html .= '<ul class="messages">';
                }

                $html .= '<li class="' . $type . '-msg">';
		$html .= '<ul>';
		foreach ( $messages as $message ) {
                    $html.= '<li>';
                    $html.= $message->message;
                    $html.= '</li>';
		}
		$html .= '</ul>';
		$html .= '</li>';
            }
        }
	if ( $html) {
            $html .= '</ul>';
	}

        return $html;
    }
}