<?php

class WModel {

	public $_tbl 		= '';
	public $_tbl_key 	= '';
	public $_error 	= '';

	/**
	 * @var WDatabase Atributo de Conex�o
	 * */
	public $_db 		= null;

	public $_tbl_default_descricao = null;
	public $_tbl_default_ordem = "ordering";
	public $_tbl_alias = "";
	public $_vt_join = "";
	public $_errorJs = "";
	public $_wordem = "";
	public $_ordemTipo = "first";

	public $_isLang = false;

	function __construct($tabela, $pk, $default_descricao="", $default_ordem="") {
		global $db;

		if ($default_descricao != "") {
			$this->_tbl_default_descricao = $default_descricao;
		}

		if ($default_ordem != "") {
			$this->_tbl_default_ordem = $default_ordem;
		}

		$this->_tbl_alias = $this->removePrefix($tabela);

		$this->_tbl = $tabela;
		$this->_tbl_key = $pk;
		$this->_db =& $db;
	}

	function setErrorJs($campo, $msg){
		$this->_error .= $msg;
		$this->_errorJs = " alert('".$msg."'); $('#$campo').focus(); ";
	}

	function showError($msg){
		echo " alert('".$msg."'); ";
	}

	function showErrorJs(){
		if (!$this->_errorJs and $this->_error) {
			echo " alert('".$this->_error."'); ";
		}
		echo $this->_errorJs;
	}
	 
	function _setSchema( $array=null ) {

		if (is_array( $array )) {
			$this->_schema = $array;
		} else {
			$tableFields = $this->_db->getTableFields(array($this->_tbl));
			if(isset($tableFields[$this->_tbl])){
				$this->_schema = $tableFields[$this->_tbl];
			}
		}
	}

	function _getSchema() {
		if ($this->_schema == null) {
			$this->_setSchema();
		}

		return WFunction::array_walk_key($this->_schema,"strtolower");
	}

	function _getFieldType( $name ) {
		$schema = $this->_getSchema();

		if (isset( $schema[$name] )) {
			$result = $schema[$name]->type;
		} else {
			$result = 'text';
		}
		return $result;
	}

	function join($tipo, $classe, $vetOn = false, $vinculo = false, $tblAlias = false){
		$obj = new $classe();
		if (!$obj->_tbl_alias) {
			$obj->_tbl_alias = $this->removePrefix($obj->_tbl);
		}

		if (!($vetOn)) {
			$on1 = $on2 = $obj->_tbl_key;
			$vetOn = array($on1, $on2);
		}

		if (!is_array($vetOn)) {
			$vetOn = array($vetOn, $vetOn);
		}

		if($vinculo){
			$vetOn[] = $vinculo;
		}
		else{
			$vetOn[] = $this->_tbl_alias;
		}

		$this->_vt_join[] = array("tipo" => $tipo, "object" => $obj, "veton" => $vetOn);

		if ($tblAlias) {
			$obj->_tbl_alias = $tblAlias;
		}
		//$tblAlias : $obj->_tbl_alias.(count($this->_vt_join)+2);
		return $obj->_tbl_alias;
	}

	function joinSql() {

		if (!(($this->_vt_join)and(is_array($this->_vt_join)))) {
			return "";
		}

		$vj = $this->_vt_join;
		$str = "";
		foreach ($vj as $join) {
			$obj = $join["object"];
			$vetOn = $join["veton"];
			$str .= " \n ".$join["tipo"] . " join ".$obj->_tbl." ".$obj->_tbl_alias." on ".$vetOn[2].".".$vetOn[0]." = ".$obj->_tbl_alias.".".$vetOn[1];
		}
		return $str;
	}

	function joinSqlCampos() {
		if (!(($this->_vt_join)and(is_array($this->_vt_join)))) {
			return "";
		}
		$vj = $this->_vt_join;
		$vj[] = array("tipo"=>"root","object"=>$this);
		$str = "";
		foreach ($vj as $join) {
			$obj = $join["object"];
			$vetCampos = $obj->getPublicProperties();
			foreach ($vetCampos as $campo) {
				$str[] = $obj->_tbl_alias.".".$campo." as ".($join["tipo"] == "root"?"root":$obj->_tbl_alias)."___".$campo." \n";
			}
		}
		return ($str?implode(",",$str):"");
	}

