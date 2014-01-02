<?php

class UsuarioGrupo extends WModel {
	 
	var $id_usuario_grupo = null;
	var $nome = null;
	var $ordering = null;
	 
	function __construct() {
		$this->_ordemTipo = "last";
		parent::__construct("#S_usuario_grupo", "id_usuario_grupo", "nome", "ordering");
	}
	 
	function check() {
		if ($this->nome == "") {
			$this->setErrorJs("nome","Nome deve ser preenchido.");
			return false;
		}
		return true;
	}
	 
}

?>