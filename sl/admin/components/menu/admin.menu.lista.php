<?php

$grid = new WAdminLista();
$grid->setObj($this->obj);

$col = new WAdminListaColuna("Nome/Titulo da P�gina","titulo");
$grid->add($col);

$col = new WAdminListaColuna("Endere�o","link");
$grid->add($col);

$col = new WAdminListaColuna("Publicado","publicado");
$col->setFlag();
$grid->add($col);

$grid->autoLista($rows, $total);
$grid->show();

?>