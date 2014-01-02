<?php

global $modelos;

$form = new WAdminForm($row);

//---------------------------------------------

$field = new WHtmlInput("Título","titulo");
$form->add($field);

$field = new WHtmlUpload("Imagem (pelo menos 1280x480)","imagem","thumb");
$form->add($field);

$field = new WHtmlInput("Link para","url");
$form->add($field);

$field = new WHtmlCombo("Modelo de Destaque","modelo");
$field->options = $modelos;
$form->add($field);

$field = new WHtmlCheck("Publicado","publicado");
$form->add($field);

//---------------------------------------------

$form->show();

?>