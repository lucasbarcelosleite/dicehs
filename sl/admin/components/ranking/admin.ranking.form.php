<?php

$form = new WAdminForm($row);

//---------------------------------------------

$liga = new Liga();
$field = new WHtmlCombo("Liga","id_liga");
$field->options = $liga->selectAssoc();
$form->add($field);

$field = new WHtmlInput("Rodada","rodada");
$form->add($field);

$field = new WHtmlInputData("Data","data");
$form->add($field);

$field = new WHtmlUpload("Card p/ Chamada","imagem","thumb");
$form->add($field);

$field = new WHtmlTextArea("Chamada","chamada");
$field->limite = 120;
$form->add($field);

$field = new WHtmlEditorArea("Ranking","texto_ranking");
$form->add($field);

$field = new WHtmlEditorArea("Report","texto_report");
$form->add($field);

$field = new WHtmlCheck("Publicado","publicado");
$form->add($field);

//---------------------------------------------

$form->show();

?>