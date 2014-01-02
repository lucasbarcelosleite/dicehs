<?

class WAdminFullMenu {

	var $titulo;
	var $icone = false;
	var $link = false;
	var $vetItemMenu = array();

	function WAdminFullMenu ($titulo = "Main", $link=false, $icone=false) {
		$this->titulo = $titulo;
		$this->icone = $icone;
		$this->link = $link;
	}

	function add(&$itemMenu) {
		$this->vetItemMenu[] = $itemMenu;
	}

	function showItem(){
		$js = array();
		foreach ($this->vetItemMenu as $i => $submenu) {
			$js[] = $submenu->showItem();
		}

		$ico = (!$this->icone) ? "null" : "'<img src=\"$this->icone\" />'";
		$link = (!$this->link)?"null":"'$this->link'";
		$js_ret = (!$js)?"":",".implode(",",$js);
		return "[$ico,'$this->titulo',$link,null,'$this->titulo'$js_ret]";
	}

	function getJs(){
		$menuJs = array();
		foreach ($this->vetItemMenu as $i => $submenu) {
			$menuJs[] = $submenu->showItem();
		}
		return "var myMenu = [".implode(", _cmSplit ,",$menuJs)."]; cmDraw ('myMenuID', myMenu, 'hbr', cmThemeOffice, 'ThemeOffice');";
	}

	function show(){
		echo "<div id=\"myMenuID\"></div>
		      <script>".$this->getJs()."</script>";
	}

	function montaMenu($parent) {
		$menu = new MenuAdmin();

		if (WConfig::$habilitaPermissoes) {
			$menu->_db->setQuery("SELECT DISTINCT m.id_menu_admin, link, icone, titulo, parent, m.ordering FROM #__menu_admin m
                                  INNER JOIN #__usuario_grupo_menu_admin gm ON gm.id_menu_admin = m.id_menu_admin
                                  INNER JOIN #__usuario_grupo g ON g.id_usuario_grupo = gm.id_usuario_grupo
                                  WHERE parent = ".$parent." AND publicado = 1
                                  AND gm.id_usuario_grupo IN (".implode(", ", array_keys(WMain::$usuario->_grupos)).")
                                  ORDER BY m.ordering");
			$rows = $menu->_db->loadObjectList();
		} else {
			$rows = $menu->select("WHERE parent = $parent AND publicado = 1");
		}
		 
		if (count($rows)) {
			foreach ($rows as $row) {
				$icone = ($row->icone and $row->parent) ? WPath::img("menu/".$row->icone) : false;
				$menu = new WAdminFullMenu($row->titulo, "index.php?tpl=_admin&".$row->link . "&Adminid=".$row->id_menu_admin, $icone);
				$menu->montaMenu($row->id_menu_admin);
				$this->add($menu);
			}
		}
	}

}
?>