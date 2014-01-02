<?php

$grid = new WAdminLista(array(), array(), "", WMain::$option.pega("classe").pega("classe_id"));
$grid->setObj($this->obj);

//---------------------------------------------
$col = new WAdminListaColuna("Imagem","imagem");
$col->setImage("ranking","thumb_");
$col->largura = 120;
$grid->add($col);

$col = new WAdminListaColuna("Liga","liga->nome");
$col->largura = 120;
$grid->add($col);

$col = new WAdminListaColuna("Rodada","rodada");
$grid->add($col);

$col = new WAdminListaColuna("Chamada","chamada");
$col->largura = 120;
$grid->add($col);

$col = new WAdminListaColuna("Data","data");
$col->setFuncao("WDate::format");
$grid->add($col);

$col = new WAdminListaColuna("Publicado","publicado");
$col->setFlag();
$grid->add($col);

$grid->autoLista($rows, $total);
$grid->show();

?>