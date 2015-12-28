<?php

class Admin_NovidadesController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    public function indexAction() {

        $novidadesModel = new Application_Model_Novidades();

        $this->view->novidades = $novidadesModel->fetchAll(
                        $novidadesModel->select()->where('excluido = 0')
											->order('id_noticia DESC')

        );

        $busca = $this->_request->getParam('busca');
    }

    public function adicionarAction() {
        require_once APPLICATION_PATH . '/modules/admin/forms/Novidades.php';
        $this->view->form = new admin_Form_Novidades();

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

                $novidadesModel = new Application_Model_Novidades();

                unset($data['pFoto']);

                $id = $novidadesModel->insert($data);

                if ($uploaded) {
                    $filter = new Zend_Filter_File_Rename(array('target' => APPLICATION_PATH . '/../public/novidades_fotos/' . $id . '.jpg', 'overwrite' => true));
                    $filter->filter($upload->getFileName());

					Zend_Loader::loadClass('Imagem');

					$Pasta  = "novidades_fotos/";
					$nomeArquivo = $id . '.jpg';
					$Largura = '200';
					$Altura = '';

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
				$novidadesModel = new Application_Model_Novidades();

				$novidadesModel->update(array(
					'excluido' => '1'
						), 'id_noticia = ' . $id);

				unlink(APPLICATION_PATH . '/../novidades_fotos/' . $id . '.jpg');
			}
			return $this->_helper->redirector('index');
		}else{
		    $this->view->id = $this->_request->getParam('id');

			$novidadesModel = new Application_Model_Novidades();

			$nome_novidade = $novidadesModel->fetchAll(
										$novidadesModel->select()
											->from($novidadesModel->info(Zend_Db_Table_Abstract::NAME))
											->columns(array('titulo'))
											->where('id_noticia = ?', $id)
										);
			$this->view->novidade = $nome_novidade;		
		}
    }

    public function editarAction() {
        $id = $this->_request->getParam('id');

        require_once APPLICATION_PATH . '/modules/admin/forms/Novidades.php';
        $this->view->form = new admin_Form_Novidades();

        $novidadesModel = new Application_Model_Novidades();

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

                $novidadesModel->update($data, 'id_noticia = ' . $id);

                if ($uploaded) {
                    $filter = new Zend_Filter_File_Rename(array('target' => APPLICATION_PATH . '/../public/novidades_fotos/' . $id . '.jpg', 'overwrite' => true));
                    $filter->filter($upload->getFileName());
					
					Zend_Loader::loadClass('Imagem');

					$Pasta  = "novidades_fotos/";
					$nomeArquivo = $id . '.jpg';
					$Largura = '200';
					$Altura = '';
					
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

        $novidades = $novidadesModel->find($id)->current();

        $this->view->form->setDefaults($novidades->toArray());
    }

    public function visualizarAction() {
        $id = $this->_request->getParam('id');

        $novidadesModel = new Application_Model_Novidades();

        $this->view->novidades = $novidadesModel->find($id)->current();
    }

}

