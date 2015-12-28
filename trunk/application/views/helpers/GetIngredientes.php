<?php

class Zend_View_Helper_GetIngredientes {

    function GetIngredientes($id) {
			$cont = 0;
            $relacionamentosModel = new Application_Model_Relacionamentos();

			$dados = $relacionamentosModel->fetchAll(
                        $relacionamentosModel->select()->where('excluido = 0')
														->where('id_produto = ?', $id)
        );
		return count($dados);					
    }
}

?>