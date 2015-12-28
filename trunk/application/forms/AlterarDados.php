<?php

class Application_Form_AlterarDados extends Zend_Form
{

    public function init()
    {
        $this->addElement(
                'text',
                'nome',
                array(
                    'label' => 'Nome*',
                    'required' => true,
					'class' => 'campo-txt',
                    'validators' => array(
                        new Zend_Validate_Alpha(true)
                    )
                )
        );

        $this->addElement(
                'password',
                'senha',
                array(
                    'label' => 'Senha',
					'class' => 'campo-txt',
                    'validators' => array(
                        new Zend_Validate_Identical(Zend_Controller_Front::getInstance()->getRequest()->getParam('repita_senha'))
                    )
                )
        );

        $this->addElement(
                'password',
                'repita_senha',
                array(
                    'label' => 'Repita a Senha',
					'class' => 'campo-txt',
                    'validators' => array(
                        new Zend_Validate_Identical(Zend_Controller_Front::getInstance()->getRequest()->getParam('senha'))
                    )
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

