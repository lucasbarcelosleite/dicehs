<?php

// Set flag that this is a parent file
define ('_VALID_MOS', 1);

$_REQUEST = array_merge($_GET, $_POST);

require_once "configuration.php";

if (IN_PRODUCTION) {
	if ($_SERVER["HTTP_HOST"] == "www.hmoveis.com.br") {
		exit("Em Breve");
	}
}

session_name(md5(LIVE));
session_start();

require_once "globals.php";
require_once WAPI;

$database = $db = new WDatabase();

if ($db->getErrorMsg()) {
	echo "Erro na conexão com o Banco de Dados";
	exit();
}

if (WConfig::$offline and !(in_array($_SERVER["REMOTE_ADDR"], WConfig::$offlineIPRestrito))) {
	echo "Aplicação fora do ar";
	exit();
}

require WPath::inc("autoload.php");

if (pega("notpl") and !count($_FILES) and WConfig::$encodeRequest){
	WFunction::arrayWalk($_REQUEST,WConfig::$encodeRequest);
	WFunction::arrayWalk($_POST,WConfig::$encodeRequest);
	WFunction::arrayWalk($_GET,WConfig::$encodeRequest);
}

if (isset($_POST["upload_flash"])) {
	$_FILES = $_POST["files"];
}

WSEOUrl::init();
WMain::init();
WSEOHead::init();
WPath::init();
WJS::init();

$component = WMain::getComponent();
$path = WPath::component($component);

ob_start();
if ($path) {
	require_once( $path );
} else {
	echo "Componente '".$component."' em '".WPath::component($component)."' n?o encontrado";
	exit;
}
$_MOS_OPTION['buffer'] = ob_get_contents();
ob_end_clean();

function codifica_utf8_encode($data){
	return utf8_encode($data);
}
function codifica_utf8_decode($data){
	return utf8_decode($data);
}
if(WConfig::$packedHtml){
	ob_start('compress');
}
if(pega("notpl") and WConfig::$encodeResponse){
	ob_start("codifica_".WConfig::$encodeResponse);
}
function compress($buffer){
	$buffer=preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!','',$buffer);
	$buffer=explode("<body>",$buffer);
	$buffer=$buffer[0]."<body>".preg_replace('/\<!--(?!-)[\x00-\xff]*?\-->/','',$buffer[1]);
	$buffer=str_replace(array("\r\n","\r","\n","\t"),'',$buffer);
	$buffer=str_replace('  ',' ',$buffer);
	$buffer=str_replace('  ',' ',$buffer);
	$buffer=str_replace('> <','><',$buffer);
	return $buffer;
}

header( 'Expires: Mon, 26 Jul 1997 05:00:00 GMT' );
header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' );
header( 'Cache-Control: no-store, no-cache, must-revalidate' );
header( 'Cache-Control: post-check=0, pre-check=0', false );
header( 'Pragma: no-cache' );

if (pega("notpl")) {
	echo $_MOS_OPTION['buffer'];
} else {
	require WPath::tplStruct(WMain::getTemplate());
}

?>