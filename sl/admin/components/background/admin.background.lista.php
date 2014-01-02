<?php

global $modelos, $backgrounds;

$grid = new WAdminLista(array(), array(), "", WMain::$option.pega("classe").pega("classe_id"));
$grid->setObj($this->obj);

//---------------------------------------------

$col = new WAdminListaColuna("Imagem","imagem");
$col->setImage("background","thumb_");
$col->largura = 120;
$grid->add($col);

$col = new WAdminListaColuna("Nome","nome");
$grid->add($col);

$grid->autoLista($rows, $total);
$grid->show();

?>