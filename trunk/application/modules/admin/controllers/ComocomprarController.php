<?php

class Admin_ComocomprarController extends Zend_Controller_Action
{

    public function init(){
        /* Initialize action controller here */
    }

    public function indexAction(){
        $id = '1';

	    require_once APPLICATION_PATH . '/modules/admin/forms/Comocomprar.php';
        $this->view->form = new admin_Form_Comocomprar();

        $comoModel = new Application_Model_Comocomprar();

        if ($this->_request->isPost()) {

            $this->view->form->setDefaults($this->_request->getPost());

            $data = $this->view->form->getValues();

            if ($this->view->form->isValid($data)) {

                $comoModel->update($data, 'id = 1');

                return $this->_helper->redirector('index', 'index');
            }
        }

        $como = $comoModel->find($id)->current();
        $this->view->form->setDefaults($como->toArray());

    }    
}

