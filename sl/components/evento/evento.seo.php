<?php

WSEOUrl::add("eventos");

if ($id) {
	$evento = new Evento();
	$evento->load($id);
	WSEOUrl::add("evento-".$id);
	WSEOUrl::add(substr($evento->titulo,0,50));
} 

?>