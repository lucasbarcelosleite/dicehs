<?php

$form = new WAdminForm($row);

$field = new WHtmlInput("Nome","nome");
$form->add($field);

$field = new WHtmlInput("Login","login");
$form->add($field);

if($this->task=="novo"){
	$field = new WHtmlPassword("Senha","senha");
	$form->add($field);
}

$field = new WHtmlInput("E-mail","email");
$form->add($field);
/*
$usuarioGrupo = new UsuarioGrupo();

if (WMain::$usuario->permissaoAdmin()) {
	$usuarioGrupo = new UsuarioGrupo();
	$field = new WHtmlInputMultiRelacional("Grupos", "id_usuario_grupo");
	$field->origem  = $usuarioGrupo->selectAssoc();

	if ($row->id_usuario) {
		$field->destino = $usuarioGrupo->selectAssoc("WHERE id_usuario_grupo IN (SELECT id_usuario_grupo FROM #__usuario_usuario_grupo
                                                                                WHERE id_usuario = ".$row->id_usuario.")");
	} else {
		$field->destino = array();
	}
	$form->add($field);
}
*/

$form->show();

?>