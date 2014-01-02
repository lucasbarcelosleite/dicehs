<?php

$toolbar = new WAdminToolbar();

switch (WMain::$task) {
	case "novo":
	case "edit":
		$toolbar->form();
		break;
	default:		
		if (IN_DEVEL) {
			$toolbar->btNovo();
			$toolbar->btRemover();
		}				
		$toolbar->btEditar();		
		break;
}

$toolbar->show();

?>