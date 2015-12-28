<?php

class Admin_Form_Menus extends Zend_Form {

    public function init() {

        $this->addElement(
                'textarea',
                'conteudo',
                array(
                    'label' => 'Texto* ',
					'class' => 'campo-txtarea',
                    'required' => true,
                )
        );

        $this->addElement(
                'submit',
                'submit_button',
                array(
                    'label' => 'Salvar',
					'class' => 'bt-enviar',
                    'ignore' => true
                )
        );
    }

}