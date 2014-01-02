<?php

class MenuController extends AdminController {
	 
	function __construct(&$obj) {
		parent::__construct($obj);
	}
	
	function beforeCheck() {
		if ($this->obj->id_menu != 1) {
			$this->obj->parent = 1;
		}
	}
	
}

new MenuController(new Menu());

?>