	function joinTrataCampos($assoclist) {
		if (!(($assoclist)and(is_array($assoclist)))) {
			return $assoclist;
		}

		$return = array();

		foreach ($assoclist as $i => $assoc) {

			foreach ($assoc as $campo => $valor) {

				$tblb = substr($campo,0,strpos($campo,"___"));
				$tbla = (($tblb == "root") ? substr($tblb,0,(strlen($tblb)-1)) : $tblb);
				$tblc = substr($tbla,0,strlen($tbla)/*-1*/);

				$campo = substr($campo,strpos($campo,"___")+3);

				if (($tblb == "root")) {
					$return[$i]->$campo = $valor;
				} else {
					$return[$i]->$tblc->$campo = $valor;
				}
			}
		}
		return $return;
	}

	function store ($updateNulls=false, $ordemTipo=false) {
		$k = $this->_tbl_key;
		if ($this->$k) {
			$ret = $this->_db->updateObject( $this->_tbl, $this, $this->_tbl_key, $updateNulls );
		} else {
			$ret = $this->_db->insertObject( $this->_tbl, $this, $this->_tbl_key );
			if ($ret and property_exists($this,'ordering')) {

				if(!$ordemTipo) $ordemTipo = $this->_ordemTipo;
				$ret = $this->insertOrdering($ordemTipo);
			}
		}
		if( !$ret ) {
			$this->_error = strtolower(get_class( $this ))."::store failed <br />" . $this->_db->getErrorMsg();
			return false;
		} else {
			return true;
		}

	}

	function insertOrdering($inserirOrdem = "") {
		$where2 = $where1 = "";
		if($this->_wordem){
			$where1 = "WHERE ".WModel::getSQLWordem($this->_wordem, $this);
		}
		$cp_pk = $this->_tbl_key;
		$where2 = "WHERE $cp_pk=".$this->$cp_pk;
		if (trim(strtoupper($inserirOrdem))=="LAST") {
			$this->_db->setQuery("SELECT max(ordering) as ordem FROM ".$this->_tbl." $where1");
			$ultimo = $this->_db->loadResult("ordem")+1;
				
			$this->_db->setQuery("UPDATE ".$this->_tbl." SET ordering = $ultimo $where2");
			$this->_db->query();
		} else {
			$this->_db->setQuery("UPDATE ".$this->_tbl." SET ordering = 0 $where2");
			$this->_db->query();
				
			$this->_db->setQuery("UPDATE ".$this->_tbl." SET ordering = ordering + 1 $where1");
			$this->_db->query();
		}
		return true;
	}

	function truncate($tenho_certeza_que_quero_apagar_toda_a_tabela=false) {
		if ($tenho_certeza_que_quero_apagar_toda_a_tabela) {
			$this->_db->setQuery("DELETE FROM ".$this->_tbl);
			return $this->_db->query();
		}
	}

	function deleteWhere($where) {
		$this->_db->setQuery("DELETE FROM ".$this->_tbl." ".$where);
		return $this->_db->query();
	}

	function deleteMass($array) {
		$this->_db->setQuery("DELETE FROM ".$this->_tbl." WHERE ".$this->_tbl_key." IN (".implode(',', $array).")");
		return $this->_db->query();
	}

	function deleteMassBy($array, $campo) {
		$this->_db->setQuery("DELETE FROM ".$this->_tbl." WHERE ".$campo." IN (".implode(',', $array).")");
		return $this->_db->query();
	}

	function publicaMass($array, $status) {
		$this->_db->setQuery("UPDATE ".$this->_tbl." SET publicado = $status WHERE ".$this->_tbl_key." IN (".implode(',', $array).")");
		return $this->_db->query();
	}

	function flagMass($array, $status, $campo) {
		$this->_db->setQuery("UPDATE ".$this->_tbl." SET $campo = $status WHERE ".$this->_tbl_key." IN (".implode(',', $array).")");
		return $this->_db->query();
	}

