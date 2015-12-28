<?php

class Application_Form_Contato extends Zend_Form {

    public function init() {
        $this->addElement(
                'text',
                'nome',
                array(
                    'label' => 'Nome*',
					'class' => 'campo-txt',
                    'required' => true,
                    'validators' => array(
                        new Zend_Validate_Alpha(true)
                    )
                )
        );

        $this->addElement(
                'text',
                'telefone',
                array(
                    'label' => 'Telefone*',
					'class' => 'campo-txt',
                    'required' => true,
                )
        );

        $this->addElement(
                'text',
                'email',
                array(
                    'label' => 'E-mail*',
					'class' => 'campo-txt',
                    'required' => true,
                )
        );
		
        $this->addElement(
                'textarea',
                'mensagem',
                array(
                    'label' => 'Mensagem*',
					'class' => 'campo-txtarea',
                    'required' => true,
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

