<?php

$form = new WAdminForm($row);

//---------------------------------------------

$edicao = new Edicao();
$field = new WHtmlCombo("Edi&ccedil;&atilde;o","id_edicao");
$field->options = $edicao->selectAssoc();
$form->add($field);

$field = new WHtmlUpload("Imagem do Card","imagem","thumb");
$form->add($field);

$field = new WHtmlTextArea("Texto do Card","texto");
$field->limite = 350;
$form->add($field);

$field = new WHtmlInput("Fonte","fonte");
$form->add($field);

$field = new WHtmlInput("URL da Fonte","fonte_link");
$form->add($field);

//---------------------------------------------

$form->show();

?>