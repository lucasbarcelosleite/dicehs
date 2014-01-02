<?php

class UsuarioGrupoMenuAdmin extends WModel {
	 
	var $id_usuario_grupo_menu_admin = null;
	var $id_usuario_grupo = null;
	var $id_menu_admin = null;
	 
	function __construct() {
		parent::__construct("#S_usuario_grupo_menu_admin", "id_usuario_grupo_menu_admin", "id_menu_admin", "id_usuario_grupo");
	}
	 
	function check() {
		if ($this->id_usuario_grupo == "") {
			$this->setErrorJs("id_usuario_grupo","Grupo deve ser preenchido.");
			return false;
		}
		if ($this->id_menu_admin == "") {
			$this->setErrorJs("id_menu_admin","Menu deve ser selecionado.");
			return false;
		}
		return true;
	}
}

?>