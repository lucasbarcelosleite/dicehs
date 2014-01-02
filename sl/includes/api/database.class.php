<?php

class WDatabase {
	/** @var string Internal variable to hold the list of query sql */
	var $_sql_list   = '';
	/** @var string Internal variable to hold the query sql */
	var $_sql			= '';
	/** @var int Internal variable to hold the database error number */
	var $_errorNum		= 0;
	/** @var string Internal variable to hold the database error message */
	var $_errorMsg		= '';
	/** @var string Internal variable to hold the prefix used on all database tables */
	var $_table_prefix	= '';
	/** @var ADODB_pdo Internal variable to hold the connector resource */
	var $_resource		= '';

	/** @var Internal variable to hold the last query cursor */
	var $_cursor		= null;
	/** @var boolean Debug option */
	var $_debug			= 0;
	/** @var int The limit for the query */
	var $_limit			= 0;
	/** @var int The for offset for the limit */
	var $_offset		= 0;

	var $_nameTable = '';

	/**
	 * Database object constructor
	 * @param string Database host
	 * @param string Database user name
	 * @param string Database user password
	 * @param string Database name
	 * @param string Common prefix for all tables
	 */
	function __construct( $host='', $user="", $pass="", $db='', $driver = "") {
		if (!$driver) $driver = WConfig::$dbDriver;
		if (!$host)   $host = WConfig::$dbHost;
		if (!$user)   $user = WConfig::$dbUser;
		if (!$pass)   $pass = WConfig::$dbPassword;
		if (!$db)     $db   = WConfig::$dbDatabase;

		$this->_resource = ADONewConnection($driver);
		if (!$this->_resource->Connect($host, $user, $pass, $db)) {
			$this->_errorNum = $this->_resource->ErrorNo();
			$this->_errorMsg = $this->_resource->ErrorMsg();
		}

		$this->_table_prefix = WConfig::$dbPrefix;

		$this->initSession();
	}

	function initSession() {
		if ($this->_resource->databaseType == "oci8") {
			$setCur = $this->_resource->Execute("ALTER SESSION SET NLS_TIMESTAMP_FORMAT = 'YYYY-MM-DD HH24:MI:SS'");
			$setCur = $this->_resource->Execute("ALTER SESSION SET NLS_DATE_FORMAT = 'YYYY-MM-DD'");
		}
	}

	function MetaType($type) {
		if ($this->_resource->databaseType == "oci8") {
			if (stripos($type,'TIMESTAMP') !== false) {
				$type = substr($type,0,strpos($type,'('));
			}
		}
		return ADORecordSet::MetaType($type);
	}
	 
	function _quoteField( $value, $type ) {
		$metaType = WDatabase::MetaType($type);
		switch ($metaType) {
			case 'C':
			case 'X':
			case 'B':
				$result = $this->Quote( $value );
				break;
			case 'D':
				if (empty( $value )) {
					$value = $this->_nullDate;
				}
				$result = $this->Quote($value);
				break;
			case 'T':
				if (empty($value)) {
					$value = $this->_nullDate;
				}
				/*if ($this->_resource->databaseType == "oci8") {
				 $result = $this->QuoteTimestampOCI($value);
				 } else {
				 */
				$result = $this->Quote($value);
				//}
				break;
			case 'I':
			case 'N':
				$result = (double) $value;
				break;

			case 'L':
			case 'R':
			default:
				$result = (int) $value;
				break;
		}
		return $result;
	}

	function getErrorNum() {
		return $this->_errorNum;
	}

	/**
	 * @return string The error message for the most recent query
	 */
	function getErrorMsg() {
		return str_replace( array( "\n", "'" ), array( '\n', "\'" ), $this->_errorMsg );
	}

	/**
	 * Pega o padrao de escape do banco
	 * @return string
	 */
	function getEscaped( $text ) {
		return $this->_resource->qstr($text);
	}

