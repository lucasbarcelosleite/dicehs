<?

$tpl = new WTemplate(WPath::tpl("liga.lista"));

// ========================================================================================
// LIGAS
// ========================================================================================

$liga = new Liga();
$rows = $liga->select();


foreach ($rows as $row) {
	$tpl->liga_nome	= $row->nome;
	$tpl->liga_link = WSEOUrl::format("index.php?option=liga&Itemid=5&id=".$row->id_liga);

	$ranking = new Ranking();
	$ranks = $ranking->select("where id_liga = ".$row->id_liga." and publicado = 1", "order by data desc",3,0);
	
	foreach ($ranks as $i => $rank) {
		$tpl->rank_class = ($i == 0) ? "first" : (($i == 2) ? "last" : "");
		$tpl->rank_link = WSEOUrl::format("index.php?option=ranking&Itemid=5&id=".$rank->id_ranking);
		$tpl->rank_img = $rank->imagem ? WPath::arquivo("home_".$rank->imagem,"ranking") : WPath::imagem("default.jpg"); 
		$tpl->rank_rodada = $rank->rodada;
		$tpl->rank_data = WDate::format($rank->data);
		$tpl->rank_chamada = $rank->chamada;
		$tpl->parseBlock("RANK_ITEM");
	}

	$tpl->parseBlock("LIGA_ITEM");
}

$tpl->show();
?>