<?php

class Application_Form_Redefinir extends Zend_Form {

    public function init() {

        $validate = new Zend_Validate_Callback('userExists');
        $validate->setMessage('Usuario inexistente!');
        $this->addElement(
                'text',
                'usuario',
                array(
                    'label' => 'CPF (usuario / somente numeros)*',
                    'required' => true,
					'class' => 'campo-txt',
                    'validators' => array(
                        new Zend_Validate_Int(),
                        $validate
                    )
                )
        );

        $this->addElement(
                'text',
                'key',
                array(
                    'label' => 'Codigo*',
					'class' => 'campo-txt',
                    'required' => true,
                )
        );

        $this->addElement(
                'text',
                'senha',
                array(
                    'label' => 'Nova Senha*',
					'class' => 'campo-txt',
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
        return true;
    }
    return false;
}
