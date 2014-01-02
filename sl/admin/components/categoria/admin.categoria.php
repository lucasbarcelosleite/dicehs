<?php

persiste("cadastro");

$cadastro = $cadastro."_categoria";

$classe = WFormat::nomePadrao("class", $cadastro);

//---------------------------------------------

class CategoriaController extends AdminController {
	 
	function __construct(&$obj) {
		parent::__construct($obj);
	}
	 
}

new CategoriaController(new $classe);

?>