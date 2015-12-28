<?php

class Application_Model_Produto extends Zend_Db_Table_Abstract {

    protected $_name = 'produto';
    protected $_primary = 'id_produto';
    protected $_dependentTables = array(
    );

}