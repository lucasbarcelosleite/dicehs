<?php

class WJs {

	public static $pathJs    = null;
	public static $pathJsLib = null;
	public static $pathJsApp = null;

	static function init() {
		if (WMain::$isAdmin) {
			$path = ROOT_ADMIN;
		} else {
			$path = ROOT;
		}

		WJs::$pathJs     = $path . WPath::$pathJs;
		WJs::$pathJsLib  = $path . WPath::$pathJsLib;
		WJs::$pathJsApp  = $path . WPath::$pathJsApp;
	}

	static function lib() {
		if (file_exists(WJs::$pathJsLib)) {
			$vArq = scandir(WJs::$pathJsLib);
			foreach ($vArq as $arq) {
				if (($arq[0] == ".")or($arq == "..")) continue;
				$vJs[] = WJs::$pathJsLib.$arq;
			}
		}

		sort($vJs);
		return $vJs;
	}

	static function inc() {
		$arqFunctions = WMain::$isAdmin ? "functions.admin.js" : "functions.js";
		$vJs[] = WJs::$pathJs . $arqFunctions;

		if (file_exists($arq = WJs::$pathJsApp.WMain::$option.".js") or file_exists($arq = WJs::$pathJsApp.WMain::$option.".js")) {
			$vJs[] = $arq;
		}

		if (WMain::$task and (file_exists($arq = WJs::$pathJsApp.WMain::$option.".".WMain::$task.".js") or file_exists($arq = WJs::$pathJsApp.WMain::$option.".".WMain::$task.".js"))) {
			$vJs[] = $arq;
		}

		if (WMain::$act and (file_exists($arq = WJs::$pathJsApp.WMain::$option.".".WMain::$act.".js") or file_exists($arq = WJs::$pathJsApp.WMain::$option.".".WMain::$act.".js"))) {
			$vJs[] = $arq;
		}

		return WJs::html($vJs);
	}

	static function html($js="") {
		if (!$js) {
			$js = WPath::js();
		}
		if (!is_array($js)) {
			$js = array($js);
		}

		if (count($js)) {
			foreach ($js as $arq) {
				$arq = str_replace(array(ROOT, LIVE), "", $arq);
				$vArq[] = $arq;
			}
			 
			$html = WJs::montaScript($vArq);
		}

		return $html;
	}

	static function montaScript($vArq) {
		$maxMod = 0;
		foreach ($vArq as $arq) {
			if ($maxMod < ($mod = filemtime(ROOT.$arq))) {
				$maxMod = $mod;
			}
		}
	  
		if (WMain::$isAdmin) {
			$link = LIVE_ADMIN."index_ajax.php?option=ajax&task=inc_js";
		} else {
			$link = LIVE."index.php?option=js&notpl=1";
		}
	  
		return '<script type="text/javascript" src="'.htmlentities($link."&arq[]=".(implode("&arq[]=", $vArq)).'&'.md5($maxMod)).'"></script>'."\n";
	}

	static function show($vApp=false) {
		$jsLib = "";
		$vJs = WJs::lib();
		if ($vApp) {
			$vJs = array_merge($vJs, $vApp);
		}

		foreach ($vJs as $arq) {
			$js .= "/* Arquivo: ".basename($arq)." */ \n\n";
			$js .= file_get_contents(strpos($arq, ROOT)!==false ? $arq : ROOT . $arq)."\n\n";
		}

		$tplMarks = array_merge(WConfig::tplMarks(), WFunction::objectToArray(WLang::$txt_obj));
		foreach ($tplMarks as $mark => $value) {
			$js = str_replace("{".$mark."}", $value, $js);
		}

		echo $js;
	}
}

?>