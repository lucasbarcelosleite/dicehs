<?php

$form = new WAdminForm($row);

//---------------------------------------------

$field = new WHtmlInput("Nome/Titulo da P�gina","titulo");
$form->add($field);

$field = new WHtmlInput("Link","link");
$form->add($field);

//---------------------------------------------

$form->show();

?>