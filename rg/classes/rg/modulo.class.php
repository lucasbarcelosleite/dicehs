<?php

class Modulo extends WModel {
	 
	var $id_modulo = null;
	var $titulo = null;
	var $posicao = null;
	var $arquivo = null;
	var $ordering = null;
	var $publicado = null;
	 
	function __construct() {
		$this->_ordemTipo = "LAST";
		parent::__construct('#__modulo', 'id_modulo', 'titulo', 'posicao, ordering');
	}
	 
	function check() {
		if ($this->titulo == "") {
			$this->setErrorJs("titulo","T�tulo deve ser preenchido.");
			return false;
		}
		if ($this->posicao == "") {
			$this->setErrorJs("posicao","Posi��o deve ser preenchida.");
			return false;
		}
		if ($this->arquivo == "") {
			$this->setErrorJs("arquivo","Arquivo deve ser preenchido.");
			return false;
		}
		return true;
	}
	 
}

?>