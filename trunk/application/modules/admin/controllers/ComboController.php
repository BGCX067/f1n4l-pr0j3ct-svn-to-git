<?php

class Admin_ComboController extends Zend_Controller_Action
{

    public function init(){
        /* Initialize action controller here */
    }

    public function indexAction(){

		$comboModel = new Application_Model_Combo();

        $this->view->combo = $comboModel->fetchAll(
                        $comboModel->select()->where('excluido = 0')
											->order('id_combo DESC')

        );

        $busca = $this->_request->getParam('busca');
    }
    public function adicionarAction() {
        require_once APPLICATION_PATH . '/modules/admin/forms/Combo.php';
        $this->view->form = new admin_Form_Combo();

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

                $comboModel = new Application_Model_Combo();
		        $produtoModel = new Application_Model_Produto();

				unset($data['pFoto']);

                $data['preco'] = str_replace(array(',', '.'), '', $data['preco']);

				 $dados = array();
				 $dados['nome'] = $data['nome'];
				 $dados['preco'] = $data['preco'];
				 $dados['categoria'] = 'Combo';
				 $dados['descricao'] = '';

				$id = $produtoModel->insert($dados);

				$ultProd = $produtoModel->fetchAll(
                    $produtoModel->select()->where('categoria = "Combo"')
											->order('id_produto DESC')
											->limit(1)
				);	

				$data['id_produto_combo']  = $ultProd[0]['id_produto'];
				
                $id = $comboModel->insert($data);

				if ($uploaded) {
                    $filter = new Zend_Filter_File_Rename(array('target' => APPLICATION_PATH . '/../public/img/produtos/' . $ultProd[0]['id_produto'] . '.jpg', 'overwrite' => true));
                    $filter->filter($upload->getFileName());

					Zend_Loader::loadClass('Imagem');

					$Pasta  = "img/produtos/";
					$nomeArquivo = $ultProd[0]['id_produto'] . '.jpg';
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
				$comboModel = new Application_Model_Combo();

				$idProd = $comboModel->fetchAll(
					$comboModel->select()->where('id_combo = '. $id)
				);	
						
				$iddocombo = $idProd[0]['id_produto_combo'];
				
				$produtoModel->update(array(
					'excluido' => '1'
						), 'id_produto = ' . $iddocombo);

				$comboModel->update(array(
					'excluido' => '1'
						), 'id_combo = ' . $id);
						
				unlink(APPLICATION_PATH . '/../produtos/' . $iddocombo . '.jpg');
			}
			return $this->_helper->redirector('index');
		}else{
		    $this->view->id = $this->_request->getParam('id');

			$comboModel = new Application_Model_Combo();

			$nome_combo = $comboModel->fetchAll(
										$comboModel->select()
											->from($comboModel->info(Zend_Db_Table_Abstract::NAME))
											->columns(array('nome'))
											->where('id_combo = ?', $id)
										);
			$this->view->combo = $nome_combo;		
		}
    }
	
	public function editarAction() {
        $id = $this->_request->getParam('id');

        require_once APPLICATION_PATH . '/modules/admin/forms/Combo.php';
        $this->view->form = new admin_Form_Combo();

        $comboModel = new Application_Model_Combo();
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

				$dados = array();
				
                $data['preco'] = str_replace(array(',', '.'), '', $data['preco']);
				$dados['preco'] = $data['preco'];
				$dados['nome'] = $data['nome'];
								
				$idProd = $comboModel->fetchAll(
                    $comboModel->select()->where('id_combo = '. $id)
				);	
				
				$iddocombo = $idProd[0]['id_produto_combo'];				

                $comboModel->update($data, 'id_combo = ' . $id);
                $produtoModel->update($dados, 'id_produto = ' . $iddocombo);

				if ($uploaded) {
                    $filter = new Zend_Filter_File_Rename(array('target' => APPLICATION_PATH . '/../public/img/produtos/' . $iddocombo . '.jpg', 'overwrite' => true));
                    $filter->filter($upload->getFileName());
					
					Zend_Loader::loadClass('Imagem');

					$Pasta  = "img/produtos/";
					$nomeArquivo = $iddocombo . '.jpg';
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

        $combo = $comboModel->find($id)->current();

        $this->view->form->setDefaults($combo->toArray());
    }

}

