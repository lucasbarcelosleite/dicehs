<?php

class PublicacaoCategoria extends WModel {

	var $id_publicacao_categoria = null;
	var $nome = null;
	var $texto = null;
	var $publicado = null;
	
	function  __construct() {
		parent::__construct("#S_publicacao_categoria", "id_publicacao_categoria", "nome", "nome");
	}

	static function getClass($id) {
		$vClass = array("info", "important", "success", "warning");

		return (isset($vClass[$id]) ? $vClass[$id] : "inverse");
	}
}

?>