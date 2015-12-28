<?php

class Application_Form_CadastroEndereco extends Zend_Form {

    public function init() {
        $this->addElement(
                'text',
                'rua',
                array(
                    'label' => 'Rua*',
					'class' => 'campo-txt',
                    'required' => true,
                )
        );

        $this->addElement(
                'text',
                'cidade',
                array(
                    'label' => 'Cidade*',
					'class' => 'campo-txt',
                    'required' => true,
                )
        );

        $this->addElement(
                'text',
                'bairro',
                array(
                    'label' => 'Bairro*',
					'class' => 'campo-txt',
                    'required' => true,
                )
        );

        $this->addElement(
                'text',
                'numero',
                array(
                    'label' => 'Numero*',
					'class' => 'campo-txt',
                    'required' => true,
					'validators' => array(
                        new Zend_Validate_Int()
                ))
        );

        $this->addElement(
                'text',
                'complemento',
                array(
                    'label' => 'Complemento: ',
					'class' => 'campo-txt'
                )
        );

        $this->addElement(
                'submit',
                'submit_button',
                array(
                    'label' => 'Enviar',
					'class' => 'bt-enviar',
                    'ignore' => true
                )
        );
    }
}
