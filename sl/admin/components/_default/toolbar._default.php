<?php

$toolbar = new WAdminToolbar();

switch (WMain::$task) {
	case "novo":
	case "edit":
		$toolbar->form();
		break;
	default:
		$toolbar->lista(false, false);
		break;
}

$toolbar->show();

?>