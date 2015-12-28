<?php

class Application_Model_Pedido extends Zend_Db_Table_Abstract {

    protected $_name = 'pedido';
    protected $_primary = 'id_pedido';
    protected $_dependentTables = array(
    );

}