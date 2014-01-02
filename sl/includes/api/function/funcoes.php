<?php

//--------------------------------------------------
// LINK MENU

function WLink($url, $converterEntidades = true) {
	if (!(WValidate::linkExterno($url))) {
		if ((strpos($url,"www.") === 0)or(strpos($url,"www.") !== false)) {
			$url = "http://".$url;
		} else {
			$url = LIVE . $url;
		}
	}
	return ($converterEntidades ? htmlentities($url) : $url);
}

function WLinkId($id_menu) {
	$menu = new Menu();
	$menu->load($id_menu);
	if ($menu->link) {
		return WLink($menu->link . "&Itemid=" . $menu->id_menu);
	} else {
		return false;
	}
}

function WLinkMenu($objMenu) {
	return WValidate::linkExterno($objMenu->link) ? $objMenu->link : WLink("index.php?".$objMenu->link."&Itemid=".$objMenu->id_menu);
}

//--------------------------------------------------
// DEPURA��O

function fbug_s($var, $descricao = ""){
	if(!$descricao) $descricao = uniqid("DEBUG - ");
	fb($var,$descricao,FirePHP::DUMP);
}

function fbugExit($var, $descricao = ""){
	fbug($var, $descricao);
	exit();
}

function fbug($var){
	fb(print_r($var,true));
}

function ajaxEcho($str){
	echo ajaxEchoReturn($str);
}

$echo_global = "";
function ajaxEchoReturn($str){
	global $echo_global;
	$str = str_replace("'",'"',$str);
	$str = str_replace(array("\n","\r"),"'+".'"\n"'."+'",$str);
	$echo_global .= $str;
	return " $('#resultArea').html('$echo_global'); ";
}

function debugRet($variavel){
	$conteudo = print_r($variavel,true);
	return '<fieldset style="color: red ; border: red 2px solid; background: #EAE6E9; font-size:12px; text-align:left;">
              <div class="debug_main">
         	     <div class="debug_plain"><pre>'.$conteudo.'</pre></div>
         	  </div>
           </fieldset>          
           ';
}

function debug($variavel, $descricao = "", $cor="red", $fundo="#EAE6E9"){
	if(isset($GLOBALS["adminAjax"])){
		if(isset($_REQUEST["is_grid"])){
			fbug($variavel);
		}
		else{
			ajaxEcho(debugRet($variavel, $descricao, $cor, $fundo));
		}
	}
	else
	echo(debugRet($variavel, $descricao, $cor, $fundo));
}

function debugExit($variavel, $descricao = "", $cor="orange", $fundo="#EAE6E9"){
	debug($variavel,"EXIT ".$descricao,$cor,$fundo);
	exit;
}

function fbugSQL()
{  global $db;
fbug($db->getQuery());
}

function debugSQL($descricao = "", $cor="blue", $fundo="#F1F1F1")
{
	global $db;
	debug($db->getQuery(),"SQL ".$descricao, $cor,$fundo);
}

function debugSQLList($cor="black", $fundo="#F1F1F1")
{
	global $db;
	debug($db->_sql_list,"SQL LIST ", $cor,$fundo);
}

function debug2() {
	$cores = array("red","green","blue","orange","pink","purple","teal","silver","gray");
	$vars = func_get_args();
	foreach ($vars as $i => $var) {
		$cor = $cores[$i];
		echo "<fieldset style='color: $cor; border: $cor 3px solid; background: $fundo; font-family: Verdana; font-size:12px; text-align:left;'>";
		echo "<legend><b><font color='$cor'>DEBUG VAR ".$i."</font></b></legend>";
		echo "<pre>";
		echo htmlentities(print_r($var,true));
		echo "</pre>";
		echo "</fieldset>";
	}
}

function mostraErro($mensagem) {
	echo "<script> alert('$mensagem'); history.go(-1); </script>\n"; exit;
}

