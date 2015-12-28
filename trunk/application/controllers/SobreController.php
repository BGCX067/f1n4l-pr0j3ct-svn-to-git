<?php

class SobreController extends Zend_Controller_Action{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction(){
        $this->view->headTitle('Sobre nós');

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
        
		$menuModel = new Application_Model_Menus();

            $menu = $menuModel->fetchAll(
                                    $menuModel->select()
                                    ->where('id_menu = 1')
									);        
    $this->view->menu = $menu;
    }

}

