<?php

class GaleriaController extends Zend_Controller_Action{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction(){
        $this->view->headTitle('Galeria');

        $galeriasModel = new Application_Model_Galerias();

        $nome_galerias = $galeriasModel->fetchAll(
                                    $galeriasModel->select()
                                		->from($galeriasModel->info(Zend_Db_Table_Abstract::NAME))
                                		->columns(array('nome'))
										->where('excluido = 0')
                                    );
		$this->view->nome_galerias = $nome_galerias;
		
        $galeriaModel = new Application_Model_Galeria();
        $busca = $this->_request->getParam('galeria');
//		$this->view->busca = $nome_evento;
        
		$galeria = $galeriaModel->fetchAll(
                                    $galeriaModel->select()
                                    ->where('galeria LIKE :busca')
                                    ->where('excluido = 0')
                                    ->bind(array(
                                        'busca' => '%' . $busca . '%'
                                    ))
            );
		$this->view->galeria = $galeria;

    }
}

