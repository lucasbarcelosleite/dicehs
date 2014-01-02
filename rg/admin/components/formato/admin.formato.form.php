<?php

$form = new WAdminForm($row);

//---------------------------------------------

$field = new WHtmlInput("Nome da Formato","nome");
$form->add($field);

//---------------------------------------------

$form->show();

?>