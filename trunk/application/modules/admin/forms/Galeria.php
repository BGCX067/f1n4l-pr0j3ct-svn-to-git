<?php

class admin_Form_Galeria extends Zend_Form {

    public function init() {

        $this->addElement(
                'text',
                'descricao',
                array(
                    'label' => 'Descrição*',
					'class' => 'campo-txt',
                    'required' => true
                    
                )
        );

        $galeriasModel = new Application_Model_Galerias();

        $galerias = $galeriasModel->fetchAll(
                                $galeriasModel->select()
                                ->from($galeriasModel->info(Zend_Db_Table_Abstract::NAME))
                                ->columns(array('nome'))
								->where('excluido = 0')
        );
        $galeriasArr = array();

        foreach ($galerias as $galeria) {
            $galeriasArr[$galeria['nome']] = $galeria['nome'];
        }
        $this->addElement(
                'select',
                'galeria',
                array(
                    'label' => 'Galeria: ',
                    'multiple' => false,
                    'multiOptions' => $galeriasArr,
                    'registerInArrayValidator' => false
                )
        );
        

        $this->addElement(
                'file',
                'pFoto',
                array(
                    'label' => 'Foto*',
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

