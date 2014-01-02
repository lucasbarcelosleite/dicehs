<?php

class Formato extends WModel {

	var $id_formato = null;
	var $nome = null;

	function  __construct() {
		parent::__construct("#S_formato", "id_formato", "nome", "nome");
	}
}

?>