<?php

class SeoMenu extends WModel {

	var $id_seo_menu = null;
	var $id_menu = null;
	var $page_title = null;
	var $meta_description = null;
	var $meta_keywords = null;

	function __construct() {
		parent::__construct("#__seo_menu", "id_seo_menu", "page_title", "page_title");
	}

	function check() {
		if ($this->id_menu == "") {
			$this->setErrorJs("id_menu", "A escolha de um menu � obrigat�ria.");
			return false;
		}
		return true;
	}

}

?>