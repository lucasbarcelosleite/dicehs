<?php

$grid = new WAdminLista();
$grid->setObj($this->obj);

$col = new WAdminListaColuna("Nome","nome");
$col->largura = 400;
$grid->add($col);

if (property_exists($this->obj, "publicado")) {
	$col = new WAdminListaColuna("Publicado","publicado");
	$col->setFlag();
	$grid->add($col);
}

if (property_exists($this->obj, "ordering")) {
	$col = new WAdminListaColuna("Ordem","ordering");
	$col->setOrdering();
	$grid->add($col);
}

$grid->autoLista($rows, $total);
$grid->show();

?>