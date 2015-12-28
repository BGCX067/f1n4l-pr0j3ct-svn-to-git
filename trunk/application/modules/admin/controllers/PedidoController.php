<?php

class Admin_PedidoController extends Zend_Controller_Action
{

    public function init(){
        /* Initialize action controller here */
    }

    public function indexAction(){
        $pedidoModel = new Application_Model_Pedido();

        $this->view->pedido = $pedidoModel->fetchAll(
                        $pedidoModel->select()
						->order('id_pedido DESC')
        );

        $busca = $this->_request->getParam('busca');
    }

    public function concluidoAction(){
        $pedidoModel = new Application_Model_Pedido();

        $this->view->pedido = $pedidoModel->fetchAll(
                        $pedidoModel->select()
						->order('id_pedido DESC')
        );

        $busca = $this->_request->getParam('busca');
    }

	public function visualizarAction(){
        $busca = $this->_request->getParam('id');

        $prodpedModel = new Application_Model_ProdutoPedido();
		
		$dados = $prodpedModel->fetchAll(
			$prodpedModel->select()
				->where('id_pedido = ?', $busca)
		);

		$this->view->pedido = $dados;
    }

 	public function enderecoAction(){

        $busca = $this->_request->getParam('id');
					$usuarioModel = new Application_Model_Usuario();
						$user = $usuarioModel->fetchAll(
											$usuarioModel->select()
												->from($usuarioModel->info(Zend_Db_Table_Abstract::NAME))
												->columns(array('usuario'))
												->where('idusuario = ?', $busca)
											);
											
        $enderecoModel = new Application_Model_Endereco();
		
		$dados = $enderecoModel->fetchAll(
			$enderecoModel->select()
				->where('usuario = ?', $user[0]['usuario'])
		);

		$this->view->dados = $dados;
    } 

    public function esperaAction() {
        $id = $this->_request->getParam('id');

        $pedidoModel = new Application_Model_Pedido();

        $pedidoModel->update(array(
            'estado' => '0'
                ), 'id_pedido = ' . $id);

        return $this->_helper->redirector('index');
    }

    public function andamentoAction() {
        $id = $this->_request->getParam('id');

        $pedidoModel = new Application_Model_Pedido();

        $pedidoModel->update(array(
            'estado' => '1'
                ), 'id_pedido = ' . $id);

        return $this->_helper->redirector('index');
    }

    public function concluirAction() {
        $id = $this->_request->getParam('id');

        $pedidoModel = new Application_Model_Pedido();

        $pedidoModel->update(array(
            'estado' => '2'
                ), 'id_pedido = ' . $id);

        return $this->_helper->redirector('index');
    }

    public function entregaAction() {
        $id = $this->_request->getParam('id');

        $pedidoModel = new Application_Model_Pedido();

        $pedidoModel->update(array(
            'estado' => '3'
                ), 'id_pedido = ' . $id);

        return $this->_helper->redirector('index');
    }

    public function entregueAction() {
        $id = $this->_request->getParam('id');

        $pedidoModel = new Application_Model_Pedido();

        $pedidoModel->update(array(
            'estado' => '4'
                ), 'id_pedido = ' . $id);

        return $this->_helper->redirector('index');
    }
	
}

