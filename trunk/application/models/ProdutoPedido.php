<?php

class Application_Model_ProdutoPedido extends Zend_Db_Table_Abstract {

    protected $_name = 'produto_pedido';
    protected $_primary = 'id_produto_pedido';
    protected $_dependentTables = array(
    );

}