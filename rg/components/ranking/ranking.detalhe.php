<?

$tpl = new WTemplate(WPath::tpl("ranking.detalhe"));

$ranking = new Ranking();
$ranking->load(pega("id"));

$liga = new Liga();
$liga->load($ranking->id_liga);

$tpl->liga_nome = $liga->nome;
$tpl->liga_url = WSEOUrl::format("index.php?option=liga&Itemid=5&id=".$ranking->id_liga);
$tpl->liga_texto = $liga->texto_premiacao;
$tpl->bind($ranking);

$tpl->imagem = WPath::arquivo($ranking->imagem,"ranking");
$tpl->data = WDate::format($ranking->data);

$tpl->pg_atual = WSEOUrl::getUrlAtual();

$tpl->show();

?>