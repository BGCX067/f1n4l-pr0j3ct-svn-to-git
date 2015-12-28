<?php

class Application_Model_News extends Zend_Db_Table_Abstract {

    protected $_name = 'newsletter_email';
    protected $_primary = 'id';
    protected $_dependentTables = array(
    );

}