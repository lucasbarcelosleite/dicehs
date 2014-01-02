<?php

class WRSS {

	public $titulo = null;
	public $logo = null;
	public $lingua = null;

	public $lista = array();

	function __construct($titulo,$lista,$logo="logo_tpe.jpg") {
		$this->titulo = $titulo;
		$this->lista = $lista;
		$this->lingua = WLang::$lang->sigla;
		$this->logo = WPath::img($logo);
	}

	function setTitulo($titulo) {
		$this->titulo = $titulo;
	}

	function show() {
		header("Content-Type: text/xml");
		$tpl = new WTemplate(WPath::tpl("rss","shared"));
		 
		foreach ($this->lista as $noticia){
			$tpl->titulo = $noticia['titulo'];
			$tpl->link = $noticia['link'];
			$tpl->descricao = $noticia['descricao'];
			$tpl->parseBlock("LISTA");
		}
		 
		$tpl->encoding = WConfig::$siteEncoding;
		$tpl->titulo = $this->titulo;
		$tpl->lingua = $this->lingua;
		$tpl->logo = $this->logo;
		$tpl->logo_width = 144;
		$tpl->logo_height = 60;
		$tpl->show();
		exit;
	}

}
