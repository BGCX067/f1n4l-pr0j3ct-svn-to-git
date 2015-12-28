<?php

class Admin_Form_Midias extends Zend_Form {

    public function init() {

        $this->addElement(
                'text',
                'twitter',
                array(
                    'label' => 'Twitter* ',
					'class' => 'campo-txt',
                    'required' => true,
                )
        );

        $this->addElement(
                'text',
                'facebook',
                array(
                    'label' => 'Facebook*',
					'class' => 'campo-txt',
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