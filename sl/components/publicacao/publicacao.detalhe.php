<?

$tpl = new WTemplate(WPath::tpl("publicacao.detalhe"));

$publicacao = new Publicacao();
$publicacao->load(pega("id"));

WMain::$facebookTags["titulo"] = $publicacao->titulo;
WMain::$facebookTags["descricao"] = $publicacao->chamada;
WMain::$facebookTags["imagem"] = WPath::arquivo("home_".$publicacao->imagem,"publicacao");

$tpl->pg_atual = WSEOUrl::getUrlAtual();

$tpl->bind($publicacao);

$tpl->imagem = WPath::arquivo($publicacao->imagem,"publicacao");
$tpl->data = WDate::format($publicacao->data);

$tpl->pg_atual = WSEOUrl::getUrlAtual();

$tpl->show();

?>