<?php

class ModuloMenu extends WModel {
	 
	var $id_modulo_menu = null;
	var $id_modulo = null;
	var $id_menu = null;
	 
	function __construct() {
		parent::__construct('#__modulo_menu', 'id_modulo_menu', 'id_menu', 'id_modulo');
	}
	 
	function check() {
		if ($this->id_modulo == "") {
			$this->setErrorJs("id_modulo","Módulo deve ser preenchido.");
			return false;
		}
		if ($this->id_menu == "") {
			$this->setErrorJs("id_modulo_menu","Menu deve ser preenchido.");
			return false;
		}
		return true;
	}
	 
}

?>