	/**
	 * Faz escape em uma string
	 * @return string
	 */
	function Quote( $text ) {
		return $this->getEscaped( $text );
	}

	function QuoteTimestampOCI ($text) {
		return "(timestamp '".$text."')";
	}

	/**
	 * Quote an identifier name (field, table, etc)
	 * @param string The name
	 * @return string The quoted name
	 */
	function NameQuote( $s ) {
		return $s;
	}

	/**
	 * @return string The database prefix
	 */
	function getPrefix() {
		return $this->_table_prefix;
	}

	/**
	 * Sets the SQL query string for later execution.
	 *
	 * This function replaces a string identifier <var>$prefix</var> with the
	 * string held is the <var>_table_prefix</var> class variable.
	 *
	 * @param string The SQL query
	 * @param string The offset to start selection
	 * @param string The number of results to return
	 * @param string The common table prefix
	 */
	function setQuery( $sql, $limit = 0, $offset = 0) {
		$this->_sql_list[] = $this->_sql = $this->replacePrefix( $sql);

		$this->_limit = intval( $limit );
		$this->_offset = intval( $offset );

	}

	function setSafeQuery ($sql, $limit = 0, $offset = 0) {
		$this->setQuery($sql, $limit, $offset, $prefix);
	}

	function replacePrefix ($sql) {

		$prefix = $this->_table_prefix;

		$sql = trim ($sql);

		if(is_array($prefix)) {
			foreach ($prefix as $coringa => $esquemaPrefixo) {
				$sql = $this->replaceUmPrefix($sql,$coringa,$esquemaPrefixo);
			}
		}
		return $sql;
	}

	function replaceUmPrefix( $sql, $prefix='#__' , $str='joomla.') {
		$sql = trim( $sql );
		$sql = str_replace("##'".$prefix, "'".$str, $sql);
		$sql = str_replace('##"'.$prefix, '"'.$str, $sql);

		$escaped = false;
		$quoteChar = '';

		$n = strlen( $sql );

		$startPos = 0;
		$literal = '';
		while ($startPos < $n) {
			$ip = strpos($sql, $prefix, $startPos);
			if ($ip === false) {
				break;
			}

			$j = strpos( $sql, "'", $startPos );
			$k = strpos( $sql, '"', $startPos );
			if (($k !== FALSE) && (($k < $j) || ($j === FALSE))) {
				$quoteChar	= '"';
				$j			= $k;
			} else {
				$quoteChar	= "'";
			}

			if ($j === false) {
				$j = $n;
			}

			$literal .= str_replace( $prefix, $str, substr( $sql, $startPos, $j - $startPos ) );
			$startPos = $j;

			$j = $startPos + 1;

			if ($j >= $n) {
				break;
			}

			// quote comes first, find end of quote
			while (TRUE) {
				$k = strpos( $sql, $quoteChar, $j );
				$escaped = false;
				if ($k === false) {
					break;
				}
				$l = $k - 1;
				while ($l >= 0 && $sql{$l} == '\\') {
					$l--;
					$escaped = !$escaped;
				}
				if ($escaped) {
					$j	= $k+1;
					continue;
				}
				break;
			}
			if ($k === FALSE) {
				// error in the query - no end quote; ignore it
				break;
			}
			$literal .= substr( $sql, $startPos, $k - $startPos + 1 );
			$startPos = $k+1;
		}
		if ($startPos < $n) {
			$literal .= substr( $sql, $startPos, $n - $startPos );
		}
		return $literal;
	}

	/**
	 * @return string The current value of the internal SQL vairable
	 */
	function getQuery() {
		return htmlspecialchars($this->replacePrefix($this->_sql));
	}

