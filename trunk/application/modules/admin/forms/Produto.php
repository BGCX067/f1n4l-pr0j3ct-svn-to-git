<?php

class admin_Form_Produto extends Zend_Form {

    public function init() {
        $this->addElement(
                'text',
                'nome',
                array(
                    'label' => 'Nome*',
					'class' => 'campo-txt',
					'required' => true
                )
        );

        $this->addElement(
                'text',
                'descricao',
                array(
                    'label' => 'Descrição*',
					'class' => 'campo-txt',
					'required' => true
                )
        );

		$this->addElement(
                'file',
                'pFoto',
                array(
                    'label' => 'Foto*',
                )
        );
		
		$validate = new Zend_Validate_Callback('validaPreco');
        $validate->setMessage('Valor negativo!');
        $this->addElement(
                'text',
                'preco',
                array(
                    'label' => 'Preço Em Reais*',
					'class' => 'campo-txt',
					'required' => true,
					'validators' => array(
                        $validate
					)
                )
        );

		$categoriaModel = new Application_Model_Categoria();

        $categorias = $categoriaModel->fetchAll(
                                $categoriaModel->select()
                                ->from($categoriaModel->info(Zend_Db_Table_Abstract::NAME))
                                ->columns(array('nome_categoria'))
								->where('excluido = 0')

        );
        $categoriasArr = array();

        foreach ($categorias as $categoria) {
            $categoriasArr[$categoria['nome_categoria']] = $categoria['nome_categoria'];
        }
        $this->addElement(
                'select',
                'categoria',
                array(
                    'label' => 'Categoria: ',
					'class' => 'campo-txt',
                    'multiple' => false,
                    'multiOptions' => $categoriasArr,
                    'registerInArrayValidator' => false
                )
        );

		$this->addElement(
                'checkbox',
                'promocao',
                array(
                    'label' => 'Promover Produto?',
                    'checkedValue' => 1,
                    'uncheckedValue' => 0,
                )
        );
		
        $this->addElement(
                'submit',
                'submit_button',
                array(
                    'label' => 'Salvar',
					'class' => 'bt-enviar',
                    'ignore' => true
                )
        );
    }

}

function validaPreco($valor) {
    if ($valor < 0) {
        return false;
    }

    return true;
}