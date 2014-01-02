<?php

class WProject {

	static $introducao = true;
	static $menu_interno = true;
	static $menu_interno_tipo = 0;
	/**
	 * @var Menu Atributo do Obj
	 * */
	static $menu = null;
	/**
	 * @var Menu Atributo do Obj
	 * */
	static $menuHome = null;
	/**
	 * @var WTemplate Atributo do Obj
	 * */
	static $tplTitulo = null;
	static $tplMenu = null;
	 
	static $tituloMenu = "TITULO_SIMPLES";
	 
	static function init(){
		WProject::$menu = new Menu();
		WProject::$menu->loadLang(WMain::$Itemid);
	  
		WProject::$menuHome = new Menu();
		WProject::$menuHome->loadLang(1);
	  
		WProject::$tplTitulo = new WTemplate(WPath::tpl("titulo_introducao","shared"));
		WProject::$tplMenu = new WTemplate(WPath::tpl("menu","shared"));
	  
		$rows = WProject::$menu->montaMenuFront(WProject::$menu->id_menu, 1, 4, WProject::$menuHome->id_menu, "WHERE publicado=1 and tipo=0");

		$habilita_link_botao = false;
		$nivel_habilitado = 0;
		WProject::$tplTitulo->titulo_p = WProject::$menu->titulo;
		WProject::$menu_interno_tipo = WProject::$menu->menu_interno;
		$target = "_parent";
		foreach ($rows as $i=>$row){
			if($row->parent==161 && !isset($_SESSION['session_login']))continue;

			(stripos($row->link,"ttp")==1)?$target = "_blank":$target = "_parent";
			WProject::$tplMenu->target = $target;
			WProject::$tplTitulo->target = $target;
			WProject::$tplMenu->bind($row);
			WProject::$tplTitulo->bind($row);
			WProject::$tplTitulo->link = Menu::getLinkMenu($row);
			if(WProject::$menu_interno_tipo){
				WProject::$menu_interno = true;
				if($nivel_habilitado != $row->nivel){
					$habilita_link_botao = false;
				}else{
					if($habilita_link_botao){
						WProject::$tplTitulo->parseBlock("MENU_INTERNO_".((WProject::$menu_interno_tipo==1)?"ITEM":"LINK"));
					}
				}
			}
			if($row->id_main==WMain::$Itemid){
				$nivel_habilitado = $row->nivel+1;
				$habilita_link_botao = true;
			}
			switch ($row->nivel){
				case 0:
					if($i){
						WProject::$tplMenu->parseBlock("MENU_TITULO");
						WProject::$tplMenu->tipo_divisao = "padrao";
					}
					else {
						WProject::$tplMenu->tipo_divisao = "mod1";
					}
					WProject::$tplMenu->titulo_p = $row->titulo;
					break;
				case 2:
				case 1:
					WProject::$tplMenu->tag = ($row->nivel==1)?"dt":"dd";
					WProject::$tplMenu->link = Menu::getLinkMenu($row);
					WProject::$tplMenu->parseBlock(($row->marcado)?"MENU_ATIVO":"MENU_INATIVO");
					WProject::$tplMenu->parseBlock("MENU");
					if($row->marcado) WProject::$tplTitulo->titulo_p = $row->titulo;
					break;
				case 3:

					if($row->marcado){
						WProject::$tituloMenu = "TITULO_COMBO";
						WProject::$tplTitulo->id_filho = WProject::$menu->id_main;
					}
					else {
						WProject::$tplTitulo->id_filho = "";
					}
					WProject::$tplTitulo->parseBlock("MENU_TITULO");
					WProject::$tplTitulo->parseBlock("MENU_TITULO_AUX");
					break;
				case 4:
					if($row->marcado){
						WProject::$tituloMenu = "TITULO_COMBO2";
					}
					WProject::$tplTitulo->parseBlock("MENU_TITULO2");
					break;
			}
		}
		WProject::$tplMenu->parseBlock("MENU_TITULO");
	}

	static function js() {

		$absPathJSLib = ROOT."/templates/js/lib";
		$vetFiles = scandir($absPathJSLib);

		$html = "";
		foreach ($vetFiles as $arq) {
			if (($arq[0] == ".")or($arq == "..")) continue;
			$html .= WProject::jsSrc($arq,"lib");
		}

		$html .= WProject::jsSrc("functions.js");

		$html .= WProject::jsSrc(WMain::$option.".js","app");

		if ((WMain::$task)and($pathComTask = WProject::jsSrc(WMain::$option.".".WMain::$task.".js","app"))) {
			$html .= $pathComTask;
		}

		if ((WMain::$act)and($pathComAct = WProject::jsSrc(WMain::$option.".".WMain::$act.".js","app"))) {
			$html .= $pathComAct;
		}

		return $html;

	}

	static function jsAdmin() {

		$absPathJSLib = ROOT_ADMIN."/templates/js/lib";
		$vetFiles = scandir($absPathJSLib);

		$html = "";
		foreach ($vetFiles as $arq) {
			if (($arq[0] == ".")or($arq == "..")) continue;
			$html .= WProject::jsSrcAdmin($arq,"lib");
		}

		$html .= WProject::jsSrcAdmin("functions.admin.js");

		$html .= WProject::jsSrcAdmin(WMain::$option.".js","app");

		if ((WMain::$task)and($pathComTask = WProject::jsSrcAdmin(WMain::$option.".".WMain::$task.".js","app"))) {
			$html .= $pathComTask;
		}

		if ((WMain::$act)and($pathComAct = WProject::jsSrcAdmin(WMain::$option.".".WMain::$act.".js","app"))) {
			$html .= $pathComAct;
		}

		return $html;

	}

	static function jsSrc($arq, $dir = "") {

		$path = "/templates/js/$dir/";

		$src = false;
		if (file_exists(ROOT.$path.$arq)) {
			$src = LIVE.$path.$arq.'?'.md5(filemtime(ROOT.$path.$arq));
		}

		if ($src) {
			return '<script type="text/javascript" src="'.$src.'"></script> ';
		}
	}

	static function jsSrcAdmin($arq, $dir = "") {

		$path = "/templates/js/$dir/";

		$src = false;
		if (file_exists(ROOT_ADMIN.$path.$arq)) {
			$src = LIVE_ADMIN.$path.$arq.'?'.md5(filemtime(ROOT_ADMIN.$path.$arq));
		}

		if ($src) {
			return '<script type="text/javascript" src="'.$src.'"></script> ';
		}
	}

	static function defaultLink() {
		return "index.php?option=".WMain::$option."&task=".WMain::$task."&Itemid=".WMain::$Itemid;
	}
	/*
	 static function urlAddGET($variavel,$valor){
	  

	 }*/
	 
	static function defaultLinkAdmin() {
		return "index.php?option=".WMain::$option."&task=".WMain::$task."&Adminid=".WMain::$Adminid;
	}
}
//teste... inutil
?>