	/**
	 * Execute the query
	 * @return mixed A database resource if successful, FALSE if not.
	 */
	function query() {
		$this->_errorNum = 0;
		$this->_errorMsg = '';

		if ($this->_limit > 0 || $this->_offset > 0) {
			// � um select com limit e offset
			$this->_cursor = $this->_resource->SelectLimit($this->_sql,$this->_limit,$this->_offset);
		} else {
			$this->_cursor = $this->_resource->Execute($this->_sql);
		}

		if (!$this->_cursor) {
			$this->_errorNum = $this->_resource->ErrorNo();
			$this->_errorMsg = $this->_resource->ErrorMsg()." SQL=$this->_sql";
			return false;
		}
		return $this->_cursor;
	}

	/**
	 * @return int The number of affected rows in the previous operation
	 */
	function getAffectedRows() {
		return $this->_resource->Affected_Rows();
	}

	/**
	 * @return int The number of rows returned from the most recent query.
	 */
	function getNumRows( $cur=null ) {
		return $this->_cursor->RecordCount();
	}

	function loadObject( &$object ) {
		if ($object != null) {

			if (!($cur = $this->query())) {
				return false;
			}
			if ($array = $cur->FetchRow()) {
				mosBindArrayToObject( WFunction::array_walk_key($array,"strtolower"), $object, null, null, false );
				return true;
			} else {
				return false;
			}
		} else {
			if ($cur = $this->query()) {
				if ($object = $cur->FetchObj($cur)) {
					return true;
				} else {
					$object = null;
					return false;
				}
			} else {
				return false;
			}
		}
	}

	function loadResult() {
		if (!($cur = $this->query())) {
			return null;
		}
		$ret = null;
		if ($row = $cur->FetchObj()) {
			foreach ($row as $valor) {
				$ret = $valor;
				break;
			}
		}
		return $ret;
	}

	function loadResultList() {


		if (!($cur = $this->query())) {
			return null;
		}

		$array = array();

		while ($row = $cur->FetchRow()) {
			$row = WFunction::array_walk_key($row, "strtolower");
			$cont = count($row) / 2;
			for ($i = 0; $i < $cont; $i++) {
				unset($row[$i]);
			}
			foreach ($row as $valor) {
				$array[] = $valor;
				break;
			}
		}

		return $array;

		if (!($cur = $this->query())) {
			return null;
		}
		$ret = array();
		if ($row = $cur->FetchObj()) {
			foreach ($row as $valor) {
				$ret[] = $valor;
				break;
			}
		}
		return $ret;
	}

	/**
	 * Load a assoc list of database rows
	 * @param string The field name of a primary key
	 * @return array If <var>key</var> is empty as sequential list of returned records.
	 */
	function loadAssocList() {

		if (!($cur = $this->query())) {
			return null;
		}

		$array = array();

		while ($row = $cur->FetchRow()) {
			$row = WFunction::array_walk_key($row, "strtolower");
			$cont = count($row) / 2;
			for ($i = 0; $i < $cont; $i++) {
				unset($row[$i]);
			}
			 
			$array[] = $row;
		}

		return $array;
	}

	/**
	 * Load a list of database objects
	 * @param string The field name of a primary key
	 * @return array If <var>key</var> is empty as sequential list of returned records.
	 * If <var>key</var> is not empty then the returned array is indexed by the value
	 * the database key.  Returns <var>null</var> if the query fails.
	 */
	function loadObjectList( $key='' ) {
		if (!($cur = $this->query())) {
			return null;
		}

		$array = array();
		while ($row = $cur->FetchNextObj()) {
			$row = WFunction::obj_walk_key($row, "strtolower");
			if ($key) {
				$array[$row->$key] = $row;
			} else {
				$array[] = $row;
			}
		}
		return $array;
	}

	function getInsertRow(){
		$this->setQuery("select * from $this->_nameTable order by ".$this->getTableKeyName($this->_nameTable)." desc",1);
		return $this->loadAssocList();
	}

	function getNameTableInsert(){
		$this->_nameTable = trim(substr(strtolower($this->_sql),strpos(strtolower($this->_sql),"into")+4));
		$this->_nameTable = trim(substr($this->_nameTable,0,strpos($this->_nameTable," ")));
	}

