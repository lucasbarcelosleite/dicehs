<?php

class ConteudoController extends AdminController {

	function __construct(&$obj) {
		parent::__construct($obj);
	}
	 
}

$conteudo = new Conteudo();
new ConteudoController($conteudo);

?>