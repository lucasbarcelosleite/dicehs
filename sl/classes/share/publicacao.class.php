<?php

class Publicacao extends WModel {

	var $id_publicacao = null;
	var $id_publicacao_categoria = null;
	var $titulo = null;
	var $data = null;
	var $chamada = null;
	var $imagem = null;
	var $texto = null;
	var $publicado = null;
	var $publicar_em = null;
	
	function  __construct() {
		parent::__construct("#S_publicacao", "id_publicacao", "titulo", "titulo");
	}
}

?>