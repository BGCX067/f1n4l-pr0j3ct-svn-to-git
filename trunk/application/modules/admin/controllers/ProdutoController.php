<?php

class Admin_ProdutoController extends Zend_Controller_Action
{

    public function init(){
        /* Initialize action controller here */
    }

    public function indexAction(){

		$produtoModel = new Application_Model_Produto();

        $this->view->produto = $produtoModel->fetchAll(
                        $produtoModel->select()->where('excluido = 0')
												->order('id_produto DESC')

        );

        $busca = $this->_request->getParam('busca');
        $produto = $this->_request->getParam('produto');

    }
    public function adicionarAction() {
        require_once APPLICATION_PATH . '/modules/admin/forms/Produto.php';
        $this->view->form = new admin_Form_Produto();

        if ($this->_request->isPost()) {
		
            $upload = $this->view->form->pFoto->getTransferAdapter();
            $upload->addValidator('Size', false, array('0kB', '2mB'));
            $upload->addValidator('Extension', false, array('gif', 'jpg', 'png'));

            $uploaded = false;
            if ($upload->isValid()) {
                if ($upload->receive()) {
                    $uploaded = true;
                }
            }
			
            $this->view->form->setDefaults($this->_request->getPost());

            $data = $this->view->form->getValues();

            if ($this->view->form->isValid($data)) {

                $produtoModel = new Application_Model_Produto();

                unset($data['pFoto']);

                $data['preco'] = str_replace(array(',', '.'), '', $data['preco']);

                $id = $produtoModel->insert($data);

				if ($uploaded) {
                    $filter = new Zend_Filter_File_Rename(array('target' => APPLICATION_PATH . '/../public/img/produtos/' . $id . '.jpg', 'overwrite' => true));
                    $filter->filter($upload->getFileName());

					Zend_Loader::loadClass('Imagem');

					$Pasta  = "img/produtos/";
					$nomeArquivo = $id . '.jpg';
					$Largura = '250';
					$Altura = '250';


					$MetodoRedimencionar = 2;

					$CorFundo = null;

					$Imagem = new Imagem($Pasta . $nomeArquivo);
					$Imagem->Ponteiro = '';
					$Imagem->Redimencionar($Largura, $Altura, $MetodoRedimencionar, $CorFundo);
					$Imagem->Salvar( $Pasta . $nomeArquivo);
                }
                return $this->_helper->redirector('index');
            }
        }
    }
	
	public function removerAction() {
        $id = $this->_request->getParam('id');
        $confirma = $this->_request->getParam('confirma');

		if(isset($confirma)){
			if($confirma == 1){
				$produtoModel = new Application_Model_Produto();

				$produtoModel->update(array(
					'excluido' => '1'
						), 'id_produto = ' . $id);

				unlink(APPLICATION_PATH . '/../produtos/' . $id . '.jpg');
			}
			return $this->_helper->redirector('index');
		}else{
		    $this->view->id = $this->_request->getParam('id');

			$produtoModel = new Application_Model_Produto();

			$nome_produto = $produtoModel->fetchAll(
										$produtoModel->select()
											->from($produtoModel->info(Zend_Db_Table_Abstract::NAME))
											->columns(array('nome'))
											->where('id_produto = ?', $id)
										);
			$this->view->produto = $nome_produto;		
		}
    }
	
	public function editarAction() {
        $id = $this->_request->getParam('id');

        require_once APPLICATION_PATH . '/modules/admin/forms/Produto.php';
        $this->view->form = new admin_Form_Produto();

        $produtoModel = new Application_Model_Produto();

        if ($this->_request->isPost()) {

		    $upload = $this->view->form->pFoto->getTransferAdapter();
            $upload->addValidator('Size', false, array('0kB', '2mB'));
            $upload->addValidator('Extension', false, array('gif', 'jpg', 'png'));

            $uploaded = false;
            if ($upload->isValid()) {
                if ($upload->receive()) {
                    $uploaded = true;
                }
            }

            $this->view->form->setDefaults($this->_request->getPost());

            $data = $this->view->form->getValues();

            if ($this->view->form->isValid($data)) {

				unset($data['pFoto']);

                $data['preco'] = str_replace(array(',', '.'), '', $data['preco']);

                $produtoModel->update($data, 'id_produto = ' . $id);

				if ($uploaded) {
                    $filter = new Zend_Filter_File_Rename(array('target' => APPLICATION_PATH . '/../public/img/produtos/' . $id . '.jpg', 'overwrite' => true));
                    $filter->filter($upload->getFileName());
					
					Zend_Loader::loadClass('Imagem');

					$Pasta  = "img/produtos/";
					$nomeArquivo = $id . '.jpg';
					$Largura = '250';
					$Altura = '250';


					$MetodoRedimencionar = 2;

					$CorFundo = null;

					$Imagem = new Imagem($Pasta . $nomeArquivo);
					$Imagem->Ponteiro = '';
					$Imagem->Redimencionar($Largura, $Altura, $MetodoRedimencionar, $CorFundo);
					$Imagem->Salvar( $Pasta . $nomeArquivo);

                }

                return $this->_helper->redirector('index');
            }
        }

        $produto = $produtoModel->find($id)->current();

        $this->view->form->setDefaults($produto->toArray());
    }

}

