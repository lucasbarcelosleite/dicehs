<?php

class PublicacaoCategoriaController extends AdminController {

	function __construct(&$obj) {
		parent::__construct($obj);
	}
	
}

$publicacaoCategoria = new PublicacaoCategoria();
new PublicacaoCategoriaController($publicacaoCategoria);

?>