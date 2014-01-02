<?php

$grid = new WAdminLista(array(), array(), "", WMain::$option.pega("classe").pega("classe_id"));
$grid->setObj($this->obj);

//---------------------------------------------
/*
if(pega("classe")!="ConteudoCategoria"){
	$col = new WAdminListaColuna("Categoria","conteudo_categoria->nome");
	$col->largura = 200;
	$grid->add($col);
}
*/

$col = new WAdminListaColuna("Titulo","titulo");
$grid->add($col);

$col = new WAdminListaColuna("Publicado","publicado");
$col->setFlag();
$grid->add($col);
/*
$col = new WAdminListaColuna("Visualizar","link");
$col->setFuncaoObj("criaLink");
$col->largura = 65;
$col->align = "center";
$col->ordem = false;
$grid->add($col);
*/
//---------------------------------------------

$grid->autoLista($rows, $total);
$grid->show();

function criaLink($obj){
	$menu = new Menu();
	$menu->loadBy("id_conteudo", $obj->id_conteudo);
	if ($menu->id_menu) {
		return '<a target="blank" href="'.$menu->getLinkRow().'" title=""><img src="'.WPath::img('link.png').'" border="0" alt=""></a>';
	}
}

?>