<?php
class Neo_Controller_Action_Helper_NeoFlashMessenger extends Zend_Controller_Action_Helper_FlashMessenger
{
    const ERROR     = 'error';
    const WARNING   = 'warning';
    const NOTICE    = 'notice';
    const SUCCESS   = 'success';

    /**
     * $_namespace - Instance namespace, default is 'default'
     *
     * @var string
     */
    protected $_namespace = 'default';

    public function addError($message, $class = null, $method = null)
    {
        return $this->_addMessage($message, self::ERROR, $class, $method);
    }

    public function addSuccess($message, $class = null, $method = null)
    {
        return $this->_addMessage($message, self::SUCCESS, $class, $method);;
    }

    public function addWarning($message, $class = null, $method = null)
    {
	return $this->_addMessage($message, self::WARNING, $class, $method);;
    }

    public function addNotice($message, $class = null, $method = null)
    {
        return $this->_addMessage($message, self::NOTICE, $class, $method);;
    }

    protected function _addMessage($message, $type, $class = null, $method = null)
    {
        if (self::$_messageAdded === false) {
            self::$_session->setExpirationHops(1, null, true);
	}

        if (!is_array(self::$_session->{$this->_namespace})) {
            self::$_session->{$this->_namespace}[$type] = array();
	}

        self::$_session->{$this->_namespace}[$type][] = $this->_factory($message, $type, $class, $method);
	return $this;
    }

    protected function _factory($message, $type, $class = null, $method = null)
    {
        $messg = new stdClass();
	$messg->message = $message;
	$messg->type = $type;
	$messg->class = $class;
	$messg->method = $method;
	return $messg;
    }

    /**
     * getMessages() - Get messages from a specific namespace
     *
     * @param unknown_type $namespace
     * @return array
     */
    public function getMessages($type = null)
    {
        if($type === null){
            return parent::getMessages();
	}

        if (isset(self::$_messages[$this->_namespace][$type])) {
            return self::$_messages[$this->_namespace][$type];
	}

        return array();
    }

    /**
     * getCurrentMessages() - get messages that have been added to the current
     * namespace within this request
     *
     * @return array
     */
    public function getCurrentMessages($type = null)
    {
        if($type === null){
            return parent::getCurrentMessages();
        }

        if (isset(self::$_session->{$this->_namespace}[$type])) {
            return self::$_session->{$this->_namespace}[$type];
	}

        return array();
    }
}