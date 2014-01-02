<?php

$form = new WAdminForm($row);

//---------------------------------------------

$field = new WHtmlInput("Nome/Titulo da Página","titulo");
$form->add($field);

$field = new WHtmlInput("Link","link");
$form->add($field);

//---------------------------------------------

$form->show();

?>