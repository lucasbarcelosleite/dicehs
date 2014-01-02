<?php

class TextoLayoutController extends AdminController {
	 
	function __construct(&$obj) {
		parent::__construct($obj);
	}
}

new TextoLayoutController(new TextoLayout());

?>