<?php

$toolbar = new WAdminToolbar();

switch (WMain::$task) {
	case "novo":
	case "edit":
		$toolbar->form();
		break;
	default:
		$toolbar->btNovo();
		$toolbar->btEditar();
		$toolbar->btRemover();
		break;
}

$toolbar->show();

?>