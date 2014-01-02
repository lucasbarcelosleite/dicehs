<?php

class FormatoController extends AdminController {

	function __construct(&$obj) {
		parent::__construct($obj);
	}
	
}

$formato = new Formato();
new FormatoController($formato);

?>