<?php

$grid = new WAdminLista(array(), array(), "", WMain::$option.pega("classe").pega("classe_id"));
$grid->setObj($this->obj);

//---------------------------------------------
$col = new WAdminListaColuna("Edi&ccedil;&atilde;o","edicao->nome");
$col->largura = 120;
$grid->add($col);

$col = new WAdminListaColuna("Imagem","imagem");
$col->setImage("spoiler","thumb_");
$col->largura = 120;
$grid->add($col);

$col = new WAdminListaColuna("Texto do Card","texto");
$grid->add($col);

$grid->autoLista($rows, $total);
$grid->show();

?>