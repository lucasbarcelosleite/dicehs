<?php

class Ranking extends WModel {

	var $id_ranking = null;
	var $id_liga = null;
	var $rodada = null;
	var $data = null;
	var $chamada = null;
	var $imagem = null;
	var $texto_report = null;
	var $texto_ranking = null;
	var $publicado = null;
	
	function  __construct() {
		parent::__construct("#D_ranking", "id_ranking", "chamada", "rodada");
	}
}

?>