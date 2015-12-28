<?php

class admin_Form_Galerias extends Zend_Form {

    public function init() {

        $this->addElement(
                'text',
                'nome',
                array(
                    'label' => 'Nome*',
					'class' => 'campo-txt',
                    'required' => true
                    
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

