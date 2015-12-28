<?php

class Admin_MenusController extends Zend_Controller_Action
{

    public function init(){
        /* Initialize action controller here */
    }

    public function indexAction(){
        $id = $this->_request->getParam('id');

	    require_once APPLICATION_PATH . '/modules/admin/forms/Menus.php';
        $this->view->form = new admin_Form_Menus();

        $menuModel = new Application_Model_Menus();

        if ($this->_request->isPost()) {

            $this->view->form->setDefaults($this->_request->getPost());

            $data = $this->view->form->getValues();

            if ($this->view->form->isValid($data)) {

                $menuModel->update($data, 'id_menu = ' . $id);

                return $this->_helper->redirector('index', 'index');
            }
        }

        $menu = $menuModel->find($id)->current();
        $this->view->form->setDefaults($menu->toArray());

    }    
}

