<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {

    private $view;

    protected function _initViewApp() {
        $this->bootstrap('view');
        $this->view = $this->getResource('view');
        $this->view->addHelperPath('ZExt/View/Helper', 'ZExt_View_Helper');
    }

    protected function _initHead() {
        $this->view->doctype('XHTML1_STRICT');
        $this->view->setEncoding('UTF-8');
        $this->view->headMeta()->appendHttpEquiv('Content-Type', 'text/html; charset=UTF-8');
        $this->view->headTitle('Online Thru');
        $this->view->headTitle()->setSeparator(' - ');
		$this->view->headLink(array('rel' => 'shortcut icon','href' => '/imgs/favicon.ico'),'PREPEND');
    }

    protected function _initJquery() {
		$this->view->headScript()->appendFile('http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js');         
        $this->view->headScript()->appendFile('http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.min.js');         
        $this->view->headScript()->appendFile('/js/jscript_xdarkbox.js');        
        $this->view->headScript()->appendFile('/js/jscript_zjcarousellite.js');        
        $this->view->headScript()->appendFile('/js/jscript_zjquery.faded.js');  
        $this->view->headScript()->appendFile('/js/acoes.js');         
		$this->view->headScript()->appendFile('/js/carrinho.js');
        $this->view->headScript()->appendFile('/js/jquery.simpletip-1.3.1.pack.js');         
        $this->view->headScript()->appendFile('/js/script01.js');         
        $this->view->headScript()->appendFile('/js/jquery.fancybox-1.3.4.js');
    }

    protected function _initStyle() {
       $this->view->headLink()->appendStylesheet('/css/layout.css');
       $this->view->headLink()->appendStylesheet('/css/carrinho.css');
       $this->view->headLink()->appendStylesheet('/css/jquery.fancybox-1.3.4.css');
       }

    protected function _initRouter() {
        $front = Zend_Controller_Front::getInstance();
    }

    protected function _initPlugins() {
        $front = Zend_Controller_Front::getInstance();

        $config = new Zend_Config($this->getOptions(), true);
        Zend_Registry::set('config', $config);

        $auth = Zend_Auth::getInstance();
        $acl = new MyAcl($auth);
        Zend_Registry::set('acl', $acl);

        $aclPlugin = new AclPlugin($auth, $acl);

        $front->registerPlugin($aclPlugin);
    }

}
