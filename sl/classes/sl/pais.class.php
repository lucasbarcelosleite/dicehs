<?php

class Pais extends WModel {
	 
	var $id_pais = null;
	var $sigla = null;
	var $nome = null;
	 
	function __construct() {
		parent::__construct("#__pais", "id_pais", "nome", "nome");
	}
	 
	function check() {
		return false;
	}
	 
	function brasil() {
		return 31;
	}

}

?>