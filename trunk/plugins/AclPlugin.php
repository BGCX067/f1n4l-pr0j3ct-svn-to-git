<?php

class AclPlugin extends Zend_Controller_Plugin_Abstract {

    private $_authEngine;
    private $_acl;

    public function __construct(Zend_Auth $auth, Zend_Acl $acl) {
        $this->_acl = $acl;
        $this->_authEngine = $auth;
    }

    public function preDispatch(Zend_Controller_Request_Abstract $request) {
        $resource = $request->getActionName();
        $privilegio = $request->getControllerName();
        $modulo = $request->getModuleName();
        $privilegio = $modulo . ':' . $privilegio;

        $storageObj = $this->_authEngine->getStorage()->read();

        $role = 'visitante';

        if ($this->_authEngine->hasIdentity()) {
            $auth = $this->_authEngine->getStorage()->read();

            $id = $auth['usuario_id'];

            $usuarioModel = new Application_Model_Usuario();

            $usuario = $usuarioModel->find($id)->current();

            $role = $usuario['tipo'];
        }

        try {
            if (!$this->_acl->has($privilegio)) {
                throw new Zend_Exception('Recurso não encontrado: ' . $privilegio);
            }

            if (!$this->_acl->isAllowed($role, $privilegio, $resource)) {
                $redirector = Zend_Controller_Action_HelperBroker::getStaticHelper('Redirector');

                $redirector->gotoUrlAndExit('/error/errorpermission');
            }
        } catch (Zend_Exception $e) {
           // echo $e->getMessage();
        } catch (Zend_Acl_Exception $e) {
          //  echo $e->getMessage();
        }
    }

}

?>