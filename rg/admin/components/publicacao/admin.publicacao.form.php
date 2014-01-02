<?php

$form = new WAdminForm($row);

//---------------------------------------------

$publCat = new PublicacaoCategoria();
$field = new WHtmlCombo("Categoria","id_publicacao_categoria");
$field->options = $publCat->selectAssoc();
$form->add($field);

$field = new WHtmlInput("Título","titulo");
$form->add($field);

$field = new WHtmlInputData("Data","data");
$form->add($field);

$field = new WHtmlUpload("Imagem p/ Chamada","imagem","thumb");
$form->add($field);

$field = new WHtmlTextArea("Chamada","chamada");
$field->limite = 120;
$form->add($field);

$field = new WHtmlEditorArea("Texto","texto");
$form->add($field);

$field = new WHtmlCombo("Publicar Em","publicar_em");
$field->options = array ("Todos", "Rio Grande", "Sao Leopoldo");
$form->add($field);

$field = new WHtmlCheck("Publicado","publicado");
$form->add($field);

//---------------------------------------------

$form->show();

?>