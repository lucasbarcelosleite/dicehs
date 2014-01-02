<?

class WMain {
	 
	public static $Itemid   = "";
	public static $Adminid  = "";
	public static $option   = "";
	public static $act      = "";
	public static $task     = "";
	public static $id       = "";
	public static $template = "";
	public static $isAdmin  = "";
	public static $modulo   = "";
	public static $conteudo = true;
	public static $facebookTags  = ""; 


	/**
	 * @var Menu Atributo do Obj
	 * */
	public static $menu = null;
	 
	/**
	 * @var Usuario Atributo do Obj
	 * */
	public static $usuario  = null;
	 
	function init() {
		WMain::$isAdmin = (basename(getcwd())=="admin");
		WMain::$Itemid  = pega("Itemid",1);
		WMain::$Adminid = pega("Adminid");
		WMain::$id      = pega("id");
		WMain::$option  = pega("option", WMain::$isAdmin ? "control_panel" : "home");
		WMain::$act     = pega("act");
		WMain::$task    = pega("task");

		WMain::$usuario = new Usuario();
		WMain::$usuario->loadLogado();

		WMain::$menu = new Menu();
		WMain::$menu->load(WMain::$Itemid);

		WMain::$facebookTags["titulo"] = WMain::$menu->titulo;
		WMain::$facebookTags["descricao"] = WConfig::$facebookDescription;
		WMain::$facebookTags["imagem"] = WPath::arquivo("logo-dice.jpg","marca");
	}
	 
	function getTemplate() {
		global $db;
		$db->setQuery("SELECT template FROM #__templates_menu
      		         WHERE menuid=".(empty(WMain::$Itemid)?0:WMain::$Itemid)." OR menuid=0 
      		         ORDER BY menuid DESC");
		return $db->loadResult();
	}

	function getModulo($posicao, $return=true) {

		$modulo = new Modulo();
		$moduloMenu = new ModuloMenu();
		$modulo->join("LEFT", $moduloMenu, array("id_modulo", "id_modulo"));
		$modulos = $modulo->selectJoin("WHERE publicado = 1 AND posicao = '$posicao'
	                                  AND (id_menu = ".(WMain::$Itemid + 0)." OR id_menu = 0)");
		$buffer = "";
		if (count($modulos) > 0) {
			foreach ($modulos as $modulo) {
				WMain::$modulo = str_replace(".php", "", $modulo->arquivo);
				if ($arquivo = WPath::modulo($modulo->arquivo)) {
					ob_start();
					 
					require $arquivo;
					$buffer .= ob_get_contents();
					ob_end_clean();
				}
			}
			WMain::$modulo = false;
		}

		if ($return) return $buffer; else echo $buffer;
	}

	function getModuloAdmin($nome, $return=false) {
		if ($path = WPath::modulo($nome.".php")) {
			ob_start();
			require $path;
			$buffer .= ob_get_contents();
			ob_end_clean();
		}
		if ($return) return $buffer; else echo $buffer;
	}

	function getMainBody() {
		ob_start();
		mosMainBody();
		$mainBody = ob_get_contents();
		ob_end_clean();
		return $mainBody;
	}

	function getComponent(){

		if (!pega("option")) {
	   
			$menu = new Menu();
	   
			if (empty(WMain::$Itemid)) {
				$rows = $menu->select("where parent=0","order by ordering asc",1);
				$row = $rows[0];
			} else {
				$menu->load(WMain::$Itemid);
				$row = $menu;
			}
				
			$vars = explode("&",str_replace("index.php?", "", $row->link));
			foreach ($vars as $var) {
				$var = explode("=",$var);
				$cp = $var[0];
				manipulaVar($var[0],$var[1]);
				if(isset(WMain::$$cp)){
					WMain::$$cp = $var[1];
				}
			}
				
		}
		return pega("option");
	}

	function getURL($link){
		global $database, $db, $usuario, $option, $task, $id;
		$bkp["REQUEST"] = serialize($_REQUEST);
		$bkp["POST"] = serialize($_POST);
		$bkp["GET"] = serialize($_GET);
		$strsvar = explode("&",$link);
		foreach ($strsvar as $strvar){
			$var = explode("=",$strvar);
			manipulaVar($var[0],(isset($var[1]))?$var[1]:"");
		}
		$GLOBALS["component"] = WMain::getComponent();
		$GLOBALS["path"] = WPath::component($GLOBALS["component"]);

		WMain::init();
		$mainframe = new mosMainFrame($GLOBALS["database"], $GLOBALS["component"], '.');
		ob_start();
		require $GLOBALS["path"];
		$GLOBALS["_MOS_OPTION"]['buffer'] = ob_get_contents();
		ob_end_clean();

		ob_start();
		require WPath::tplStruct(WMain::getTemplate());
		$retorno = ob_get_contents();
		ob_end_clean();

		$_REQUEST = unserialize($bkp["REQUEST"]);
		$_POST = unserialize($bkp["POST"]);
		$_GET = unserialize($bkp["GET"]);
		$GLOBALS["component"] = WMain::getComponent();
		$GLOBALS["path"] = WPath::component($GLOBALS["component"]);
		WMain::init();

		return $retorno;
	}

}

?>