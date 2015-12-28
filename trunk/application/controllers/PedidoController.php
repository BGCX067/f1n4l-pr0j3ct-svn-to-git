<?php

class PedidoController extends Zend_Controller_Action{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction(){
        $this->view->headTitle('Área do Cliente - Pedidos');

    }

    public function ultimosAction(){
        $this->view->headTitle('Área do Cliente - Últimos Pedidos');
		
		Zend_Loader::loadClass('Zend_Auth');
		$authClass = Zend_Auth::getInstance();
			
		if ($authClass->hasIdentity()) {
			$auth = $authClass->getStorage()->read();
				
			$idx = $auth['usuario_id'];
		}

		$pedidoModel = new Application_Model_Pedido();

        $this->view->pedido = $pedidoModel->fetchAll(
                        $pedidoModel->select()
						->where('cliente = ?',$idx)
						->order('id_pedido DESC')
        );


    }

	public function refazerAction(){
        $busca = $this->_request->getParam('id');

        $confirma = $this->_request->getParam('confirma');

		if(isset($confirma)){
			$this->view->visualiza = 0;

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



			$pedidoModel = new Application_Model_Pedido();

			$old_pedido = $pedidoModel->fetchAll(
                        $pedidoModel->select()
						->where('id_pedido = ?',$busca)
			);
						
			$key=random_generator(10);
			$key=md5($key);
			$date = date_create();
			$date0 = date_format($date, 'c');

			$novo_pedido = array();
			$novo_pedido['cliente'] = $old_pedido[0]['cliente'];
			$novo_pedido['valor'] = $old_pedido[0]['valor'];
			$novo_pedido['secure'] = $key;
			$novo_pedido['data'] = $date0;
			
			$id = $pedidoModel->insert($novo_pedido);
			$pedido_id = $pedidoModel->fetchAll(
				$pedidoModel->select()->where('secure = ?',$key)
			);
			
			$nova_id = $pedido_id[0]['id_pedido'];
			
			$prodpedModel = new Application_Model_ProdutoPedido();
				$produtos = $prodpedModel->fetchAll(
					$prodpedModel->select()
					    ->from($prodpedModel->info(Zend_Db_Table_Abstract::NAME))
                        ->columns(array('id_produto', 'id_adicionais'))
						->where('id_pedido = ?',$busca)
			);
			$prodz = array();
			$maismais = 0;
			foreach ($produtos as $produto){
				$prodz[$maismais]['id_pedido'] = $nova_id;
				$prodz[$maismais]['id_produto'] = $produto['id_produto'];
				$prodz[$maismais]['id_adicionais'] = $produto['id_adicionais'];
				$id = $prodpedModel->insert($prodz[$maismais]);
				$maismais++;
			}
			$this->view->aviso = 'Pedido enviado com sucesso!';
			
			
			}else{
			$this->view->visualiza = 1;

			$busca = $this->_request->getParam('id');

			$prodpedModel = new Application_Model_ProdutoPedido();
			
			$dados = $prodpedModel->fetchAll(
				$prodpedModel->select()
					->where('id_pedido = ?', $busca)
			);

			$this->view->pedido = $dados;

		}
    }
}

