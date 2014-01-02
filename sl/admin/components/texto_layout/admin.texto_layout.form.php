<?php

$form = new WAdminForm($row);

//---------------------------------------------

$field = new WHtmlInput("Texto","texto");
$form->add($field);

if (IN_DEVEL) {
	$field = new WHtmlInput("Chave","chave");
	$form->add($field);
}

//---------------------------------------------

$form->show();

?>