<?php

class UsuarioUsuarioGrupo extends WModel {
	 
	var $id_usuario_usuario_grupo = null;
	var $id_usuario_grupo = null;
	var $id_usuario = null;
	 
	function __construct() {
		parent::__construct("#S_usuario_usuario_grupo", "id_usuario_usuario_grupo", "id_usuario_grupo", "id_usuario_usuario_grupo");
	}
	 
	function check() {
		if ($this->id_usuario == "") {
			$this->setErrorJs("id_usuario","Usuario deve ser preenchido.");
			return false;
		}
		if ($this->id_usuario_grupo == "") {
			$this->setErrorJs("id_usuario_grupo","Grupo deve ser preenchido.");
			return false;
		}
		return true;
	}
	 
	function salvarGrupos($id_usuario, $vGrupos) {
		$this->deleteWhere("WHERE id_usuario = ".$id_usuario);
		if (count($vGrupos)) {
			foreach ($vGrupos as $id_usuario_grupo) {
				$this->id_usuario_usuario_grupo = "";
				$this->id_usuario       = $id_usuario;
				$this->id_usuario_grupo = $id_usuario_grupo;
				$this->store();
			}
		}
	}

	static function tipoGrupo($id_usuario_grupo) {
		 
		$box_mostrar = "";
		if ($id_usuario_grupo == 5) $box_mostrar = "veiculo";      // imprensa
		if ($id_usuario_grupo == 6) $box_mostrar = "bancario";     // fornecedor
		if ($id_usuario_grupo == 7) $box_mostrar = "associado";    // associado
		return $box_mostrar;
	}

}

?>