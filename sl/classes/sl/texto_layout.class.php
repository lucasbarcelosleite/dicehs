<?php

class TextoLayout extends WModel {

	var $id_texto_layout = null;
	var $texto = null;
	var $chave = null;

	function __construct() {
		parent::__construct('#__texto_layout', 'id_texto_layout', 'texto', 'texto');
	}

	function check() {
		if ($this->texto == "") {
			$this->setErrorJs("texto","Texto deve ser preenchido.");
			return false;
		}
		return true;
	}

}

?>