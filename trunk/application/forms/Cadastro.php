<?php

class Application_Form_Cadastro extends Zend_Form {

    public function init() {
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

        $validate = new Zend_Validate_Callback('userExists');
        $validate->setMessage('Usuário já existe!');
        $this->addElement(
                'text',
                'usuario',
                array(
                    'label' => 'CPF (usuario / somente numeros)*',
                    'required' => true,
					'class' => 'campo-txt',
                    'validators' => array(
						  new Zend_Validate_Between(array('min' => 1, 'max' => 99999999999)),
                        $validate
                    )
        ));

        $this->addElement(
                'password',
                'senha',
                array(
                    'label' => 'Senha*',
                    'required' => true,
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
                    'label' => 'Repita a Senha*',
                    'required' => true,
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
                    'label' => 'Enviar',
					'class' => 'bt-enviar',
                    'ignore' => true
                )
        );
    }

}

function userExists($user) {
    $usuarioModel = new Application_Model_Usuario();

    $exists = $usuarioModel->fetchRow(
                            $usuarioModel->select()
                            ->where('usuario = :usuario')
                            ->bind(array(
                                'usuario' => $user
                            ))
    );

    if ($exists != null) {
        return false;
    }

    return true;
}
