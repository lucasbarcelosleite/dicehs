<?php

class SeoUrl extends WModel {
	 
	public $id_seo_url = null;
	public $url_old = null;
	public $url_new = null;
	public $page_title = null;
	public $is_ativa = null;
	public $is_automatica = null;

	function __construct() {
		parent::__construct("#__seo_url", "id_seo_url", "url_new", "url_new");
	}

	function check() {
		if ($this->url_new == "") {
			$this->setErrorJs("url_new", "A URL nova deve ser preenchida.");
			return false;
		}
		if ($this->url_old == "") {
			$this->setErrorJs("url_old", "A URL origem deve ser preenchida.");
			return false;
		}
		return true;
	}

}

?>