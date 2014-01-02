<?php

$grid = new WAdminLista();
$grid->setObj($this->obj);

$col = new WAdminListaColuna("Texto","texto");
$grid->add($col);

if (IN_DEVEL) {
	$col = new WAdminListaColuna("Chave","chave");
	$col->largura = 200;
	$grid->add($col);
}

$grid->autoLista($rows, $total);
$grid->show();

?>