	function selectAssoc($sqlExtraWhere = "", $sqlExtraOrdem = "") {
		$assoc = array();
		$campo = $this->_tbl_default_descricao;
		$key = $this->_tbl_key;
		$vet = $this->select($sqlExtraWhere, $sqlExtraOrdem);
		if (count($vet)) {
			foreach ($vet as $i => $obj) {
				$value = $obj->$key;
				$label = $obj->$campo;
				$assoc[$value] = $label;
			}
		}
		return $assoc;
	}

	function selectCount($where="") {
		if (is_array($this->_vt_join)) {
			$this->_db->setQuery("SELECT count(*) as tam FROM (".$this->selectJoinSQL($where,false).") alias");
		} else {
			$this->_db->setQuery("SELECT count(".$this->_tbl_key.") as tam FROM ".$this->_tbl." ".$this->_tbl_alias." ".$where);
		}
		return $this->_db->loadResult();
	}

	function selectCountJoin($where="") {
		return $this->selectCount($where);
		//return $this->_db->loadResult();
	}

	function selectJoinSQL($where="", $ordem = ""){
		$joins  = $this->joinSql();
		$campos = $this->joinSqlCampos();
		if (($ordem == "")&&($ordem!==false)) {
			$ordem = "\n ORDER BY ".$this->_tbl_alias . "." . $this->_tbl_default_ordem;
		}

		return "SELECT ".$campos." FROM ".$this->_tbl." ".$this->_tbl_alias." $joins $where $ordem";
	}

	function selectPaginacao($limit, $offset="", $join=false) {
		$this->_db->setQuery($this->_db->_sql, $limit, $offset);
		$rows = $this->_db->loadObjectList();

		if ($join) {
			return $this->joinTrataCampos($rows);
		} else {
			return $rows;
		}
	}

	function selectJoin($where="", $ordem = "", $limit=0, $offset=0) {
		return $this->select($where, $ordem, $limit, $offset);
	}

	function select($where="", $ordem = "", $limit=0, $offset=0) {
		if (is_array($this->_vt_join)) {
			$this->_db->setQuery($this->selectJoinSQL($where, $ordem), $limit, $offset);
			$rows = $this->_db->loadAssocList();
			return $this->joinTrataCampos($rows);
		} else {
			if ($ordem=="") {
				$ordem = "ORDER BY " . $this->_tbl_default_ordem;
			}
			$this->_db->setQuery("SELECT * FROM ".$this->_tbl." ".$this->_tbl_alias." $where $ordem", $limit, $offset);			
			return $this->_db->loadObjectList();
		}
	}

	function criaCombo($name, $valueSelected, $arrayExtraCombo = "", $arrayExtraOption = "", $sqlExtraWhere = "", $sqlOrdem = "", $primeiraOpcao="Selecione") {

		$campo = $this->_tbl_default_descricao;
		$key = $this->_tbl_key;

		$vet = $this->selectAll($sqlExtraWhere, $sqlOrdem);
		$mhtml = "<select name='$name' ".(is_array($arrayExtraCombo) ? implode(" ",$arrayExtraCombo) : "").">";
		$mhtml .= "<option value=''>$primeiraOpcao</option>";
		foreach ($vet as $i => $obj) {
			$value = $obj->$key;
			$label = $obj->$campo;
			$mhtml .= "<option value='$value' ".($valueSelected == $value ? "selected" : "")." ".(is_array($arrayExtraOption)? implode(" ",$arrayExtraOption) : "").">$label</option>";
		}

		$mhtml .= "</select>";

		return $mhtml;
	}

	function update($campo, $valor, $where="") {
		$this->_db->setQuery("UPDATE ".$this->_tbl." SET $campo = '$valor' $where ");
		return $this->_db->query();
	}

	function selectIn($array, $where = "") {
		$this->_db->setQuery("SELECT * FROM ".$this->_tbl." ".$this->_tbl_alias." WHERE $where ".$this->_tbl_key." IN (".implode(',', $array).")");
		return $this->_db->loadObjectList();
	}

	function selectBy($campo, $valor, $where = "") {
		$this->_db->setQuery("SELECT * FROM ".$this->_tbl." ".$this->_tbl_alias." WHERE $where ".$campo." = '".$valor."' ORDER BY ".$this->_tbl_default_ordem."");
		return $this->_db->loadObjectList();
	}

