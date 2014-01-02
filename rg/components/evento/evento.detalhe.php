<?

$tpl = new WTemplate(WPath::tpl("evento.detalhe"));

$evento = new Evento();
$evento->load(pega("id"));

WMain::$facebookTags["titulo"] = $evento->titulo;
WMain::$facebookTags["descricao"] = $evento->chamada;
WMain::$facebookTags["imagem"] = WPath::arquivo("home_".$evento->imagem,"evento");

$tpl->dia_semana = WDate::diaExtenso($evento->data);
$tpl->bind($evento);

$tpl->imagem = WPath::arquivo($evento->imagem,"evento");

if ($evento->id_liga) {
	$liga = new Liga();
	$liga->load($evento->id_liga);

	$tpl->liga_nome = $liga->nome;
	$tpl->liga_url = WSEOUrl::format("index.php?option=liga&Itemid=5&id=".$evento->id_liga);
	$tpl->parseBlock("POSSUI_LIGA");	
} 

if ($evento->id_formato) {
	$formato = new Formato();
	$formato->load($evento->id_formato);
	$tpl->formato_nome = $formato->nome;
	$tpl->parseBlock("POSSUI_FORMATO");	
}

if ($evento->tipo == Evento::$__TIPO_PONTUAL) {

	$tpl->data = WDate::format($evento->data);

		if (WDate::diferencaDias($evento->data, date("Y-m-d")) > 0) {

			if ($evento->id_ranking) {
				$tpl->ranking_url = WSEOUrl::format("index.php?option=ranking&Itemid=5&id=".$evento->id_ranking);
				$tpl->parseBlock("POSSUI_RANKING");
			}

			$tpl->parseBlock("EVENTO_REALIZADO");
		} else {

			$conteudo = new Conteudo();
			$tpl->endereco_dice = strip_tags($conteudo->getHtmlByChave("endereco_eventos"));

			$tpl->parseBlock("EVENTO_ANUNCIO");
		}

	$tpl->parseBlock("TIPO_EVENTO_PONTUAL");	
} else {
	if ($evento->tipo == Evento::$__TIPO_REGULAR) {

		$tpl->parseBlock("TIPO_EVENTO_REGULAR");
	}	
}

if ($evento->premiacao) {
	$tpl->texto_premiacao = $evento->premiacao;
	$tpl->parseBlock("POSSUI_PREMIACAO");		
}

$tpl->pg_atual = WSEOUrl::getUrlAtual();

$tpl->show();

?>