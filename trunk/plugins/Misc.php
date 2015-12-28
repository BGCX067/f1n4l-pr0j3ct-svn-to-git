<?php

class Misc {

    public static function dateFormat($date) {
        if ($date) {
            $date = new DateTime($date);

            return $date->format('d/m/Y H:i:s');
        } else {
            return '-';
        }
    }

    public static function isLogged() {
        Zend_Loader::loadClass('Zend_Auth');
        $authClass = Zend_Auth::getInstance();

        return $authClass->hasIdentity();
    }

    public static function isAdmin() {
        $usuario = self::getLoggetUser();

        return $usuario['tipo'] == 'administrador';
    }

    public static function getLoggetUser() {
        if (Misc::isLogged()) {
            $id = Misc::getLoggetUserId();

            $usuarioModel = new Application_Model_Usuario();

            $usuario = $usuarioModel->find($id)->current();

            return $usuario;
        }

        return null;
    }

    public static function getLoggetUserId() {
        Zend_Loader::loadClass('Zend_Auth');
        $authClass = Zend_Auth::getInstance();

        if ($authClass->hasIdentity()) {
            $auth = $authClass->getStorage()->read();

            return $auth['usuario_id'];
        }

        return null;
    }

    public static function verifyCep($cep) {
        $ufModel = new Application_Model_Uf();

        $uf = $ufModel->fetchRow(
                                $ufModel->select()
                                ->where(':cep BETWEEN Cep1 AND Cep2')
                                ->bind(array(
                                    'cep' => substr($cep, 0, 5)
                                ))
        );

        if ($uf != null) {
            $estadoModel = new Application_Model_Estado();

            $estadoModel->setOptions(array(
                Application_Model_Estado::NAME => strtolower($uf['UF'])
            ));

            $resultado = $estadoModel->fetchRow(
                                    $estadoModel->select()
                                    ->where('cep = :cep')
                                    ->bind(array(
                                        'cep' => str_replace('-', '', $cep)
                                    ))
            );

            if ($resultado != null) {
                return array(
                    'uf' => $uf['UF'],
                    'cidade' => $resultado['cidade'],
                    'bairro' => $resultado['bairro'],
                    'tipo_logradouro' => $resultado['tp_logradouro'],
                    'logradouro' => $resultado['logradouro'],
                    'valor' => $resultado['valor']
                );
            }
        }

        return false;
    }

    public static function situation($situacao) {
        switch ($situacao) {
            case 'G':
                return 'Gerado';
                break;
            case 'P':
                return 'Pago';
                break;
            case 'E':
                return 'Enviado';
                break;
            case 'R':
                return 'Recebido';
                break;
        }
    }

    public static function paymentType($tipo) {
        switch ($tipo) {
            case 'D':
                return 'Débito';
                break;
            case 'C':
                return 'Crédito';
                break;
            case 'B':
                return 'Boleto';
                break;
        }
    }

}

?>