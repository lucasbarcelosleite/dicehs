<?php

class Spoiler extends WModel {

	var $id_spoiler = null;
	var $id_edicao = null;
	var $imagem = null;
	var $texto = null;
	var $fonte = null;
	var $fonte_link = null;

	function  __construct() {
		parent::__construct("#S_spoiler", "id_spoiler", "texto", "texto");
	}
}

?>