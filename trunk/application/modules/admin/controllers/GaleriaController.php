<?php

class Admin_GaleriaController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    public function indexAction() {

        $galeriasModel = new Application_Model_Galerias();

        $this->view->galerias = $galeriasModel->fetchAll(
                        $galeriasModel->select()->where('excluido = 0')
										->order('id_galeria DESC')

        );
    	
        $galeriaModel = new Application_Model_Galeria();

        $this->view->galeria = $galeriaModel->fetchAll(
                        $galeriaModel->select()->where('excluido = 0')
											->order('id_foto DESC')

        );

        $busca = $this->_request->getParam('busca');
        $galeria = $this->_request->getParam('galeria');
    }

    public function adicionarAction() {
        require_once APPLICATION_PATH . '/modules/admin/forms/Galeria.php';
        $this->view->form = new admin_Form_Galeria();

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

                $galeriaModel = new Application_Model_Galeria();

                unset($data['pFoto']);

                $id = $galeriaModel->insert($data);

                if ($uploaded) {
                    $filter = new Zend_Filter_File_Rename(array('target' => APPLICATION_PATH . '/../public/galeria_fotos/' . $id . '.jpg', 'overwrite' => true));
                    $filter->filter($upload->getFileName());

					Zend_Loader::loadClass('Imagem');

					$Pasta  = "galeria_fotos/";
					$nomeArquivo = $id . '.jpg';
					$Largura = '600';
					$Altura = '';

					$Pasta_thumbs  = "galeria_fotos/thumbs/";
					$Largura_thumbs = '200';
					$Altura_thumbs = '200';

					$MetodoRedimencionar = 2;

					$CorFundo = null;

					$Imagem = new Imagem($Pasta . $nomeArquivo);
					$Imagem->Ponteiro = '';
					$Imagem->Redimencionar($Largura, $Altura, $MetodoRedimencionar, $CorFundo);
					$Imagem->Salvar( $Pasta . $nomeArquivo);

					$Imagem = new Imagem($Pasta . $nomeArquivo);
					$Imagem->Ponteiro = '';
					$Imagem->Redimencionar($Largura_thumbs, $Altura_thumbs, $MetodoRedimencionar, $CorFundo);
					$Imagem->Salvar( $Pasta_thumbs . $nomeArquivo);
                }

                return $this->_helper->redirector('index');
            }
        }
    }
    public function adicionargaleriaAction() {
        require_once APPLICATION_PATH . '/modules/admin/forms/Galerias.php';
        $this->view->form = new admin_Form_Galerias();

        if ($this->_request->isPost()) {

            $this->view->form->setDefaults($this->_request->getPost());

            $data = $this->view->form->getValues();

            if ($this->view->form->isValid($data)) {

                $galeriasModel = new Application_Model_Galerias();

                $id = $galeriasModel->insert($data);

                return $this->_helper->redirector('index');
            }
        }
    }
    public function removerAction() {
        $id = $this->_request->getParam('id');
        $confirma = $this->_request->getParam('confirma');

        $galeriaModel = new Application_Model_Galeria();

		if(isset($confirma)){
			if($confirma == 1){
				$galeriaModel->update(array(
					'excluido' => '1'
						), 'id_foto = ' . $id);

				unlink(APPLICATION_PATH . '/../galeria_fotos/' . $id . '.jpg');
				unlink(APPLICATION_PATH . '/../galeria_fotos/thumbs/' . $id . '.jpg');
			}
			return $this->_helper->redirector('index');
		}else{
		    $this->view->id = $this->_request->getParam('id');

			$galeriaModel = new Application_Model_Galeria();

			$nome_galeria = $galeriaModel->fetchAll(
										$galeriaModel->select()
											->from($galeriaModel->info(Zend_Db_Table_Abstract::NAME))
											->columns(array('descricao'))
											->where('id_foto = ?', $id)
										);
			$this->view->galeria = $nome_galeria;		
		}

    }

    public function removergaleriaAction() {
        $id = $this->_request->getParam('id');
        $confirma = $this->_request->getParam('confirma');
		
		if(isset($confirma)){
			if($confirma == 1){
				$galeriasModel = new Application_Model_Galerias();

				$galeriasModel->update(array(
					'excluido' => '1'
						), 'id_galeria = ' . $id);
			}
			return $this->_helper->redirector('index');
		}else{
		    $this->view->id = $this->_request->getParam('id');

			$galeriasModel = new Application_Model_Galerias();

			$nome_galeria = $galeriasModel->fetchAll(
										$galeriasModel->select()
											->from($galeriasModel->info(Zend_Db_Table_Abstract::NAME))
											->columns(array('nome'))
											->where('id_galeria = ?', $id)
										);
			$this->view->galeria = $nome_galeria;		
		}
    }
    public function editarAction() {
        $id = $this->_request->getParam('id');

        require_once APPLICATION_PATH . '/modules/admin/forms/Galeria.php';
        $this->view->form = new admin_Form_Galeria();

        $galeriaModel = new Application_Model_Galeria();

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

                $galeriaModel->update($data, 'id_foto = ' . $id);

                if ($uploaded) {
                    $filter = new Zend_Filter_File_Rename(array('target' => APPLICATION_PATH . '/../public/galeria_fotos/' . $id . '.jpg', 'overwrite' => true));
                    $filter->filter($upload->getFileName());
					
					Zend_Loader::loadClass('Imagem');

					$Pasta  = "galeria_fotos/";
					$nomeArquivo = $id . '.jpg';
					$Largura = '600';
					$Altura = '';

					$Pasta_thumbs  = "galeria_fotos/thumbs/";
					$Largura_thumbs = '250';
					$Altura_thumbs = '250';

					$MetodoRedimencionar = 2;

					$CorFundo = null;

					$Imagem = new Imagem($Pasta . $nomeArquivo);
					$Imagem->Ponteiro = '';
					$Imagem->Redimencionar($Largura, $Altura, $MetodoRedimencionar, $CorFundo);
					$Imagem->Salvar( $Pasta . $nomeArquivo);

					$Imagem = new Imagem($Pasta . $nomeArquivo);
					$Imagem->Ponteiro = '';
					$Imagem->Redimencionar($Largura_thumbs, $Altura_thumbs, $MetodoRedimencionar, $CorFundo);
					$Imagem->Salvar( $Pasta_thumbs . $nomeArquivo);					
                }

                return $this->_helper->redirector('index');
            }
        }

        $galeria = $galeriaModel->find($id)->current();

        $this->view->form->setDefaults($galeria->toArray());
    }
    
	public function editargaleriaAction() {
        $id = $this->_request->getParam('id');

        require_once APPLICATION_PATH . '/modules/admin/forms/Galerias.php';
        $this->view->form = new admin_Form_Galerias();

        $galeriasModel = new Application_Model_Galerias();

        if ($this->_request->isPost()) {

            $this->view->form->setDefaults($this->_request->getPost());

            $data = $this->view->form->getValues();

            if ($this->view->form->isValid($data)) {

                $galeriasModel->update($data, 'id_galeria = ' . $id);

                return $this->_helper->redirector('index');
            }
        }

        $galerias = $galeriasModel->find($id)->current();

        $this->view->form->setDefaults($galerias->toArray());
    }
    
    public function visualizarAction() {
        $id = $this->_request->getParam('id');

        $galeriaModel = new Application_Model_Galeria();

        $this->view->galeria = $galeriaModel->find($id)->current();
    }

}

