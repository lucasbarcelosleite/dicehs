<?php

if ($id) {
	$conteudo = new Conteudo();
	$conteudo->load($id);
	WSEOUrl::add(substr($conteudo->titulo,0,50));
} 

?>