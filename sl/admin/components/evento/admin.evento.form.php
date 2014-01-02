<?php

$form = new WAdminForm($row);

//---------------------------------------------

if ((pega("tipo") == Evento::$__TIPO_PONTUAL)||($row->tipo == Evento::$__TIPO_PONTUAL)) {

	$form->titulo = "Evento Pontual";
	
	$field = new WHtmlHidden("tipo");
	$field->value = "1";
	$form->add($field);
	
	$field = new WHtmlInputData("Data do Evento","data");
	$form->add($field);
	
	$field = new WHtmlInput("Hora do Evento", "hora");
	$form->add($field);

}

if ((pega("tipo") == Evento::$__TIPO_REGULAR)||($row->tipo == Evento::$__TIPO_REGULAR)) {
	$form->titulo = "Evento Regular";
	
	$field = new WHtmlHidden("tipo");
	$field->value = "2";
	$form->add($field);
	
	$field = new WHtmlInput("Dia e Hora do Evento","dia_hora_permanente");
	$form->add($field);	
}


$formato = new Formato();
$field = new WHtmlCombo("Formato","id_formato");
$field->options = $formato->selectAssoc();
$form->add($field);

$liga = new Liga();
$field = new WHtmlCombo("ou Liga/Temporada","id_liga");
$field->options = $liga->selectAssoc();
$form->add($field);

$field = new WHtmlInput("Nome do Evento","titulo");
$form->add($field);

$field = new WHtmlUpload("Card p/ Chamada","imagem","thumb");
$form->add($field);

$field = new WHtmlTextArea("Chamada","chamada");
$field->limite = 240;
$form->add($field);

$field = new WHtmlEditorArea("Anъncio","texto_anuncio");
$form->add($field);

$field = new WHtmlEditorArea("Anъncio - Premiaзгo","premiacao");
$form->add($field);

if ((pega("tipo") == Evento::$__TIPO_PONTUAL)||($row->tipo == Evento::$__TIPO_PONTUAL)) {
	$field = new WHtmlEditorArea("Report","texto_report");
	$form->add($field);
	
	$ranking = new Ranking();
	$field = new WHtmlCombo("Ranking Relacionado","id_ranking");
	$rks = $ranking->select();
	foreach ($rks as $i => $r) {
		$l = new Liga();
		$l->load($r->id_liga);
		$vOp[$r->id_ranking] = $l->nome . " #".$r->rodada." em ".WDate::format($r->data);
	}
	
	$field->options = $vOp;
	$form->add($field);
}

$field = new WHtmlCheck("Publicado","publicado");
$form->add($field);

//---------------------------------------------

$form->show();

?>