<?php

class LigaController extends AdminController {

	function __construct(&$obj) {
		parent::__construct($obj);
	}

	function listar($where = "") {
		$aFormato = $this->obj->join("left", new Formato());
	
		$this->vSearch[] = $this->obj->_tbl_alias.".nome";
		$this->vSearch[] = $aFormato.".nome";
	
		$where = $this->setListVars($where);
		$total = $this->obj->selectCount($where);
		$rows  = $this->obj->select($where, $this->sort, $this->limit, $this->offset);
	
		require WPath::adminList();
	}
}

$liga = new Liga();
new LigaController($liga);

?>