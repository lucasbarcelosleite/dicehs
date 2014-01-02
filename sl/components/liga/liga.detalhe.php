<?

$tpl = new WTemplate(WPath::tpl("liga.detalhe"));

$liga = new Liga();
$liga->load(pega("id"));

$tpl->bind($liga);

WMain::$facebookTags["titulo"] = $liga->titulo;

$ranking = new Ranking();
$rows = $ranking->select("where id_liga = ".$liga->id_liga." and publicado = 1", "order by data desc");

// simulando varias linhas
// $rows = array_merge($rows,$rows,$rows,$rows,$rows,$rows);

if (count($rows)) {
	foreach ($rows as $i => $row) {
		$tpl->rodada = $row->rodada;
		$tpl->imagem = WPath::arquivo("home_".$row->imagem,"ranking");
		$tpl->data = WDate::format($row->data);
		$tpl->link = WSeoURL::format("index.php?option=ranking&Itemid=5&id=".$row->id_ranking);
		$tpl->parseBlock("RANK_ITEM");
	}
}

$tpl->show();

?>