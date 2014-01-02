<?php

WSEOUrl::add("ligas-dhs");

if ($id) {
	$liga = new Liga();
	$liga->load($id);
	WSEOUrl::add("liga-".$id);
	WSEOUrl::add(substr($liga->nome,0,50));
} 

?>