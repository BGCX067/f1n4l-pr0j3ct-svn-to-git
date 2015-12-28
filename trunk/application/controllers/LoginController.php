<?php

class LoginController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    public function indexAction() {
        Zend_Loader::loadClass('Zend_Auth');
        $authClass = Zend_Auth::getInstance();

        $auth = $authClass->getStorage()->read();

        if (!$authClass->hasIdentity()) {
            if ($this->_request->isPost()) {
                $data = $this->_request->getPost();

                if ($data['usuario']) {
                    $zendDb = Zend_Db_Table_Abstract::getDefaultAdapter();
                    $authAdapter = new Zend_Auth_Adapter_DbTable(
                                    $zendDb,
                                    'usuario',
                                    'usuario',
                                    'senha',
                                    'MD5(?)'
                    );

                    $authAdapter->setIdentity($data['usuario']);
                    $authAdapter->setCredential($data['senha']);

                    $auth = $authAdapter->authenticate();

                    if ($auth->isValid()) {
                        $authData = $authAdapter->getResultRowObject();

                        $authClass->getStorage()->write(array(
                            'usuario_id' => $authData->idusuario
                        ));

						$user = $data['usuario'];
						$usuarioModel = new Application_Model_Usuario();
						$row = $usuarioModel->fetchRow($usuarioModel->select()->where('usuario = ?', $user));
						if($row->tipo == 'administrador'){
							return $this->_helper->redirector('index', 'admin');
						}else{
							if($row->completo == 0){
								return $this->_helper->redirector('index', 'cliente');
							}else{
								return $this->_helper->redirector('index', 'index');
							}
						}
					} else {
                        $this->view->priorityMessenger('Login inválido!', 'Mensagem');
                    }
                }
            }
        }

        return $this->_helper->redirector('index', 'index');
    }

    public function logoutAction() {
        Zend_Loader::loadClass('Zend_Auth');
        $authClass = Zend_Auth::getInstance();

        $auth = $authClass->getStorage()->read();

        $authClass->clearIdentity();

        return $this->_helper->redirector('index', 'index');
    }

	public function redefinirAction() {
        require_once APPLICATION_PATH . '/forms/Redefinir.php';
        $this->view->form = new Application_Form_Redefinir();

		if ($this->_request->isPost()) {

            $this->view->form->setDefaults($this->_request->getPost());

            $data = $this->view->form->getValues();

			$resetModel = new Application_Model_Reset();

			if ($this->view->form->isValid($data)) {
				$row = $resetModel->fetchRow($resetModel->select()->where('usuario = ?', $data['usuario']));
				$id_reset = $row['id_reset'];
				if($row != null){
					$row = $resetModel->fetchRow($resetModel->select()->where('id_reset = ?', $id_reset));
					$row->save();
				    $row->delete();

					$this->view->aviso = 'Sua senha foi redefinida com sucesso';			
				}else{
					$this->view->aviso = 'Erro. Confira os dados e tente novamente.';			
				}
			}
		}
    }
	
    public function esqueciAction() {
        require_once APPLICATION_PATH . '/forms/Esqueci.php';
        $this->view->form = new Application_Form_Esqueci();
		
		    if ($this->_request->isPost()) {

            $this->view->form->setDefaults($this->_request->getPost());

            $data = $this->view->form->getValues();

            $usuarioModel = new Application_Model_Usuario();

            if ($this->view->form->isValid($data)) {

			$resetModel = new Application_Model_Reset();
			$row = $resetModel->fetchRow($resetModel->select()->where('usuario = ?', $data['usuario']));
			if($row != null){
				$this->view->aviso = 'Voce ja pediu um codigo para esse usuario';			
			}else{
			/// function to generate random number ///////////////
			function random_generator($digits){
			srand ((double) microtime() * 10000000);
			//Array of alphabets
			$input = array ("A", "B", "C", "D", "E","F","G","H","I","J","K","L","M","N","O","P","Q",
			"R","S","T","U","V","W","X","Y","Z");
			$random_generator="";// Initialize the string to store random numbers
			for($i=1;$i<$digits+1;$i++){ // Loop the number of times of required digits
			if(rand(1,2) == 1){// to decide the digit should be numeric or alphabet
			// Add one random alphabet 
			$rand_index = array_rand($input);
			$random_generator .=$input[$rand_index]; // One char is added
			}else{
			// Add one numeric digit between 1 and 10
			$random_generator .=rand(1,10); // one number is added
			} // end of if else
			} // end of for loop 
			return $random_generator;
			} // end of function

			$key=random_generator(10);
			$key=md5($key);
			$data['key'] = $key;
			
			$resetModel = new Application_Model_Reset();
            $id = $resetModel->insert($data);
			
			Zend_Loader::loadClass('Zend_Auth');
			$authClass = Zend_Auth::getInstance();

			$auth = $authClass->getStorage()->read();

			$user = $data['usuario'];

			$contatoModel = new Application_Model_Contato();

			$row = $contatoModel->fetchRow($contatoModel->select()->where('usuario = ?', $user));

			$mail = $row['email'];
			
			//envia e-mail
								
				$data = 'Seu código para redefinição de senha é: ' . $key
				. '<br/>Seu usuário é: ' . $user;

				// Using the ini_set()
				ini_set("SMTP", "localhost");
				ini_set("sendmail_from", "willian@mundoorange.com.br");
				ini_set("smtp_port", "587");
				
				$mail = new Zend_Mail('UTF-8', 'ISO-8859-8');
				$mail->setBodyHtml($data)
					->setFrom('willian@mundoorange.com.br', 'Online Thru')
					->addTo($mail, 'Contato')
					->setSubject('Redefinição de senha - Online Thru')
					->send();
					
			$this->view->aviso = 'O código para redefinição de senha foi enviado para o e-mail ' . $mail;
			}
            }
        }

    }

}

