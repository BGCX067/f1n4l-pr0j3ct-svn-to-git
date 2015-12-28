<?php

class Application_Model_Adicionais extends Zend_Db_Table_Abstract {

    protected $_name = 'produto_adicionais';
    protected $_primary = array('id_adicionais','id_adicional');
    protected $_dependentTables = array(
    );

}