<?php

$grid = new WAdminLista(array(), array(), "", WMain::$option.pega("classe").pega("classe_id"));
$grid->setObj($this->obj);

//---------------------------------------------
$col = new WAdminListaColuna("Imagem","imagem");
$col->setImage("publicacao","thumb_");
$col->largura = 120;
$grid->add($col);

$col = new WAdminListaColuna("Título","titulo");
$grid->add($col);

$col = new WAdminListaColuna("Data","data");
$col->setFuncao("WDate::format");
$grid->add($col);

$col = new WAdminListaColuna("Categoria","publicacao_categoria->nome");
$col->largura = 120;
$grid->add($col);

$col = new WAdminListaColuna("Locais","publicar_em");
$col->setFuncao("defPublicarEm");
$grid->add($col);

$col = new WAdminListaColuna("Publicado","publicado");
$col->setFlag();
$grid->add($col);

$grid->autoLista($rows, $total);
$grid->show();

function defPublicarEm($v) {
	$vetPublicar = array ("Todos", "Rio Grande", "Sao Leopoldo");
	return ($v == null) ? "Todos" : $vetPublicar[$v];
}

?>