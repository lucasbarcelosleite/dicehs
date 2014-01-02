<?php

class ConteudoMidia extends WModel {
	 
	var $id_conteudo_midia = null;
	var $id_conteudo = null;
	var $tipo = null;
	var $arquivo = null;
	var $is_arquivo_main = null;
	var $descricao = null;
	var $width = null;
	var $height = null;
	var $is_original = null;
	 
	function __construct() {
		parent::__construct("#__conteudo_midia", "id_conteudo_midia", "tipo", "tipo");
	}
	 
	function check() {
		if ($this->id_conteudo == "") {
			$this->setErrorJs("id_conteudo","Conte�do deve ser preenchido.");
			return false;
		}
		if ($this->tipo == "") {
			$this->setErrorJs("tipo","Tipo deve ser preenchido.");
			return false;
		}
		if ($this->arquivo == "") {
			$this->setErrorJs("arquivo","Arquivo deve ser preenchido.");
			return false;
		}
		return true;
	}
	 
}

?>