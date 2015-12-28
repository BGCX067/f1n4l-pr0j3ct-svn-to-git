<?php

class admin_Form_Novidades extends Zend_Form {

    public function init() {

        $this->addElement(
                'text',
                'titulo',
                array(
                    'label' => 'Título*',
					'class' => 'campo-txt',
                    'required' => true
                    
                )
        );
		
        $this->addElement(
                'textarea',
                'texto',
                array(
                    'label' => 'Texto*',
					'class' => 'campo-txtarea',
                    'required' => true
                    
                )
        );

        $this->addElement(
                'file',
                'pFoto',
                array(
                    'label' => 'Foto*'
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

