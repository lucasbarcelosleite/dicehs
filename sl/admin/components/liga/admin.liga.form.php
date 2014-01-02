<?php

$form = new WAdminForm($row);

//---------------------------------------------

$formato = new Formato();
$field = new WHtmlCombo("Formato","id_formato");
$field->options = $formato->selectAssoc();
$form->add($field);

$field = new WHtmlInput("Nome da Liga/Temporada","nome");
$form->add($field);

$field = new WHtmlEditorArea("Texto","texto");
$form->add($field);

$field = new WHtmlEditorArea("Texto da Premia&ccedil;&atilde;o do Ranking","texto_premiacao");
$form->add($field);

//---------------------------------------------

$form->show();

?>