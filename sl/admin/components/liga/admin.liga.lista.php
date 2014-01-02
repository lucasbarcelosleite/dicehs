<?php

$grid = new WAdminLista(array(), array(), "", WMain::$option.pega("classe").pega("classe_id"));
$grid->setObj($this->obj);

//---------------------------------------------
$col = new WAdminListaColuna("Formato","formato->nome");
$grid->add($col);

$col = new WAdminListaColuna("Nome da Liga/Temporada","nome");
$grid->add($col);

$col = new WAdminListaColuna("Aparece na Home?","publicado");
$col->setFlag();
$grid->add($col);


$grid->autoLista($rows, $total);
$grid->show();

?>