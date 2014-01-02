<?php

$toolbar = new WAdminToolbar();

switch (WMain::$task) {
	case "novo":
	case "edit":
		$toolbar->form();
		break;
	default:		
		$toolbar->btEditar();		
		break;
}

$toolbar->show();

?>