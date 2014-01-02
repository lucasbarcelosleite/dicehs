<?php

$grid = new WAdminLista(array(), array(), "", WMain::$option.pega("classe").pega("classe_id"));
$grid->setObj($this->obj);

//---------------------------------------------

$col = new WAdminListaColuna("Nome da Formato","nome");
$grid->add($col);


$grid->autoLista($rows, $total);
$grid->show();

?>