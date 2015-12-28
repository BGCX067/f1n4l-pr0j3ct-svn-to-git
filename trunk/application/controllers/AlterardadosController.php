<?php

class AlterardadosController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    public function indexAction() {
        Zend_Loader::loadClass('Zend_Auth');
        $authClass = Zend_Auth::getInstance();

        if ($authClass->hasIdentity()) {
            $auth = $authClass->getStorage()->read();

            $id = $auth['usuario_id'];

            require_once APPLICATION_PATH . '/forms/AlterarDados.php';
            $this->view->form = $form = new Application_Form_AlterarDados();

            $usuarioModel = new Application_Model_Usuario();

            if ($this->_request->isPost()) {
                $this->view->form->setDefaults($this->_request->getPost());

                $data = $this->view->form->getValues();

                if ($this->view->form->isValid($data)) {
                    if ($data['senha'] != '') {
                        $data['senha'] = md5($data['senha']);
                    } else {
                        unset($data['senha']);
                    }

                    unset($data['repita_senha']);

                    $usuarioModel->update($data, 'idusuario = ' . $id);

                    return $this->_helper->redirector('index');
                }
            }

            $usuario = $usuarioModel->find($id)->current();

            $this->view->form->setDefaults($usuario->toArray());
        }
    }
}

