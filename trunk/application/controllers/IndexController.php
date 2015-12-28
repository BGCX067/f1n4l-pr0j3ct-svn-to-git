<?php

class IndexController extends Zend_Controller_Action{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction(){
        $this->view->headTitle('Home');

	    $produtoModel = new Application_Model_Produto();

        $busca = $this->_request->getParam('busca');
		{
            $produto = $produtoModel->fetchAll(
                                    $produtoModel->select()
                                    ->where('nome LIKE :busca')
                                    ->where('promocao = 1')
									->where('excluido = 0')
                                    ->bind(array(
                                        'busca' => '%' . $busca . '%'
                                    ))
            );
        }
		$this->view->produtos = $produto;

    }


}

