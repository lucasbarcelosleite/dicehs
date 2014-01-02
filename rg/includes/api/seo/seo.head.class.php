<?php
class WSEOHead {
	/**
	 * @var SeoMenu Atributo do Obj
	 * */
	static $menu;

	public static function init() {
		WSEOHead::setInformation(WMain::$Itemid);
	}

	public static function setInformation($Itemid) {
		$seoHome = new SeoMenu();
		$seoHome->loadBy("id_menu", 1);

		WSEOHead::$menu = new SeoMenu();
		WSEOHead::$menu->loadBy("id_menu", $Itemid);
		
		if(WSEOUrl::$atualPageTitle) {
			WSEOHead::$menu->page_title = WSEOUrl::$atualPageTitle;
		}else {
			if (!WSEOHead::$menu->id_seo_menu or !WSEOHead::$menu->page_title) {
				if ($Itemid > 1) {
					$menu = new Menu();
					$rows = $menu->loadParents($Itemid);
					foreach ($rows as $i => $row) {
						$vTitulo[] = $row->titulo;
					}
					$vTitulo = array_reverse($vTitulo);
				}
	
				$vTitulo[] = WConfig::$siteName;
	
				WSEOHead::$menu->page_title = implode(" - ", $vTitulo);
			} else if (WSEOHead::$menu->page_title) {
				WSEOHead::$menu->page_title .= " - ".WConfig::$siteName;
			}
		}

		if (!WSEOHead::$menu->meta_description) {
			WSEOHead::$menu->meta_description = $seoHome->meta_description;
		}

		if (!WSEOHead::$menu->meta_keywords) {
			WSEOHead::$menu->meta_keywords = $seoHome->meta_keywords;
		}
	}

	public function getPageTitle($Itemid, $vTituloSeo = null, $direcao = 1, $separador = ' - ') {
		$seoMenu = new SeoMenu();
		$seoMenu->loadBy("id_menu", $Itemid);
		if (!$seoMenu->id_seo_menu || !$seoMenu->page_title || $direcao == -1) {
			$vTitulo = array(WConfig::$siteName);
			if ($Itemid > 1) {
				$menu = new Menu();
				$rows = $menu->loadParents($Itemid);
				foreach ($rows as $i => $row) {
					$vTitulo[] = $row->titulo;
				}
				if($vTituloSeo) {
					foreach ($vTituloSeo as $row) {
						$vTitulo[] = $row;
					}
				}
				if($direcao == 1) {
					$vTitulo = array_reverse($vTitulo);
				}
			}

			return implode($separador, $vTitulo);
		} else if (WSEOHead::$menu->page_title) {
			return WSEOHead::$menu->page_title . ' - ' . WConfig::$siteName;
		}
	}

	public static function getInformation() {
		$obj = WSEOHead::$menu;
		$obj->encoding = WConfig::$siteEncoding;
		return $obj;
	}
}

?>