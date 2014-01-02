<?

// Tipo de Retorno
define ("GET_ROOT","0");
define ("GET_LIVE","1");

class WPath {
	 
	public static $pathAdmin         = NAME_ADMIN;
	public static $pathArquivos      = "arquivos/";
	public static $pathComponents    = "/components/";
	public static $pathClasses       = "/classes/";
	public static $pathTpl           = "/templates/";
	public static $pathTplModules    = "/templates/modules/";
	public static $pathTplComponents = "/templates/components/";
	public static $pathTplShared     = "/templates/components/shared/";
	public static $pathCss           = "/templates/css/";
	public static $pathJs            = "/templates/js/";
	public static $pathJsLib         = "/templates/js/lib/";
	public static $pathJsApp         = "/templates/js/app/";
	public static $pathImages        = "/images/";
	public static $pathFlash         = "/images/media/";
	public static $pathModules       = "/modules/";
	public static $pathInc           = "/includes/";

	public function __construct() {

	}
	 
	public static function init() {
	}
	 
	// ======================================================================
	public static function root($arq) {
		return WConfig::$root."/".$arq;
	}
	 
	public static function rootAdmin($arq) {
		return WConfig::$rootAdmin."/".$arq;
	}

	public static function live($arq) {
		return WConfig::$live."/".$arq;
	}
	 
	public static function liveAdmin($arq) {
		return WConfig::$liveAdmin."/".$arq;
	}
	// ======================================================================
	 
	// ======================================================================
	public static function flash($arq) {
		$paths[] = WPath::$pathFlash . $arq;
		 
		return WPath::verifica($paths,GET_LIVE);
	}
	 
	public static function css($arq) {
		$arq .= ".css";

		$paths[] = WPath::$pathCss . $arq;
		 
		return WPath::verifica($paths, GET_LIVE);
	}
	 
	public static function img($arq) {
		$paths[] = WPath::$pathImages . $arq;
		 
		return WPath::verifica($paths,GET_LIVE);
	}

	public static function arquivo($arquivo="", $pasta="") {
		if ($pasta == "") {
			$pasta = WMain::$option;
		}
		$paths[] = WPath::$pathArquivos.$pasta."/".$arquivo;
		return SHARE_LIVE.WPath::$pathArquivos.$pasta."/".$arquivo;
	}
	 
	public static function arquivoRoot($arquivo="", $pasta="") {
		if ($pasta == "") {
			$pasta = WMain::$option;
		}
		return SHARE_ROOT.WPath::$pathArquivos.$pasta."/".$arquivo;
	}
	 
	public static function classe($arq="") {
		if ($arq == "") {
			$arq = WMain::$option;
		}

		$arq .= ".class.php";

		$paths[] = WPath::$pathClasses . $arq;

		foreach (WConfig::$dbPrefix as $prefixo => $schema) {
			$schema = str_replace(array(".","_"),"",$schema);
			$paths[] = WPath::$pathClasses . $schema . "/" . $arq;
		}

		$paths[] = WPath::$pathInc . $arq;
		 
		return WPath::verifica($paths,GET_ROOT);
	}
	 
	public static function inc($arq, $rootOrLive="") {
		$paths[] = WPath::$pathInc.$arq;;
		$paths[] = WPath::$pathInc."/lib/".$arq;
		$paths[] = WPath::$pathInc."/api/".$arq;
		$paths[] = WPath::$pathInc."/app/".$arq;

		if (!$rootOrLive) {
			$rootOrLive = GET_ROOT;
		}

		return WPath::verifica($paths, $rootOrLive);
	}
	 
	public static function modulo($arq) {
		$paths[] = WPath::$pathModules.$arq;

		return WPath::verifica($paths,GET_ROOT);
	}
	 
	public static function component($arq, $isAdmin=false) {
		if ($isAdmin) {
			$paths[] = WPath::$pathComponents.$arq."/admin.".$arq.".php";
		} else {
			$paths[] = WPath::$pathComponents.$arq."/".$arq.".php";
		}

		return WPath::verifica($paths,GET_ROOT);
	}
	 
	public static function seo($arq) {
		if ($arq == "") {
			$arq = WMain::$option;
		}
		$paths[] = WPath::$pathComponents.$arq."/".$arq.".seo.php";

		return WPath::verifica($paths,GET_ROOT);
	}
	 
	public static function js($arq) {
		$arq .= ".js";

		$paths[] = WPath::$pathJs . $arq;
		$paths[] = WPath::$pathJsLib . $arq;
		$paths[] = WPath::$pathJsApp . $arq;
		 
		$projeto = WPath::verifica($paths, GET_LIVE);

		return $projeto;
	}

	public static function tpl($tpl="", $paramOption="") {
		 
		if ($paramOption != "") {
			$opt = $paramOption;
		} else {
			$opt = WMain::$option;
		}

		if ($tpl == "") $tpl = $opt;

		$arq = $tpl . ".tpl";

		if (WMain::$modulo) {
			$paths[] = WPath::$pathTplModules . $arq;
		}

		$paths[] = WPath::$pathTplComponents . $opt ."/".$arq;
		$paths[] = WPath::$pathTplShared . $arq;
		$paths[] = WPath::$pathTpl . $tpl . "/index.tpl";

		return WPath::verifica($paths,GET_ROOT);
	}
	 
	public static function tplStruct($tpl="") {
		if ($tpl == "") $tpl = WMain::$option;

		$paths[] = WPath::$pathTpl.$tpl."/index.php";
		 
		return WPath::verifica($paths,GET_ROOT);
	}
	 
	public static function adminToolbar($arq="") {
		$arq = $arq ? $arq : WMain::$option;

		$paths[] = WPath::$pathComponents.$arq."/toolbar.".$arq.".php";
		$paths[] = WPath::$pathComponents."/_default/toolbar._default.php";

		return WPath::verifica($paths,GET_ROOT);
	}

	public static function adminForm($arq="") {
		$arq = $arq ? $arq : WMain::$option;

		$paths[] = WPath::$pathComponents.$arq."/admin.".$arq.".form.php";

		return WPath::verifica($paths,GET_ROOT);
	}
	 
	public static function adminList($arq="") {
		$arq = $arq ? $arq : WMain::$option;

		$paths[] = WPath::$pathAdmin."/".WPath::$pathComponents.$arq."/admin.".$arq.".lista.php";

		return WPath::verifica($paths,GET_ROOT);
	}
	 
	public static function adminController($arq="") {
		$arq = $arq ? $arq : WMain::$option;

		$paths[] = WPath::$pathAdmin."/".WPath::$pathComponents.$arq."/admin.".$arq.".php";

		return WPath::verifica($paths,GET_ROOT);
	}

	public static function verifica($vet, $tipoRetorno) {
		$pathReturn = false;

		if ($tipoRetorno == GET_ROOT) {
			$site = WConfig::$root;
			$admin = WConfig::$rootAdmin;
		} elseif ($tipoRetorno == GET_LIVE) {
			$site = WConfig::$live;
			$admin = WConfig::$liveAdmin;
		}

		if (is_array($vet)) {
			foreach ($vet as $path) {

				if (file_exists(WConfig::$root . $path)) {
					$pathReturn = $site . $path;
					break;
				}
				if (file_exists(WConfig::$rootAdmin . $path)) {
					$pathReturn = $admin . $path;
					break;
				}
			}
		}
		 
		return $pathReturn;
	}

	private static function verificaApi($vet) {
		if (is_array($vet)) {
			foreach ($vet as $path) {
				if (file_exists($path)) {
					return $path;
					break;
				}
			}
		}
	}
	 
	 
}

?>