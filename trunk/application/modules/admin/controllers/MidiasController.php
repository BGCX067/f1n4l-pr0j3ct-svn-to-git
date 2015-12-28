<?php

class Admin_MidiasController extends Zend_Controller_Action
{

    public function init(){
        /* Initialize action controller here */
    }

    public function indexAction(){

	    require_once APPLICATION_PATH . '/modules/admin/forms/Midias.php';
        $this->view->form = new admin_Form_Midias();

        $midiasModel = new Application_Model_Midias();

        if ($this->_request->isPost()) {

            $this->view->form->setDefaults($this->_request->getPost());

            $data = $this->view->form->getValues();

            if ($this->view->form->isValid($data)) {

                $midiasModel->update($data, 'id_midia = 1' . $id);

                return $this->_helper->redirector('index', 'index');
            }
        }

        $midias = $midiasModel->find(1)->current();
        $this->view->form->setDefaults($midias->toArray());

    }    
}

