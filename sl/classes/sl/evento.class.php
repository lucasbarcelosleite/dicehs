<?php

class Evento extends WModel {

	var $id_evento = null;
	var $id_formato = null;
	var $id_liga = null;
	var $id_ranking = null;
	var $tipo = null;
	var $titulo = null;
	var $chamada = null;
	var $dia_hora_permanente = null;
	var $imagem = null;
	var $texto_anuncio = null;
	var $texto_report = null;
	var $premiacao = null;
	var $data = null;
	var $hora = null;
	var $publicado = null;	

	public static $__TIPO_PONTUAL = 1;
	public static $__TIPO_REGULAR = 2;
	public static $__REL_TIPOS = array("1" => "Pontuais", "2" => "Regulares");


	function  __construct() {
		parent::__construct("#D_evento", "id_evento", "titulo", "titulo");
	}
}

?>