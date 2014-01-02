<?php

global $modelos;

$grid = new WAdminLista(array(), array(), "", WMain::$option.pega("classe").pega("classe_id"));
$grid->setObj($this->obj);

//---------------------------------------------

$col = new WAdminListaColuna("Imagem","imagem");
$col->setImage("destaque","thumb_");
$col->largura = 120;
$grid->add($col);

$col = new WAdminListaColuna("Tнtulo","titulo");
$grid->add($col);

$col = new WAdminListaColuna("Posiзгo do Tнtulo","modelo");
$col->setFuncao("defModelo");
$col->largura = 50;
$grid->add($col);

$col = new WAdminListaColuna("Ordem","ordering");
$col->setOrdering();
$grid->add($col);

$col = new WAdminListaColuna("Publicado","publicado");
$col->setFlag();
$grid->add($col);

$grid->autoLista($rows, $total);
$grid->show();

function defModelo($v) {
	global $modelos;
	return $modelos[$v];
}

?>