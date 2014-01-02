<?php

$grid = new WAdminLista(array(), array(), "", WMain::$option.pega("classe").pega("classe_id"));
$grid->setObj($this->obj);

//---------------------------------------------

$col = new WAdminListaColuna("Imagem","imagem");
$col->setImage("evento","thumb_");
$col->largura = 120;
$grid->add($col);

$col = new WAdminListaColuna("Tipo","tipo");
$col->setFuncao("defTipo");
$col->largura = 50;
$grid->add($col);

$col = new WAdminListaColuna("Liga ou Formato","liga->nome");
$col->setFuncaoObj("defLiga");
$grid->add($col);

$col = new WAdminListaColuna("Nome do Evento","titulo");
$grid->add($col);

$col = new WAdminListaColuna("Data/Hora/Dia","data");
$col->setFuncaoObj("defDia");
$grid->add($col);


$col = new WAdminListaColuna("Publicado","publicado");
$col->setFlag();
$grid->add($col);

$grid->autoLista($rows, $total);
$grid->show();

function defTipo($v) {
	$a = array("1" => "Pontuais", "2" => "Regulares");
	return $a[$v];
}

function defDia($obj) {
	if ($obj->tipo == 1) {
		return WDate::format($obj->data)." ".$obj->hora;
	}
	if ($obj->tipo == 2) {
		return $obj->dia_hora_permanente;
	} 
}

function defLiga($obj) {
	
	$str = "";
	if ($obj->liga->nome) $str .= "Liga: ".$obj->liga->nome; 
	if ($obj->formato->nome) $str .= " ".$obj->formato->nome;
	return $str;
	
}

?>