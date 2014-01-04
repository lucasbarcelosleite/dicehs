<?

$tpl = new WTemplate(WPath::tpl("spoiler.detalhe"));

$spoiler = new Spoiler();
$spoiler->load(pega("id"));


WMain::$facebookTags["titulo"] = $spoiler->titulo;
WMain::$facebookTags["descricao"] = $spoiler->chamada;
WMain::$facebookTags["imagem"] = WPath::arquivo($spoiler->imagem,"spoiler");

$tpl->bind($spoiler);

$tpl->texto = nl2br($spoiler->texto);

if ($spoiler->fonte) {
	$tpl->parseBlock("FONTE");
}

$tpl->imagem = WPath::arquivo($spoiler->imagem,"spoiler");

$tpl->pg_detalhe = WSEOUrl::format("index.php?option=spoiler&act=detalhe&Itemid=7&id=".$spoiler->id_spoiler."&edicao=".$spoiler->id_edicao);

if (pega("act")) {
	$edicao = new Edicao();
	$edicao->load($spoiler->id_edicao);

	$tpl->edicao_nome = $edicao->nome;
	$tpl->pg_lista = WSEOUrl::format("index.php?option=spoiler&Itemid=7&edicao=".$spoiler->id_edicao);	
	$tpl->parseBlock("BLOCO_VOLTAR");	
}

$tpl->show();

?>