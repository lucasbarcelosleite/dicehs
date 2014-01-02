<?php

class MenuAdmin extends WModel {
	 
	var $id_menu_admin = null;
	var $titulo = null;
	var $subtitulo = null;
	var $link = null;
	var $icone = null;
	var $is_painel = null;
	var $parent = null;
	var $ordering = null;

	function __construct() {
		parent::__construct('#__menu_admin', 'id_menu_admin', 'titulo','parent, ordering');
	}
	 
	function montaMenu($where='', $idPai=0, $nivel=0, $separador="&nbsp;") {
		$rows = $this->select(($where ? $where ." AND " : " WHERE "). "parent=$idPai");

		$menu = array();
		if (count($rows)) {
			foreach ($rows as $row) {
				$row->titulo = str_repeat(str_repeat($separador,8), $nivel) . $row->titulo;
				$menu[] = $row;
				$menu = array_merge($menu, $this->montaMenu($where, $row->id_menu_admin, ($nivel+1), $separador));
			}
		}
		return $menu;
	}
}

?>
