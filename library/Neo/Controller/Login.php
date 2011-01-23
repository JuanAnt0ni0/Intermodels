<?php
class Neo_Controller_Login extends Zend_Controller_Action
{
    const NOT_IDENTITY       = 'notIdentity';
    const INVALID_CREDENTIAL = 'invalidCredential';
    const INVALID_USER       = 'invalidUser';
    const INVALID_LOGIN      = 'invalidLogin';

    /**
     * Mensaje de validaciones por defecto
     *
     * @var array
     */
    protected $_message = array(
        'notIdentity'       => 'Not existent identity. A record with the supplied identity could not be found.',
        'invalidCredential' => 'Invalid credential. Supplied credential is invalid.',
        'invalidUser'       => 'Invalid User. Supplied credential is invalid',
        'invalidLogin'      => 'Invalid Login. Fields are empty'
        );

    /**
     * FlashMessenger
     *
     * @var Zend_Controller_Action_Helper_NeoFlashMessenger
     */
    protected $_flashMessenger = null;

    /**
     * Url de Login
     *
     * @var string
     */
    protected $_returnLogin;

    /**
     * Url de Logout
     *
     * @var string
     */
    protected $_returnLogout;

    /**
     * Nombre del modulo donde se realiza el login
     *
     * @var string
     */
    protected $_module;

    /**
     * Objeto Zend_Auth
     *
     * @var Zend_Auth
     */
    protected $_auth;

    public function init()
    {
        $this->_flashMessenger = $this->_helper->getHelper('NeoFlashMessenger');
        $this->_module = $this->getRequest()->getModuleName();
        $this->_returnLogin  = "/".$this->_module."/login";
        $this->_returnLogout = "/".$this->_module;
        $this->_auth = Zend_Auth::getInstance();
        //$this->_auth->setStorage(new Zend_Auth_Storage_Session('Neo_Auth'));
    }

    public function indexAction()
    {
        $auth = Zend_Auth::getInstance();
        
        if ($auth->hasIdentity()) {
            $this->_redirect($this->_returnLogin);
        }

        $formLogin = new Backend_Form_Login();
        $formLogin->setAction($this->view->baseUrl().$this->_returnLogin);
        if ($this->getRequest()->isPost()) {

            if(!$formLogin->isValid($this->_request->getPost())){
                $formLogin->populate($this->_request->getPost());
                $this->view->formLogin = $formLogin;
            } else {
                $username = $this->getRequest()->getParam('username', '');
                $password = $this->getRequest()->getParam('password', '');

                $this->authenticate($username, $password);
                
                if ($this->_auth->hasIdentity()) {
                    $this->_redirect("/$this->_module");
                } else {
                    $this->_redirect($this->_returnLogin);
                }
            }
        }
        $this->view->formLogin = $formLogin;
    }

    public function authenticate($username, $password)
    {
        $doctrineAuthAdapter = new Neo_Doctrine_Auth_Adapter(
            Doctrine_core::getConnectionByTableName('Usuario')
        );

        $doctrineAuthAdapter->setTableName('Usuario u')
            ->setIdentityColumn('u.email')
            ->setCredentialColumn('u.password')
            ->setIdentity($username)
            ->setCredential(md5($password));
        
        if('backend' === $this->_module){
            //$doctrineAuthAdapter->setCredentialTreatment("MD5(?) AND c.status = true AND c.admin = true");
        } else {
            //$doctrineAuthAdapter->setCredentialTreatment("MD5(?) AND c.status = true AND c.admin = false");
        }
        
        $authResult = $this->_auth->authenticate($doctrineAuthAdapter);

        switch ($authResult->getCode())
        {
            case Zend_Auth_Result::FAILURE_IDENTITY_NOT_FOUND:
                $this->_flashMessenger->addError($this->_message[self::NOT_IDENTITY]);
		break;

            case Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID:
                $this->_flashMessenger->addError($this->_message[self::INVALID_CREDENTIAL]);
		break;

            case Zend_Auth_Result::SUCCESS:
                if ($authResult->isValid()) {
                    $identity = $doctrineAuthAdapter->getResultRowObject('id', 'password', 'admin');
                    $this->_auth->getStorage()->write($identity);
		} else {
                    $this->_flashMessenger->addError($this->_message[self::INVALID_USER]);
		}
		break;

            default:
                $this->_flashMessenger->addError($this->_message[self::INVALID_LOGIN]);
		break;
	}

        return $this->_auth;

    }

    public function logoutAction()
    {
        Zend_Auth::getInstance()->clearIdentity();
        $this->_redirect($this->_returnLogout);
    }
}
?>
