<?php

class WModelLang extends WModel {

	public $id_main = null;
	public $id_lang = null;
	public $_isTraducao = false;
	public $_mapTraducao = array();

	function __construct($tabela, $pk, $default_descricao="", $default_ordem="") {
		if (!$this->_wordem) {
			$this->_wordem = array();
		}
		$this->_wordem = array_merge($this->_wordem, array("id_lang"));
	  
		parent::__construct($tabela, $pk, $default_descricao, $default_ordem);
		$this->_isLang = true;
	}

	function loadLang($id_main, $returnMain = false, $id_lang=false){
		if(!$id_lang) $id_lang = WLang::$lang->id_lang;
		$this->loadWhere("WHERE id_main=$id_main and ".$this->getWhereLang($returnMain, $id_lang));
	}

	function loadTraducao($id, $id_lang=false){
		$this->loadLang($id, true, $id_lang);
		if ($this->id_lang!=$id_lang) {
			$this->id_lang = $id_lang;
			$pk = $this->_tbl_key;
			$this->$pk = null;
			$this->_isTraducao = true;
		}
	}

	function filterLang($id_main) {
		$pk = $this->_tbl_key;
		$rows = $this->select("WHERE id_main = ".$id_main."
                              AND id_lang = ".(pega("id_lang") ? pega("id_lang") : WLang::$lang->id_lang));
		foreach (WLang::$lang_rows as $i => $lang) {
			$campo = "lang_".$lang->id_lang;
			if (!$rows[0]->$campo) {
				unset(WLang::$lang_rows[$i]);
				unset(WLang::$lang_assoc[$lang->id_lang]);
			}
		}
		return $rows[0]->$pk;
	}
	 
	function store($updateNulls=false) {
		$this->id_lang = pega("id_lang") ? pega("id_lang") : WLang::$lang->id_lang;
		if (parent::store($updateNulls)) {
			if (!$this->id_main) {
				$pk = $this->_tbl_key;
				$this->id_main = $this->$pk;
				return $this->store();
			}
			return true;
		}
		return false;
	}

	function getWhereLang($returnMain=false, $id_lang=false, $alias=false){
		if (!$id_lang) {
			$id_lang = pega("tid_lang", WLang::$lang->id_lang);
		}
		if (!$alias) {
			$alias = $this->_tbl_alias;
		}
		if ($returnMain) {
			return "((".$alias.".id_main=".$alias.".".$this->_tbl_key." and (SELECT count(*) FROM ".$this->_tbl." al WHERE al.id_main=".$alias.".id_main and al.id_lang=".$id_lang.")=0) or (".$alias.".id_lang=".$id_lang."))";
		} else {
			return $alias.".id_lang=".$id_lang;
		}
	}

	function getWhereJoinLang($returnMain = false, $id_lang=false){
		return $this->getWhereLang($returnMain, $id_lang, $this->_tbl_alias);
	}

	function getCamposLang($alias_cp="", $alias_tbl=false){
		$campos = "";
		if (!$alias_tbl) {
			$alias_tbl = $this->_tbl_alias;
		}
		foreach (WLang::$lang_rows as $lang){
			$campos .= ", (SELECT count(*) FROM ".$this->_tbl." al WHERE al.id_main=".$alias_tbl.".id_main and al.id_lang=".$lang->id_lang.") as ".$alias_cp."lang_".$lang->id_lang." ";
		}
		return $campos;
	}

	function select($where="", $ordem = "", $limit=0, $offset=0) {
		if (!is_array($this->_vt_join)) {
			if ($ordem=="") {
				$ordem = "ORDER BY " . $this->_tbl_default_ordem;
			}
			$this->_db->setQuery("SELECT * FROM ".$this->_tbl." ".$this->_tbl_alias." $where $ordem", $limit, $offset);
			return $this->_db->loadObjectList();
		} else {
			return parent::select($where, $ordem, $limit, $offset);
		}
	}

	function selectJoinSQL($where="", $ordem = "", $distinct = false){
		$joins  = $this->joinSql();
		$campos = $this->joinSqlCampos();

		if (($ordem == "")&&($ordem!==false)) {
			$ordem = "\n ORDER BY ".$this->_tbl_alias.".".$this->_tbl_default_ordem;
		}

		return "SELECT ".($distinct?"DISTINCT ":"").$campos.$this->getCamposLang("root___",$this->_tbl_alias)." FROM ".$this->_tbl." ".$this->_tbl_alias." $joins $where $ordem";
	}

	function selectAssoc($sqlExtraWhere="", $sqlExtraOrdem="", $returnMain="") {
		$this->_mapTraducao = array();
		$assoc = array();
		$campo = $this->_tbl_default_descricao;
		$key = $this->_tbl_key;
		$vet = $this->select(WModel::andWhere($sqlExtraWhere, $this->getWhereLang($returnMain)), $sqlExtraOrdem);
		if (count($vet)) {
			foreach ($vet as $i => $obj) {
				$value = $obj->$key;
				$label = $obj->$campo;
				$this->_mapTraducao[$value] = $obj->id_main;
				$assoc[$value] = $label;
			}
		}
		return $assoc;
	}

}

?>