<?

$tpl = new WTemplate(WPath::tpl("evento.lista"));

// ========================================================================================
// PROXIMOS
// ========================================================================================

$evento = new Evento();
$rows = $evento->select("where publicado = 1 and tipo = 1 and data > now()","order by data desc");

if (count($rows)) {
	foreach ($rows as $i => $row) {
		$tpl->evento_link = WSEOUrl::format("index.php?option=evento&Itemid=4&id=".$row->id_evento);
		$tpl->evento_img = WPath::arquivo("home_".$row->imagem,"evento"); 
		$tpl->evento_data = WDate::format($row->data);
		$tpl->evento_dia_semana = WDate::diaExtenso($row->data);
		$tpl->evento_class = ($i == 0) ? "first" : (($i == 2) ? "last" : "");
		$tpl->evento_hora = $row->hora;
		$tpl->evento_titulo = $row->titulo;
		$tpl->evento_chamada = $row->chamada;

		$tpl->parseBlock("EVENTO_1_ITEM");
	}
	$tpl->parseBlock("EVENTO_1_CONTAINER");
} 

// ========================================================================================
// EVENTOS REALIZADOS
// ========================================================================================

$evento = new Evento();
$rows = $evento->select("where publicado = 1 and tipo = 1 and data <= now()","order by data desc");
$temRealizados = false;

if (count($rows)) {
	$temRealizados = true;
	foreach ($rows as $i => $row) {
		$tpl->evento_link = WSEOUrl::format("index.php?option=evento&Itemid=4&id=".$row->id_evento);
		$tpl->evento_img = WPath::arquivo("home_".$row->imagem,"evento"); 
		$tpl->evento_data = WDate::format($row->data);
		$tpl->evento_dia_semana = WDate::diaExtenso($row->data);
		$tpl->evento_class = ($i == 0) ? "first" : (($i == 2) ? "last" : "");
		$tpl->evento_hora = $row->hora;
		$tpl->evento_titulo = $row->titulo;
		$tpl->evento_chamada = $row->chamada;

		$tpl->parseBlock("EVENTO_REALIZADO_ITEM");
	}
	$tpl->parseBlock("EVENTOS_REALIZADOS_CONTAINER");
} 

// ========================================================================================
// EVENTOS REGULARES
// ========================================================================================

$evento = new Evento();
$rows = $evento->select("where publicado = 1 and tipo = 2","order by id_evento desc");

if (count($rows)) {
	foreach ($rows as $i => $row) {
		$tpl->evento_link = WSEOUrl::format("index.php?option=evento&Itemid=4&id=".$row->id_evento);
		$tpl->evento_dia_hora_permanente = $row->dia_hora_permanente;
		$tpl->evento_titulo = $row->titulo;
		$tpl->evento_chamada = $row->chamada;

		$tpl->parseBlock("EVENTO_2_ITEM");
	}

	$tpl->classe_regulares = $temRealizados ? "span4" : "span12";
	$tpl->parseBlock("EVENTO_2_CONTAINER");
} 




$tpl->show();


?>