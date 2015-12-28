<?php

class ContatoController extends Zend_Controller_Action{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction(){
        $this->view->headTitle('Contato');

		$sessao = new Zend_Session_Namespace('SESSAO_CARRINHO');

		if (isset($sessao->produtos)) {
		$carrinhoContador = sizeof($sessao->produtos);
		}else{
		$carrinhoContador = 0;
		}
		
		if($carrinhoContador == 0){
			$this->view->carrinhoImagem = '';
			}else{
				if($carrinhoContador < 5){
				$this->view->carrinhoImagem = $carrinhoContador;
				}else{
					$this->view->carrinhoImagem = 4;
					}
			}
			
        $categoriaModel = new Application_Model_Categoria();

        $nome_categorias = $categoriaModel->fetchAll(
                                    $categoriaModel->select()
                                		->from($categoriaModel->info(Zend_Db_Table_Abstract::NAME))
                                		->columns(array('nome_categoria'))
                                    );
		$this->view->categorias = $nome_categorias;
        
        require_once APPLICATION_PATH . '/forms/Contato.php';
        $this->view->form = new Application_Form_Contato();

	        if ($this->_request->isPost()) {
            $this->view->form->setDefaults($this->_request->getPost());
            $data = $this->view->form->getValues();

            if ($this->view->form->isValid($data)) {
			    $contatosModel = new Application_Model_Contatos();

                $id = $contatosModel->insert($data);

					$data = '<html><body><table>
					<tr><td>Nome</td>
					<td>' . $_POST['nome'] . '</td></tr>
					<tr><td>E-mail</td>
					<td>' . $_POST['email'] . '</td></tr>
					<tr><td>Telefone</td>
					<td>' . $_POST['telefone'] . '</td></tr>
					<tr><td>Texto</td>
					<td>' . $_POST['mensagem'] . '</td></tr>
					</table></body></html>';

				// Using the ini_set()
				ini_set("SMTP", "localhost");
				ini_set("sendmail_from", "willian@mundoorange.com.br");
				ini_set("smtp_port", "587");
				
				$mail = new Zend_Mail('UTF-8', 'ISO-8859-8');
				$mail->setBodyHtml($data)
					->setFrom('willian@mundoorange.com.br', 'Formulario de Contato')
					->addTo('all_sweet_dreams@hotmail.com', 'Contato')
					->setSubject('Contato')
					->send();
					
                return $this->_helper->redirector('index');
            }
        }
	}


}

