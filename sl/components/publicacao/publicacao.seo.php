<?php

WSEOUrl::add("artigos-noticias");

if ($id) {
	$publicacao = new Publicacao();
	$publicacao->load($id);
	
	WSEOUrl::add($publicacao->data);
	WSEOUrl::add(substr($publicacao->titulo,0,50));
} 

if ($categoria) {
	$publicacaoCategoria = new PublicacaoCategoria();
	$publicacaoCategoria->load($categoria);

	WSEOUrl::add("categoria");
	WSEOUrl::add($publicacaoCategoria->nome);
}

?>