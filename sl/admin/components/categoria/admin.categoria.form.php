<?php

$form = new WAdminForm($row);

//---------------------------------------------

$field = new WHtmlInput("Nome","nome");
$form->add($field);

if (property_exists($row, "publicado")) {
	$field = new WHtmlCheck("Publicado","publicado");
	$form->add($field);
}

//---------------------------------------------

$form->show();

?>