<?php

class Edicao extends WModel {

	var $id_edicao = null;
	var $sigla = null;
	var $nome = null;
	var $nome_pt = null;
	var $is_spoiler = null;
	var $imagem = null;

	function  __construct() {
		parent::__construct("#S_edicao", "id_edicao", "nome", "nome");
	}
}

?>