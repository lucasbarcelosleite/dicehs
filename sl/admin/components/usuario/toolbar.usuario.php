<?php

$toolbar = new WAdminToolbar();

switch ( WMain::$task ) {
	case "alterarSenha":
		$toolbar->btSalvar();
		$toolbar->btVoltar();
		break;
	case "novo":
	case "edit":
	case "editarSenha":
		$toolbar->form();
		break;
	default:
		$toolbar->lista(false, false);
		break;
}

$toolbar->show();

?>