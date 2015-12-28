<?php

class Admin_Form_Comocomprar extends Zend_Form {

    public function init() {

        $this->addElement(
                'text',
                'link',
                array(
                    'label' => 'Link do Youtube* ',
					'class' => 'campo-txt-email',
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