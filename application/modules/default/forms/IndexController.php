<?php

class Default_IndexController extends Neo_Controller_Frontend
{

    public function init()
    {
        parent::init();
    }

    public function indexAction()
    {
        
    }

    public function aboutAction()
    {

    }

    public function servicesAction()
    {

    }

     public function perfilesAction()
    {

    }

     public function privacidadAction()
    {

    }

    public function joinAction()
    {

    }

    public function contactAction()
    {
        $formContacto = new Default_Form_Contacto();
        $formContacto->setAction($this->view->url(array(), 'Contact'));

        if ($this->getRequest()->isPost()) {
            $formData = $this->_request->getPost();

            if (!$formContacto->isValid($formData)) {
                $this->view->formContacto = $formContacto;
		$formContacto->populate($formData);
            } else {
               $mensaje = "";
								foreach($formData as $k => $v)
								{
									if( $k != "guardar")
									{
										$mensaje .= ucfirst($k) .': '.$v.'   ';
									}
								}
                $mail = new Zend_Mail();
      $mail->setBodyText($mensaje);
      $mail->setFrom('info@intermodels.es', '[Intermodels-Info]');
      $mail->addTo('info@intermodels.es', 'Info - Intermodels');
      $mail->setSubject('Formulario Contacto');
       $mail->send();
                $this->_flashMessenger->addSuccess('En breve nos pondremos en contacto con Ud.');
                $this->_redirect('/');
            }
	}
	$this->view->formContacto = $formContacto;
    }

    protected function sendmailAction()
    {
       $mail = new Zend_Mail();
      $mail->setBodyText($mensaje);
      $mail->setFrom('info@intermodels.es', '[Intermodels-Info]');
      $mail->addTo('j.romero.at@gmail.com', 'Contacto Intermodels');
      $mail->setSubject('Formulario Contacto');
      $mail->send();
      $this->render('index');
    }

    public function doctrineAction()
    {
        $options = array(
            'phpDocPackage'    => 'Kromatick',
            'phpDocSubpackage' => 'Intermodels',
            'phpDocName'  => 'Neozeratul',
            'phpDocEmail' => 'neozeratul@gmail.com'
        );

        Doctrine::dropDatabases();
        Doctrine::createDatabases();
        Doctrine::generateModelsFromYaml(APPLICATION_PATH . "/data/schema/schema.yml", APPLICATION_PATH . "/models", $options);
        Doctrine::createTablesFromModels();
        //Doctrine::loadData($yamlPath, $append):
        echo Doctrine::generateSqlFromModels();
        $this->render('index');
    }


}