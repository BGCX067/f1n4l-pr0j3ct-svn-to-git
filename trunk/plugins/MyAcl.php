<?php

require_once 'Zend/Acl.php';
require_once 'Zend/Acl/Role.php';
require_once 'Zend/Acl/Resource.php';

class MyAcl extends Zend_Acl {

    public function __construct(Zend_Auth $authClass) {
        $this->addRole(new Zend_Acl_Role('visitante'));
        $this->addRole(new Zend_Acl_Role('cliente'));
        $this->addRole(new Zend_Acl_Role('administrador'));

        $this->add(new Zend_Acl_Resource('default'));
        $this->add(new Zend_Acl_Resource('admin'));

        $this->add(new Zend_Acl_Resource('default:sobre', 'default'));
        $this->add(new Zend_Acl_Resource('default:vendas', 'default'));
        $this->add(new Zend_Acl_Resource('default:galeria', 'default'));
        $this->add(new Zend_Acl_Resource('default:contato', 'default'));


        $this->add(new Zend_Acl_Resource('default:alterardados', 'default'));
        $this->add(new Zend_Acl_Resource('default:cadastro', 'default'));
        $this->add(new Zend_Acl_Resource('default:carrinho', 'default'));
        $this->add(new Zend_Acl_Resource('default:enderecos-entrega', 'default'));
        $this->add(new Zend_Acl_Resource('default:error', 'default'));
        $this->add(new Zend_Acl_Resource('default:manutencao', 'default'));
        $this->add(new Zend_Acl_Resource('default:index', 'default'));
        $this->add(new Zend_Acl_Resource('default:login', 'default'));
        $this->add(new Zend_Acl_Resource('default:pedidos', 'default'));
        $this->add(new Zend_Acl_Resource('default:produtos', 'default'));

        $this->add(new Zend_Acl_Resource('admin:index', 'admin'));
        $this->add(new Zend_Acl_Resource('admin:categorias', 'admin'));
        $this->add(new Zend_Acl_Resource('admin:galeria', 'admin'));
        $this->add(new Zend_Acl_Resource('admin:pedidos', 'admin'));
        $this->add(new Zend_Acl_Resource('admin:produtos', 'admin'));
        $this->add(new Zend_Acl_Resource('admin:promocoes', 'admin'));
        $this->add(new Zend_Acl_Resource('admin:opinioes', 'admin'));
        $this->add(new Zend_Acl_Resource('admin:cep', 'admin'));

        $this->allow(null, 'default');

        $this->allow(null, 'default:sobre');
        $this->allow(null, 'default:vendas');
        $this->allow(null, 'default:manutencao');
        $this->allow(null, 'default:galeria');
        $this->allow(null, 'default:contato');

        $this->allow(null, 'default:carrinho');
        $this->allow(null, 'default:error');
        $this->allow(null, 'default:index');
        $this->allow(null, 'default:login');

        $this->deny('visitante', 'admin');

        $this->deny('visitante', 'default:alterardados');
        $this->allow('visitante', 'default:cadastro');
        $this->deny('visitante', 'default:enderecos-entrega');
        $this->deny('visitante', 'default:pedidos');
        $this->allow('visitante', 'default:produtos');

        $this->deny('cliente', 'admin');

        $this->allow('cliente', 'default:alterardados');
        $this->allow('cliente', 'default:cadastro');
        $this->allow('cliente', 'default:enderecos-entrega');
        $this->allow('cliente', 'default:pedidos');
        $this->allow('cliente', 'default:produtos');

        $this->allow('administrador', 'admin');

        $this->allow('administrador', 'default:alterardados');
        $this->allow('administrador', 'default:cadastro');
        $this->allow('administrador', 'default:enderecos-entrega');
        $this->allow('administrador', 'default:pedidos');
        $this->allow('administrador', 'default:produtos');

        $this->allow('administrador', 'admin:index');
        $this->allow('administrador', 'admin:galeria');
        $this->allow('administrador', 'admin:categorias');
        $this->allow('administrador', 'admin:pedidos');
        $this->allow('administrador', 'admin:produtos');
        $this->allow('administrador', 'admin:promocoes');
        $this->allow('administrador', 'admin:opinioes');
        $this->allow('administrador', 'admin:cep');
    }

}

?>