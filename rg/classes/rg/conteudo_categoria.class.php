<?php

class ConteudoCategoria extends WModel {
	 
	var $id_conteudo_categoria = null;
	var $nome = null;
	var $ordering = null;
	 
	function __construct() {
		$this->_ordemTipo = "last";
		parent::__construct("#__conteudo_categoria", "id_conteudo_categoria", "nome", "ordering");
	}
	 
	function check() {
		if ($this->nome == "") {
			$this->setErrorJs("nome","Nome deve ser preenchido.");
			return false;
		}
		return true;
	}
	 
}

?>