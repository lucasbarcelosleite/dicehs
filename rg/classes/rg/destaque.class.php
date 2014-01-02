<?php

class Destaque extends WModel {

	var $id_destaque = null;
	var $imagem = null;
	var $publicado = null;
	var $url = null;
	var $id_background = null;
	var $titulo = null;
	var $modelo = null;
	var $ordering = null;

	function  __construct() {
		parent::__construct("#D_destaque", "id_destaque", "titulo", "ordering");
	}
}

?>