<?php

$toolbar = new WAdminToolbar();

switch (WMain::$task) {
	case "novo":
	case "edit":
		$toolbar->form();
		break;
	default:
		
		$button = new stdClass();
		$button->task   = 'novo&tipo=1';
		$button->alt    = 'Novo Evento Pontual';
		$button->checkSelected = false;
		$toolbar->vButton[] = $button;		
		
		
		$button = new stdClass();
		$button->task   = 'novo&tipo=2';
		$button->alt    = 'Novo Evento Regular';
		$button->checkSelected = false;
		$toolbar->vButton[] = $button;		
		
		$toolbar->btRemover();
		$toolbar->btEditar();
		break;
}

$toolbar->show();

?>