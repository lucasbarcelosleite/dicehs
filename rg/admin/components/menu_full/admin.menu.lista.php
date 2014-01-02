<?php

$grid = new WAdminLista();
$grid->setObj($this->obj);

//---------------------------------------------

$col = new WAdminListaColuna("Titulo","titulo");
$grid->add($col);

$col = new WAdminListaColuna("Conteudo","link");
$col->largura = 60;
$col->align = center;
$col->ordem = false;
$col->setFuncaoObj("showLink");
$grid->add($col);

$col = new WAdminListaColuna("Publicado","publicado");
$col->setFlag();
$grid->add($col);

$col = new WAdminListaColuna("Ordem","ordering");
$col->setOrdering();
$grid->add($col);

//---------------------------------------------

$grid->autoLista($rows, $total);
$grid->show();

function showLink($obj){
	if ($obj->id_conteudo) {
		return '<a href="index.php?Adminid=7&id_menu='.$obj->id_menu.'&classe=Menu&classe_id='.$obj->id_menu.'&voltar_cp='.WMain::$option.'&voltar_id='.pega("Adminid").'&option=conteudo&task=edit&cid[]='.$obj->id_conteudo.'"><img src="'.WPath::img("bt-editar-form.png").'" title="Editar conte�do"></a>';
	} elseif (!$obj->link) {
		return '<a href="index.php?Adminid=7&id_menu='.$obj->id_menu.'&classe=Menu&classe_id='.$obj->id_menu.'&voltar_cp='.WMain::$option.'&voltar_id='.pega("Adminid").'&option=conteudo&task=novo"><img src="'.WPath::img("bt-novo-form.png").'" title="Novo conte�do"></a>';
	}
}

?>