	function insertid() {
		$this->getNameTableInsert();
		$res = $this->getInsertRow();
		$pk = $this->getTableKeyName($this->_nameTable);
		return $res[0][$pk];
	}

	function getTableKeyName($table){
		$res = $this->_resource->MetaPrimaryKeys($this->replacePrefix($table));
		return $res[0];
	}

	function insertObject( $table, &$object, $keyName = NULL) {
		$fmtsql = "INSERT INTO $table ( %s ) VALUES ( %s ) ";
		$fields = array();
		if(!$keyName) $keyName = $this->getTableKeyName($table);
		foreach (get_object_vars( $object ) as $k => $v) {
			if (is_array($v) or is_object($v) or ($v === NULL && $keyName != $k)) {
				continue;
			}
			if ($k[0] == '_') { // internal field
				continue;
			}
			$fields[] = $this->NameQuote( $k );
			if($keyName==$k) $id = $v;
			if($keyName==$k && (!isset($v) || !$v)) {
				$proxId = $id = $this->GenID($table."_".$keyName."_seq");
				$values[] = $proxId;
			}
			else {

				if( $v === '' ) {
					$val = "null";
				} else {
					$val = $this->_quoteField( $v, $object->_getFieldType( $k ) );
				}
				$values[] = $val;
			}
		}
		$this->setQuery( sprintf( $fmtsql, implode( ",", $fields ) ,  implode( ",", $values ) ) );

		if (!$this->query()) {
			return false;
		}

		if ((!isset($id)) or (!$id) or $id=="null") {
			$id = $this->insertid();
		}

		if ($keyName && $id) {
			$object->$keyName = $id;
		}
		return true;
	}

	/**
	 * Document::db_updateObject()
	 *
	 * { Description }
	 *
	 * @param string $table This is expected to be a valid (and safe!) table name
	 * @param [type] $updateNulls
	 */
	function updateObject( $table, &$object, $keyName, $updateNulls=true ) {
		$fmtsql = "UPDATE $table SET %s WHERE %s";
		$tmp = array();
		foreach (get_object_vars( $object ) as $k => $v) {
			if( is_array($v) or is_object($v) or $k[0] == '_' ) { // internal or NA field
				continue;
			}
			if ($k == $keyName) { // PK not to be updated
				$where = $k . '=' . $this->_quoteField( $v, $object->_getFieldType( $k ) );
				continue;
			}
			if ($v === NULL && !$updateNulls) {
				continue;
			}
			if( $v === '' ) {
				$val = "null";
			} else {
				$val = $this->_quoteField( $v, $object->_getFieldType( $k ) );
			}
			$tmp[] = $this->NameQuote( $k ) . '=' . $val;
		}
		$this->setQuery( sprintf( $fmtsql, implode( ",", $tmp ) , $where ) );
		return $this->query();
	}

	/**
	 * @param array A list of table names
	 * @return array An array of fields by table
	 */
	function getTableFields( $tables ) {
		$result = array();

		foreach ($tables as $k => $tblval) {
			$result[$tblval] = $this->_resource->MetaColumns($this->replacePrefix($tblval),false);
		}
		return $result;
	}

	function GenID( $nomeSequencia=null, $valorInicial=null ) {
		if ($this->_resource->databaseType == "mysql") {
			return "null";
		} else {
			$nomeSequencia = $this->replacePrefix($nomeSequencia);
			//echo "console.log('$nomeSequencia - $valorInicial');";
			//exit();
			return $this->_resource->GenId($nomeSequencia, $valorInicial);
		}
	}

	function beginTrans() {
		$this->_resource->SetTransactionMode("READ UNCOMMITTED");
		$this->_resource->BeginTrans();
	}

	function commitTrans() {
		$this->_resource->CommitTrans();
	}

	function rollbackTrans() {
		$this->_resource->RollbackTrans();
	}

}