function dump($var,$cor="green") {
	echo "<fieldset style='color: $cor; border: $cor 2px solid; background: #EAE6E9; font-family: Verdana; font-size:12px; text-align:left;'>";
	echo "<legend><b><font color='$cor'>DUMP</font></b></legend>";
	echo "<pre>";
	ob_start();
	var_dump($var);
	$dump = ob_get_contents();
	ob_end_clean();
	echo str_replace("=>\n "," =>",htmlentities($dump));
	echo "</pre>";
	echo "</fieldset>";
}

//--------------------------------------------------
// PERSIST�NCIA DE VARI�VEIS

function persiste($var, $tela = "", $valor = "") {
	//if($valor){
	if($valor!==""){
		manipulaVar($var,$valor);
	}
	manipulaVarSession($var, $tela);
	return $_REQUEST[$var];
}

function manipulaVarSession($var,$tela = ""){
	 
	if ($tela == "") $tela = pega("option");
	 
	if (isset($_REQUEST[$var])) {
		return $GLOBALS[$var] = $_SESSION[$tela."_vars"][$var] = $_REQUEST[$var];
	} elseif (isset($_SESSION[$tela."_vars"][$var])) {
		return $GLOBALS[$var] = $_POST[$var] = $_GET[$var] = $_REQUEST[$var] = $_SESSION[$tela."_vars"][$var];
	}
}

function manipulaVar($var, $valor){
	return $GLOBALS[$var] = $_POST[$var] = $_GET[$var] = $_REQUEST[$var] = $valor;
}

//--------------------------------------------------
// DIVERSAS

function pega($var, $default = "") {
	return mosGetParam($_REQUEST,$var,$default);
}

function chamaFuncao($funcao,$parametros=array()) {
	$vParams = array();
	foreach ($parametros as $m => $param) {
		$vParams[] = '$parametros['.$m.']';
	}
	$valor = "";
	eval('$valor = '.$funcao."(".implode(",",$vParams).");");
	return $valor;
}


//--------------------------------------------------
// CRIPTOGRAFIA E MANIPULA��O DE BITS

function strToBit($str, $separador = " ") {
	$binario = "";
	for($i=0; $i < strlen($str); $i++) {
		for($bit=7; $bit >= 0; $bit--) {
			$binario .= ((ord($str[$i]) & (1 << $bit)) != 0?1:0);
		}
		$binario .=  $separador;
	}
	return $binario;
}

// criptografia por inser��o de bits
function criptografa($str, $arrChave, $criptografa = true) {
	$strDest = "";
	$temp = $posBit = $posChave = $posBitChave = 0;
	for($i=0; $i < strlen($str) - (($criptografa)?0:1); $i++) {
		for($bit=7; $bit >= (($criptografa || $i < strlen($str)-2)?0:(8-ord($str[strlen($str)-1]))%8); $bit--) {
			$original = ((ord($str[$i]) & (1 << $bit)) != 0?1:0);
			if($criptografa) {
				$temp |= ($original << (7-$posBit%8));
				$posBit++;
				if(!($posBit%8)) {
					$strDest .= chr($temp);
					$posBit = $temp = 0;
				}
				if($arrChave[$posChave] == ++$posBitChave) {
					$posChave = ($posChave+1)%count($arrChave);
					$posBitChave = 0;
					$temp |= (mt_rand(0,1) << (7-$posBit%8));
					$posBit++;
				}
			} else {
				if(($arrChave[$posChave]+1) == ++$posBitChave) {
					$posChave = ($posChave+1)%count($arrChave);
					$posBitChave = 0;
				} else {
					$temp |= ($original << (7-$posBit%8));
					$posBit++;
				}
			}
			if($posBit && !($posBit%8)) {
				$strDest .= chr($temp);
				$posBit = $temp = 0;
			}
		}
	}
	if($posBit) $strDest .= chr($temp);
	if($criptografa) $strDest .= chr($posBit);
	return $strDest;
}

//--------------------------------------------------
// COMPATIBILIDADE

if (!function_exists('property_exists')) {
	function property_exists($class, $property) {
		if (is_object($class))
		$class = get_class($class);

		return array_key_exists($property, get_class_vars($class));
	}
}

if (!function_exists("mime_content_type")) {
	function mime_content_type($f) {
		return trim(exec("file -bi ".escapeshellarg($f)));
	}
}

?>