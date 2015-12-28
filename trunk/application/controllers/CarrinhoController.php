<?php

class CarrinhoController extends Zend_Controller_Action{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction(){
        $this->view->headTitle('Carrinho');

        $categoriaModel = new Application_Model_Categoria();

        $nome_categorias = $categoriaModel->fetchAll(
                                    $categoriaModel->select()
                                		->from($categoriaModel->info(Zend_Db_Table_Abstract::NAME))
                                		->columns(array('nome_categoria'))
                                    );
		$this->view->categorias = $nome_categorias;

        $sessao = new Zend_Session_Namespace('SESSAO_CARRINHO');

		if (!isset($sessao->produtos)) {
            $sessao->produtos = array();
        }
		
		foreach($_POST as $key=>$value)
		{
			$sessao->produtos[$key]=$value;
		}

		if (isset($sessao->produtos) && sizeof($sessao->produtos) > 0) {
			foreach($sessao->produtos as $chave => $id){
				$ingredientes[$id] = array();
				
				$ingredModel = new Application_Model_Relacionamentos();

				$dados = $ingredModel->fetchAll(
								$ingredModel->select()->where('excluido = 0')
											  ->where('id_produto = ?',$id)
				);
				foreach($dados as $chave => $valor){
					$ingredientes[$id][] = $dados[$chave];
				}
			}
            $this->view->ingredientes = $ingredientes;
            $this->view->produtos = $sessao->produtos;
        }
		
		}
		
