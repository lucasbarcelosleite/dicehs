<?php

$tpl = new WTemplate(WPath::tpl());

// ========================================================================================
// DESTAQUE
// ========================================================================================
$destaques = new Destaque();
$rows = $destaques->select("where publicado = 1","order by ordering");

foreach ($rows as $row) {

	$mod = $row->modelo ? $row->modelo : 1;
	$mod = $mod > 3 ? 3 : $mod;

	$tpl->bind($row);
	if ($row->url) {
		$tpl->url = $row->url;
		$tpl->parseBlock("DESTAQUES_MOD_".$mod."_LINK");
	}

	$tpl->imagem = WPath::arquivo("home_".$row->imagem,"destaque");
	$tpl->parseBlock("DESTAQUES_MOD_".$mod);
}

// ========================================================================================
// LIGAS
// ========================================================================================

$liga = new Liga();
$rows = $liga->select("where publicado = 1");

foreach ($rows as $row) {
	$tpl->liga_nome	= $row->nome;
	$tpl->liga_ver_mais = WSEOUrl::format("index.php?option=liga&Itemid=5&id=".$row->id_liga);

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

// ========================================================================================
// EVENTOS
// ========================================================================================

$evento = new Evento();
$rows = $evento->select("where publicado = 1 and tipo = 1 and data > now()","order by data asc", 3);

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
// PUBLICACOES
// ========================================================================================

$publicacao = new Publicacao();
$cat = $publicacao->join("left", new PublicacaoCategoria());
$rows = $publicacao->select("where ".$publicacao->_tbl_alias.".publicado = 1 
							   and ".$publicacao->_tbl_alias.".publicar_em <> 2","order by data desc", 6);

$tpl->pub_ver_mais = WSEOUrl::format("index.php?option=publicacao&Itemid=3");

if (count($rows)) {
	foreach ($rows as $i => $row) {
		$tpl->pub_link = WSEOUrl::format("index.php?option=publicacao&Itemid=3&id=".$row->id_publicacao);
		$tpl->pub_img = WPath::arquivo("home_".$row->imagem,"publicacao"); 
		$tpl->pub_data = WDate::format($row->data);
		$tpl->pub_class = ($i == 0) ? "first" : (($i == 2) ? "last" : "");
		$tpl->pub_titulo = $row->titulo;
		$tpl->pub_chamada = $row->chamada;

		if ($row->id_publicacao_categoria) {
			$tpl->cat_nome = $row->publicacao_categoria->nome;
			$tpl->cat_class = PublicacaoCategoria::getClass($row->id_publicacao_categoria);
			$tpl->cat_link = WSEOUrl::format("index.php?option=publicacao&Itemid=3&categoria=".$row->id_publicacao_categoria);
		} else {
			$tpl->cat_nome = "";
		}

		$tpl->parseBlock("PUBLICACAO_ITEM");

		if  ((($i+1) % 3 == 0)or(count($rows) == $i+1)) $tpl->parseBlock("PUBLICACAO_CONTAINER");
	}
} 

$tpl->show();

?>