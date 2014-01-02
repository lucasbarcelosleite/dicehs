<?php
class WSEOUrl {
	public static $atualOld = null;
	public static $atualNew = null;
	public static $atualPageTitle = null;
	private static $vUrl = array();
	private static $vPageTitle = array();

	public static function init() {
		if (!WConfig::$seoUrl or pega("notpl")) {
			return true;
		}

		$dirProj = substr(WConfig::$live, strpos(WConfig::$live, $_SERVER["HTTP_HOST"])+strlen($_SERVER["HTTP_HOST"]));
		if ($dirProj=="/") {
			$url = substr($_SERVER["REQUEST_URI"], 1);
		} else {
			$url = str_replace($dirProj, "", $_SERVER["REQUEST_URI"]);
		}

		if (!$url) {
			$url = "index.php";
			$_REQUEST["sis_id_lang"] = 1;
		}

		if (strpos($url, ".php")===false) {

			list($url, $urlNoSEO) = explode("?",$url);

			if (substr($url, 0, 1)=="/") {
				$url = substr($url, 1);
			}
			if ($pos = strpos($url, "/")) {
				$folder = substr($url, 0, $pos);
				foreach (WConfig::$seoUrlDisabledFolders as $disabledFolder) {
					if ($disabledFolder == $folder) {
						header("Location: index.php");
						exit;
					}
				}
			}
			
			$url = rtrim($url, '/').'/';
			$old = WSEOUrl::unformat($url);

			if ($old != $url) {
				if (WValidate::linkExterno($old)) {
					header("Location: ".$old);
					exit;
				} else {
					parse_str(WSEOUrl::queryString($old), $vUrl);
					$_REQUEST = array_merge($_REQUEST, $vUrl);
					$_GET = array_merge($_GET, $vUrl);
					$_POST = array_merge($_POST, $vUrl);

					if ($urlNoSEO) {
						$old .= "&".$urlNoSEO;
					}
				}

				WSEOUrl::setAtual(($pos = strpos($old, "sis_id_lang")) ? substr($old, 0, $pos-1) : $old, $url);
			} else {
				//echo 'Página não encontrada';
			}

		} else {
			WSEOUrl::setAtual($url, WSEOUrl::format($url, 1));
		}
	}

	public static function unformat($url) {
		$seoUrl = new SeoUrl();
		$url = rtrim($url, '/');
		$seoUrl->loadWhere("WHERE TRIM(BOTH '/' FROM url_new) = '$url'");

		if ($seoUrl->id_seo_url) {
			if (WValidate::linkExterno($seoUrl->url_old)) {
				return $seoUrl->url_old;
			} else if (strpos($seoUrl->url_old, ".php") !== false) {
				self::$atualOld = $seoUrl->url_old . (strpos($seoUrl->url_old, "sis_id_lang") ? "" : ((strpos($seoUrl->url_old, "?") ? "&" : "?") ."sis_id_lang=". $seoUrl->id_lang));
				self::$atualPageTitle = $seoUrl->page_title;
				return self::$atualOld;
			} else {
				return WSEOUrl::unformat($seoUrl->url_old);
			}
		} else {
			return $url;
		}
	}

	public static function format($url, $id_lang=false, $addLive = true) {
		if (!WConfig::$seoUrl) {
			return WFormat::link($url);
		}

		if (!$url) {
			$url = "index.php";
		}

		$seoUrl = new SeoUrl();
		$seoUrl->loadWhere("WHERE url_old = '".$url."' AND is_ativa = 1");

		if ($seoUrl->url_new) {
			return ($addLive ? LIVE : '') . rtrim($seoUrl->url_new, '/').'/';

		} else {

			WSEOUrl::clear();

			parse_str(WSEOUrl::queryString($url), $vUrl);

			if ($vUrl) {
				$menu = new Menu();
				$rows = $menu->loadParents($vUrl["Itemid"], $vUrl["Itemid"] == 1);
				foreach ($rows as $row) {
					WSEOUrl::add($row->titulo);
				}

				if ($path = WPath::seo($vUrl["option"])) {
					foreach ($vUrl as $param => $value) {
						$$param = $value;
					}
					require $path;
				}

				if ($vUrl["pag"]) {
					WSEOUrl::add("pag_".$vUrl["pag"]);
				}

			} 

			$urlSef = WSEOUrl::build();

			if ($urlSef) {
				$seoUrl = new SeoUrl();
				$seoUrl->loadWhere("WHERE url_new = '".$urlSef."'");
				$seoUrl->url_old = $url;
				$seoUrl->url_new = $urlSef;
				$seoUrl->page_title = WSEOHead::getPageTitle($vUrl["Itemid"], self::$vPageTitle);
				$seoUrl->is_ativa = 1;
				$seoUrl->is_automatica = 1;
				$seoUrl->store();
			}

			return $urlSef ? ($addLive ? LIVE : '') . $urlSef : "";
		}
	}

	public static function queryString($url) {
		return preg_replace('/^.+\\?/', '', $url);
	}

	public static function setAtual($old, $new) {
		WSEOUrl::$atualOld = $old;
		WSEOUrl::$atualNew = $new;
	}

	public static function add($texto) {
		WSEOUrl::$vUrl[] = WSEOUrl::clearStr($texto);
	}
	
	public static function addPageTitle($texto) {
		WSEOUrl::$vPageTitle[] = $texto;
	}

	public static function clear() {
		WSEOUrl::$vUrl = array();
		WSEOUrl::$vPageTitle = array();
	}

	public static function build() {
		return trim(implode("/", WSEOUrl::$vUrl), "/");
	}

	public static function clearStr($text) {
		$text = WFormat::toLower(WFormat::removeAcentos(trim($text)));
		$text = str_replace(" ", "-", $text);
		return preg_replace("/[^A-Za-z0-9\\040\\.\\-\\_]/i", "", $text);
	}
	
	public static function getUrlAtual() {
		return WConfig::$seoUrl ? LIVE . self::$atualNew : WFormat::link(self::$atualOld);
	}
}

?>