	function selectInBy($array, $campo, $where = "") {
		$this->_db->setQuery("SELECT * FROM ".$this->_tbl." ".$this->_tbl_alias." WHERE $where ".$campo." IN (".implode(',', $array).")");
		return $this->_db->loadObjectList();
	}

	function loadBy($campo, $valor, $aWhere="") {
		$this->_db->setQuery("select ".$this->_tbl_key." as id from ".$this->_tbl." where ".$campo." = '$valor'".$aWhere,1);
		$this->load($this->_db->loadResult("id"));
	}

	function loadWhere($where="") {
		$this->_db->setQuery("select ".$this->_tbl_key." as id from ".$this->_tbl." ".$this->_tbl_alias." $where order by ".$this->_tbl_default_ordem,1);
		$this->load($this->_db->loadResult("id"));
	}

	function toArray() {
		$retorno = array();
		$vetCampos = $this->getPublicProperties();
		foreach ($vetCampos as $campo) {
			$retorno[$campo] = $this->$campo;
		}
		return $retorno;
	}

	function bind($array, $ignore='') {
		if ((isset($array['checks'])) and (is_array($array['checks']))) {
			foreach ($array['checks'] as $checkFlag) {
				if (!isset($array[$checkFlag])) {
					$array[$checkFlag] = 0;
				}
			}
		}
		if (!is_array( $array )) {
			$this->_error = strtolower(get_class( $this ))."::bind failed.";
			return false;
		} else {
			return mosBindArrayToObject( $array, $this, $ignore );
		}
	}

	// daqui para baixo m�todos da falecida mosDbTable
	function getPublicProperties() {
		static $cache = null;
		if (is_null( $cache )) {
			$cache = array();
			foreach (get_class_vars( get_class( $this ) ) as $key=>$val) {
				if (substr( $key, 0, 1 ) != '_') {
					$cache[] = $key;
				}
			}
		}
		return $cache;
	}

	function getError() {
		return $this->_error;
	}

	function get( $_property ) {
		if(isset( $this->$_property )) {
			return $this->$_property;
		} else {
			return null;
		}
	}

	function set( $_property, $_value ) {
		$this->$_property = $_value;
	}

	function reset( $value=null ) {
		$keys = $this->getPublicProperties();
		foreach ($keys as $k) {
			$this->$k = $value;
		}
	}

	function load( $oid=null ) {
		$k = $this->_tbl_key;

		if ($oid !== null) {
			$this->$k = $oid;
		}

		$oid = $this->$k;

		if ($oid === null) {
			return false;
		}
		$class_vars = get_class_vars(get_class($this));
		foreach ($class_vars as $name => $value) {
			if (($name != $k) and ($name[0] != "_")) {
				$this->$name = $value;
			}
		}

		$this->reset();

		$query = "SELECT * FROM $this->_tbl WHERE $this->_tbl_key = '$oid'";
		$this->_db->setQuery( $query );
		$this->_db->loadObject($this);
		return $this;
	}

	function check() {
		return true;
	}

	function move( $dirn, $where='' ) {
		$k = $this->_tbl_key;

		$sql = "SELECT $this->_tbl_key, ordering FROM $this->_tbl";

		if ($dirn < 0) {
			$sql .= "\n WHERE ordering < $this->ordering";
			$sql .= ($where ? "\n	AND $where" : '');
			$sql .= "\n ORDER BY ordering DESC";
		} else if ($dirn > 0) {
			$sql .= "\n WHERE ordering > $this->ordering";
			$sql .= ($where ? "\n	AND $where" : '');
			$sql .= "\n ORDER BY ordering";
		} else {
			$sql .= "\nWHERE ordering = $this->ordering";
			$sql .= ($where ? "\n AND $where" : '');
			$sql .= "\n ORDER BY ordering";
		}

		$this->_db->setQuery( $sql,1 );

		$row = null;
		if ($this->_db->loadObject( $row )) {
			$query = "UPDATE $this->_tbl"
			. "\n SET ordering = '$row->ordering'"
			. "\n WHERE $this->_tbl_key = '". $this->$k ."'"
			;
			$this->_db->setQuery( $query );

			if (!$this->_db->query()) {
				$err = $this->_db->getErrorMsg();
				die( $err );
			}
			$query = "UPDATE $this->_tbl"
			. "\n SET ordering = '$this->ordering'"
			. "\n WHERE $this->_tbl_key = '". $row->$k. "'"
			;
			$this->_db->setQuery( $query );
			if (!$this->_db->query()) {
				$err = $this->_db->getErrorMsg();
				die( $err );
			}

			$this->ordering = $row->ordering;
		} else {
			$query = "UPDATE $this->_tbl"
			. "\n SET ordering = '$this->ordering'"
			. "\n WHERE $this->_tbl_key = '". $this->$k ."'"
			;
			$this->_db->setQuery( $query );

			if (!$this->_db->query()) {
				$err = $this->_db->getErrorMsg();
				die( $err );
			}
		}
	}

