<?php

$grid = new WAdminLista();
$grid->setObj($this->obj);

$col = new WAdminListaColuna("Nome/Titulo da Página","titulo");
$grid->add($col);

$col = new WAdminListaColuna("Endereço","link");
$grid->add($col);

$col = new WAdminListaColuna("Publicado","publicado");
$col->setFlag();
$grid->add($col);

$grid->autoLista($rows, $total);
$grid->show();

?>