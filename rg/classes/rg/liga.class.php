<?php

/*
 * CREATE TABLE IF NOT EXISTS `dhs_liga` (
  `id_liga` int(11) NOT NULL auto_increment,
  `id_formato` int(11) NOT NULL ,
  `id_cidade` int(11) NOT NULL ,
  `nome` varchar(150) NOT NULL default '',
  `texto` text,
  PRIMARY KEY  (`id_liga`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
 * */

class Liga extends WModel {

	var $id_liga = null;
	var $id_formato = null;
	var $nome = null;
	var $publicado = null;
	var $texto = null;
	var $texto_premiacao = null;

	function  __construct() {
		parent::__construct("#D_liga", "id_liga", "nome", "nome");
	}
}

?>