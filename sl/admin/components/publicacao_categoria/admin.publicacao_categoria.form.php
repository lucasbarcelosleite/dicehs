<?php

$form = new WAdminForm($row);

//---------------------------------------------

$field = new WHtmlInput("Nome da Categoria","nome");
$form->add($field);

// $field = new WHtmlEditorArea("Texto","texto");
// $form->add($field);

// $field = new WHtmlCheck("Aparece na Home?","publicado");
// $form->add($field);

//---------------------------------------------

$form->show();

?>