	function updateOrder( $where='' ) {
		$k = $this->_tbl_key;

		if (!array_key_exists( 'ordering', get_class_vars( strtolower(get_class( $this )) ) )) {
			$this->_error = "WARNING: ".strtolower(get_class( $this ))." does not support ordering.";
			return false;
		}

		$query = "SELECT $this->_tbl_key, ordering"
		. "\n FROM $this->_tbl"
		. ( $where ? "\n WHERE $where" : '' )
		. "\n ORDER BY ordering "
		;
		$this->_db->setQuery( $query );
		if (!($orders = $this->_db->loadObjectList())) {
			$this->_error = $this->_db->getErrorMsg();
			return false;
		}
		// first pass, compact the ordering numbers
		for ($i=0, $n=count( $orders ); $i < $n; $i++) {
			if ($orders[$i]->ordering >= 0) {
				$orders[$i]->ordering = $i+1;
			}
		}

		$shift = 0;
		$n=count( $orders );
		for ($i=0; $i < $n; $i++) {
			if ($orders[$i]->$k == $this->$k) {
				$orders[$i]->ordering = min( $this->ordering, $n );
				$shift = 1;
			} else if ($orders[$i]->ordering >= $this->ordering && $this->ordering > 0) {
				$orders[$i]->ordering++;
			}
		}

		for ($i=0, $n=count( $orders ); $i < $n; $i++) {
			if ($orders[$i]->ordering >= 0) {
				$orders[$i]->ordering = $i+1;
				$query = "UPDATE $this->_tbl"
				. "\n SET ordering = '". $orders[$i]->ordering ."'"
				. "\n WHERE $k = '". $orders[$i]->$k ."'"
				;
				$this->_db->setQuery( $query);
				$this->_db->query();
			}
		}

		if ($shift == 0) {
			$order = $n+1;
			$query = "UPDATE $this->_tbl"
			. "\n SET ordering = '$order'"
			. "\n WHERE $k = '". $this->$k ."'"
			;
			$this->_db->setQuery( $query );
			$this->_db->query();
		}
		return true;
	}

	function delete( $oid=null ) {
		$k = $this->_tbl_key;
		if ($oid) {
			$this->$k = intval( $oid );
		}

		$query = "DELETE FROM $this->_tbl"
		. "\n WHERE $this->_tbl_key = '". $this->$k ."'"
		;
		$this->_db->setQuery( $query );

		if ($this->_db->query()) {
			return true;
		} else {
			$this->_error = $this->_db->getErrorMsg();
			return false;
		}
	}

	static function andWhere(&$where, $condicao){
		if($condicao){
			$where .=  ($where ? " AND " : " WHERE ").$condicao;
		}
		return $where;
	}

	static function getSQLWordem($wordem, &$obj, $where=""){
		if(is_array($wordem)){
			foreach ($wordem as $wo){
				$where = WModel::getSQLWordem($wo, $obj, $where);
			}
		}
		else {
			$cp_ordem = $wordem;
			if(!$obj->$cp_ordem){
				$cond = "($cp_ordem='".$obj->$cp_ordem."' or $cp_ordem is null)";
			}
			else{
				$cond = "($cp_ordem='".$obj->$cp_ordem."')";
			}
			$where.=(($where)?" AND ":"").$cond;
		}
		return $where;
	}

	function tableName() {
		return $this->removePrefix($this->_tbl);
	}
	 
	function removePrefix($tabela) {
		return str_replace(array_keys(WConfig::$dbPrefix), "", $tabela);
	}
}

?>