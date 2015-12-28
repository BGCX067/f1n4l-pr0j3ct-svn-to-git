<?php

class ComocomprarController extends Zend_Controller_Action{

    public function init()
    {
        /* Initialize action controller here */
    }
	
    public function indexAction(){
        $this->view->headTitle('Como Comprar');
		
		$sessao = new Zend_Session_Namespace('SESSAO_CARRINHO');

		if (isset($sessao->produtos)) {
		$carrinhoContador = sizeof($sessao->produtos);
		}else{
		$carrinhoContador = 0;
		}
		
		if($carrinhoContador == 0){
			$this->view->carrinhoImagem = '';
			}else{
				if($carrinhoContador < 5){
				$this->view->carrinhoImagem = $carrinhoContador;
				}else{
					$this->view->carrinhoImagem = 4;
					}
			}
			
        $categoriaModel = new Application_Model_Categoria();

        $nome_categorias = $categoriaModel->fetchAll(
                                    $categoriaModel->select()
                                		->from($categoriaModel->info(Zend_Db_Table_Abstract::NAME))
                                		->columns(array('nome_categoria'))
                                    );
		$this->view->categorias = $nome_categorias;
        
		$comoModel = new Application_Model_Comocomprar();

        $como = $comoModel->fetchAll( $comoModel->select()->where('id = 1'));
		$url = $como[0]['link'];
		$this->Youtube($url);
		$emb = $this->getObj($url);
		$this->view->video = $emb;
    }
	public function Youtube($url){
		$this->view->vid = $url;
		$this->view->code = $this->getVideoCode($url);
	}
	public function getVideoCode($url) {
		$videoUrl = $url;
		
		$arr_return = explode("watch?v=",$videoUrl);
		$arr_return = explode("&",$arr_return[1]);
		return $arr_return[0];
	}	
	public function getObj($url) {
		$videoUrl = $this->view->vid;
		$url = $this->getVideoCode($videoUrl);
		$obj = "<object width='560' height='340'>
				<param name='movie' value='http://www.youtube.com/v/#VIDEO#&hl=pt-br&fs=1&rel=0'></param>
				<param name='allowFullScreen' value='true'></param>
				<param name='allowscriptaccess' value='always'></param>
				<embed src='http://www.youtube.com/v/#VIDEO#&hl=pt-br&fs=1&rel=0' type='application/x-shockwave-flash' allowscriptaccess='always' allowfullscreen='true' width='560' height='340'></embed>
				</object>";
				
		$obj = str_replace("#VIDEO#", $url, $obj);
		return $obj;
	}
	public function getThumbUrl($url){
		$this->code = $this->view->code;	
		return "http://i1.ytimg.com/vi/".$this->code."/default.jpg";
	}
	public function getThumb($url){
		$obj = '<img qlicon="#VIDEO#" src="http://i1.ytimg.com/vi/#VIDEO#/default.jpg" title="" alt="" />';
		return str_replace("#VIDEO#", $url, $obj);
	}
	
	public function getImagemGrande($url){
		$videoUrl = $url;
			
		$url = $this->view->code;
		$obj = '<img qlicon="#VIDEO#" src="http://i1.ytimg.com/vi/#VIDEO#/hqdefault.jpg" title="" alt="" />';
		
		return str_replace("#VIDEO#", $url, $obj);
	}

}

