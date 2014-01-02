<?php

global $modelos, $backgrounds;

$form = new WAdminForm($row);

//---------------------------------------------

$field = new WHtmlInput("Nome","nome");
$form->add($field);

$field = new WHtmlUpload("Imagem (recomendado 1500x480)","imagem","thumb");
$form->add($field);

//---------------------------------------------

$form->show();

?>