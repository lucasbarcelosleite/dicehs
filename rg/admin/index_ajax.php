<?php

if (isset($_REQUEST["is_grid"])) {
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
	header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" );
	header("Cache-Control: no-cache, must-revalidate" );
	header("Pragma: no-cache" );
	header("Content-type: text/xml");
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
}

function registraLog($descricao, $erro, $arquivo, $linha){
	return;
	$filename = "../arquivos/log/".date("Y-m-d").".csv";
	if(file_exists($filename)){
		$str = file_get_contents($filename)."\n";
	}
	else{
		$str = "Hora;Erro;Cliente;Servidor;URL GET;Arquivo;Linha;Descri��o\n";
	}
	$str .= date("H:m:s").";".($erro?1:0).";".$_SERVER["REMOTE_ADDR"].";".$_SERVER["SERVER_ADDR"].";".$_SERVER["QUERY_STRING"].";".$arquivo.";".$linha.";".$descricao;
	file_put_contents($filename, $str);
}

$adminAjax = true;
$index = "_ajax";
ob_start("trataEcho");
function trataEcho($content) {
	if((eregi("Fatal error",$content))||(eregi("Warning",$content))||(eregi("Catchable fatal error",$content))){
		if(isset($_REQUEST["is_grid"])){
			if(($p = strpos($content,"<?xml"))!==false){
				fb(strip_tags(substr($content,0,$p)),FirePHP::ERROR);
				return substr($content,$p);
			} else {
				fb(strip_tags($content),FirePHP::ERROR);
			}
		} else{
			return ajaxEchoReturn($content);
		}
	}
	else {
		return $content;
	}
}

require "index.php";

?>