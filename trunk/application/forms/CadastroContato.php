<?php

class Application_Form_CadastroContato extends Zend_Form {

    public function init() {
        $this->addElement(
                'text',
                'dt_nasc',
                array(
                    'label' => 'Data de Nascimento (dd/mm/aaaa)*',
                    'required' => true,
					'class' => 'campo-txt',
					'maxlength' => '10',
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
                'checkbox',
                'news',
                array(
                    'label' => 'Desejo receber newsletter',
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
