<?php

define( '_VALID_MOS', 1 );

$_REQUEST = array_merge($_GET,$_POST);

require_once "../configuration.php";

session_name(md5(LIVE_ADMIN));
session_start();

require_once "../globals.php";
require_once WAPI;

$database = $db = new WDatabase();

require_once WPath::inc("autoload.php");
require_once WPath::inc("admin.php");

if(($adminAjax)&&(!count($_FILES))){
	if((WConfig::$encodeRequest)){
		WFunction::arrayWalk($_REQUEST,WConfig::$encodeRequest);
		WFunction::arrayWalk($_POST,WConfig::$encodeRequest);
		WFunction::arrayWalk($_GET,WConfig::$encodeRequest);
	}
	if((WConfig::$encodeResponse)&&(!(isset($_REQUEST["is_grid"])))){
		function codifica_utf8_encode($data){
			return utf8_encode($data);
		}
		function codifica_utf8_decode($data){
			return utf8_decode($data);
		}
		ob_start("codifica_".WConfig::$encodeResponse);
	}
}
if(isset($_POST["upload_flash"])) $_FILES = $_POST["files"];

$cur_template = "_admin";

WMain::init();
WJs::init();

$aux_index = persiste("tpl", "main");
if (!$index) {
	$index = $aux_index;
	if (!$index) {
		$index = persiste("tpl", "main", "_admin");
	}
}

$msg_login = "";
switch ($task){
	case "login":
		WMain::$usuario->bind($_POST);
		if(!WMain::$usuario->login()){
			$msg_login = "Usuário ou Senha inválidos";
		}
		break;
	case "logout":
		if(WMain::$usuario->isLogado()){
			WMain::$usuario->loadLogado();
		}
		WMain::$usuario->logout();
		break;
}


if(WMain::$usuario->isLogado()){
	WMain::$usuario->loadLogado();
	WMain::$usuario->monitoraAcesso(true);
}

if (WMain::$usuario->isLogado()) {
	if (WMain::$usuario->permissao()) {
		if ($path = WPath::component(WMain::$option,true)) {
			if ($index == "_ajax") {
				require_once $path;
				exit;
			} else {
				ob_start();
				require_once $path;
				$_MOS_OPTION['buffer'] = ob_get_contents();
				ob_end_clean();
			}
		} else {
			echo "<h3>Componente '".WMain::$option."' em '".WPath::component(WMain::$option,true)."' nï¿½o encontrado</h3>";
			exit;
		}
	} else {
		WMain::$usuario->acessoRestrito();
		exit;
	}
} else {
	if ($index=="_admin") {
		$index = "_login";
	} else {
		echo " document.location.href='index.php'; ";
	}
}

require WPath::tplStruct($index);

?>