	public function finalizarAction() {

		Zend_Loader::loadClass('Zend_Auth');
		$authClass = Zend_Auth::getInstance();
			
		if ($authClass->hasIdentity()) {
			$auth = $authClass->getStorage()->read();
				
			$idx = $auth['usuario_id'];
        $usuarioModel = new Application_Model_Usuario();

		$dados = 0;
        $dadosUsuario = $usuarioModel->fetchAll(
                                    $usuarioModel->select()
                                		->from($usuarioModel->info(Zend_Db_Table_Abstract::NAME))
                                		->columns(array('usuario'))
										->where('idusuario = ?',$idx)
                                    );
		$dados = $dadosUsuario[0]['usuario'];
		$contatoModel = new Application_Model_Contato();

        $dadosContato = $contatoModel->fetchAll(
                                    $contatoModel->select()
                                		->from($contatoModel->info(Zend_Db_Table_Abstract::NAME))
                                		->columns(array('completo'))
										->where('usuario = ?',$dados)
										
                                    );
		$this->view->dadosContato = $dadosContato;
		}
        $categoriaModel = new Application_Model_Categoria();

        $nome_categorias = $categoriaModel->fetchAll(
                                    $categoriaModel->select()
                                		->from($categoriaModel->info(Zend_Db_Table_Abstract::NAME))
                                		->columns(array('nome_categoria'))
                                    );
		$this->view->categorias = $nome_categorias;

	    $confirmar = $this->_request->getParam('confirmar');
		
		if(isset($confirmar)){
			if($confirmar == 1){
				$sessao = new Zend_Session_Namespace('SESSAO_CARRINHO');

			    Zend_Loader::loadClass('Zend_Auth');
				$authClass = Zend_Auth::getInstance();
			
				if ($authClass->hasIdentity()) {
					$auth = $authClass->getStorage()->read();
				
					$id = $auth['usuario_id'];
				}
				
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

				$date = date_create();

				$pedido = array();
				$pedido['cliente'] = $auth['usuario_id'];
				$pedido['data'] = date_format($date, 'c');
				$pedido['secure'] = $key;
				$pedido['valor'] = str_replace(array(',', '.'), '', $sessao->total);

				$pedidoModel = new Application_Model_Pedido();
                $id = $pedidoModel->insert($pedido);
				
				$pedido_id = $pedidoModel->fetchAll(
					$pedidoModel->select()->where('secure = ?',$key)
				);


					$pedido_xid = $pedido_id[0]['id_pedido'];
					
					$prodpedModel = new Application_Model_ProdutoPedido();
					$addModel = new Application_Model_Adicionais();

					if(isset($sessao->produtos)){
						foreach($sessao->produtos as $posicao => $id){
							$chave=random_generator(10);
							$chave=md5($chave);

							$prod = array();
							$prod['id_pedido'] = $pedido_xid;
							$prod['id_produto'] = $id;
							$prod['id_adicionais'] = $chave;
							$id = $prodpedModel->insert($prod);
							
							if(isset($sessao->quantidades[$posicao])){
								foreach($sessao->quantidades[$posicao] as $ingred => $quanti){
									$adi = array();
									$adi['id_adicionais'] = $chave;
									$adi['id_adicional'] = $ingred;
									$adi['quantidade'] = $quanti;
									$id = $addModel->insert($adi);
								}
							}
						}
					}
					$sessao->produtos = null;
					$sessao->quantidades = null;
					$sessao->total = null;
					$sessao->ingred = null;

					$email = $dadosContato[0]['email'];
					
					$data = '<html><body><table>
					<tr><td>Online Thru informa: Pedido recebido, valor R$ '. number_format($pedido['valor'] / 100, 2, ',', '.') .'</td></tr>
					</table></body></html>';

					// Using the ini_set()
					ini_set("SMTP", "localhost");
					ini_set("sendmail_from", "willian@mundoorange.com.br");
					ini_set("smtp_port", "587");
					
					$mail = new Zend_Mail('UTF-8', 'ISO-8859-8');
					$mail->setBodyHtml($data)
						->setFrom('willian@mundoorange.com.br', 'Online Thru')
						->addTo($email, 'Online Thru')
						->setSubject('Online Thru - Pedido')
						->send();
						
					$this->view->aviso = "Pedido enviado com sucesso!";

			}
		}else{
			$sessao = new Zend_Session_Namespace('SESSAO_CARRINHO');

			$this->view->produtos = $sessao->produtos;
			
			if (!isset($sessao->ingred)) {
				$sessao->ingred = array();
			}

			if ($this->_request->isPost()) {
				$sessao->ingred = $this->_request->getPost();
				
				foreach($sessao->ingred as $key=>$value)
				{
					$mystring = $key;
					$findme   = 'q';
					$pos = strpos($mystring, $findme);
					if($pos === false){
						$mystring = $key;
						$find   = '-';
						$posi = strpos($mystring, $find);
						$chave = substr($key, 0, $posi);
						$ingr = substr($key, ($posi +1), strlen($key));

						$sessao->ingredientes[$chave][$ingr]=$value;
					}else{
						$key=str_replace('q-','',$key);

						$mystring = $key;
						$find   = '-';
						$posi = strpos($mystring, $find);
						$chave = substr($key, 0, $posi);
						$ingr = substr($key, ($posi +1), strlen($key));
						
						$sessao->quantidades[$chave][$ingr]=$value;
					}
						$idp = $sessao->produtos[$chave]['id_produto'];
						$ingredModel = new Application_Model_Relacionamentos();

							$nome_ingred = $ingredModel->fetchAll(
								$ingredModel->select()
									->from($ingredModel->info(Zend_Db_Table_Abstract::NAME))
									->columns(array('qtd_padrao'))
									->where('id_produto = ?', $idp)
									->where('id_ingrediente = ?', $ingr)
							);
							if(isset($nome_ingred[0]['qtd_padrao'])){
								$padrao[$idp][$ingr] = $nome_ingred[0]['qtd_padrao'];
							}
				}
				
			}
			if (isset($sessao->produtos) && sizeof($sessao->produtos) > 0) {		
				if (isset($padrao)) {
					$this->view->padrao = $padrao;
				}
				if (isset($sessao->quantidades)) {
					$this->view->quantidades = $sessao->quantidades;
				}
				if (isset($sessao->ingredientes)) {
					$this->view->ingredientes = $sessao->ingredientes;
				}
				if (isset($sessao->ingred)) {
					$this->view->data = $sessao->ingred;
				}
			}
		}
	}
	public function removerAction() {
        $id = $this->_request->getParam('id');

        $sessao = new Zend_Session_Namespace('SESSAO_CARRINHO');

		unset($sessao->produtos[$id]);

        return $this->_helper->redirector('index');
    }
    }