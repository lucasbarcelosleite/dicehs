<?php

class Conteudo extends WModel {
	 
	var $id_conteudo = null;
	var $id_conteudo_categoria = null;
	var $titulo = null;
	var $texto = null;
	var $publicado = null;
	var $chave = null;
	var $link = null;
	var $limit_char = null;
	var $tem_video = null;
	 
	var $_nroImagens  = 1;
	var $_nroArquivos = 0;
	 
	function __construct() {
		parent::__construct("#__conteudo", "id_conteudo", "titulo", "id_conteudo_categoria, titulo");
	}
	 
	function check() {
		if ($this->titulo == "") {
			$this->setErrorJs("titulo","Titulo deve ser preenchido.");
			return false;
		}
		if ($this->texto == "") {
			$this->setErrorJs("texto","Texto deve ser preenchido.");
			return false;
		}
		return true;
	}
	 
	function store($updateNulls=false, $ordemTipo=false){
		if(!$this->id_conteudo){
			if($this->id_menu){
				$cache = new WCache("lista_menu_admin");
				$cache->clear();
			}
		}
		return parent::store($updateNulls, $ordemTipo);
	}

	function getHtml($id_main) {
		$conteudo = new Conteudo();
		$conteudo->load($id_main);
		return $conteudo->format();
	}

	function getHtmlByChave($chave) {
		$conteudo = new Conteudo();
		$conteudo->loadWhere("WHERE chave = '$chave'");
		return $conteudo->format();
	}
	 
	function getHtmlDiagramado($id_main) {
		 
		$conteudo = new Conteudo();
		$conteudo->loadWhere("WHERE id_main = ".$id_main." AND publicado = 1");
		$conteudo->format();

		if ($conteudo->texto) {
			 
			$conteudoMidia = new ConteudoMidia();

			//-- IMAGENS
			$imagens = $conteudoMidia->select("WHERE id_conteudo = ".$conteudo->id_conteudo." AND tipo = 'imagem'");
			if (count($imagens)) {
				foreach ($imagens as $i => $imagem) {
					$vImage[$i]["descricao"] = $imagem->descricao;
					$vImage[$i]["arquivo"]   = $imagem->arquivo;
				}
			}

			//-- ARQUIVOS
			$arquivos = $conteudoMidia->select("WHERE id_conteudo = ".$conteudo->id_conteudo." AND tipo = 'arquivo'");
			if (count($arquivos)) {
				foreach ($arquivos as $i => $arquivo) {
					$vFile[$i]["descricao"] = $arquivo->descricao;
					$vFile[$i]["arquivo"]   = $arquivo->arquivo;
				}
			}

			$diagramacao = new Diagramacao($conteudo->texto, $vImage, $vFile, "conteudo");
			$conteudo->texto = $diagramacao->getHtml();
		}

		return $conteudo->texto;
	}
	 
	function format() {
		return $this->texto;
	}

}

?>