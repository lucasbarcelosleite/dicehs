<?php

WSEOUrl::add("ranking");

if ($id) {
	$ranking = new Ranking();
	$ranking->load($id);

	$liga = new Liga();
	$liga->load($ranking->id_liga);

	WSEOUrl::add(substr($liga->nome,0,50));
	WSEOUrl::add("rodada-".$ranking->rodada);
} 

?>