<?php

class Menu extends WModel {

	var $id_menu = null;
	var $parent = null;
	var $titulo = null;
	var $link = null;
	var $introducao = null;
	var $publicado = null;
	var $ordering = null;
	var $id_conteudo = null;
	var $descricao = null;
	var $html_id = null;
	var $_listAssoc = null;

	function __construct() {
		$this->_wordem = array('parent');
		$this->_ordemTipo = "last";
		parent::__construct('#__menu', 'id_menu', 'titulo', 'parent, ordering');
	}

	function check() {
		if ($this->titulo == "") {
			$this->setErrorJs("titulo","T�tulo deve ser preenchido.");
			return false;
		}
		return true;
	}

	function store($updateNulls=false, $ordemTipo=false){
		$cache = new WCache("lista_menu_admin");
		$cache->clear();
		return parent::store($updateNulls, $ordemTipo);
	}

	function updateOrder($where=""){
		$cache = new WCache("lista_menu_admin");
		$cache->clear();
		return parent::updateOrder($where);
	}

	function deletaComFilhos($id_menu){
		if($this->selectCount("WHERE parent=".$id_menu)){
			$rows = $this->select("WHERE parent=".$id_menu);
			foreach ($rows as $row){
				$this->deletaComFilhos($row->id_menu);
			}
		}
		/*$this->_db->setQuery("DELETE FROM #__conteudo_midia WHERE id_conteudo in (SELECT id_conteudo FROM cms_conteudo WHERE id_menu =$id_menu)");
		 $this->_db->query();

		 $this->_db->setQuery("DELETE FROM #__conteudo WHERE id_menu=".$id_menu);
		 $this->_db->query();*/

		$this->_db->setQuery("DELETE FROM #__menu WHERE id_menu=".$id_menu);
		$this->_db->query();
	}
	 
	function montaComboMenu($where='', $idPai=0, $listMain = false, $idPaiMain=0) {
		if($nivel==0) $this->_mapTraducao = array();
		$whereItem = $where;
		if ($listMain) {
			WModel::andWhere($whereItem,"(parent=$idPai or parent=$idPaiMain)");
		} else{
			WModel::andWhere($whereItem,"parent=$idPai");
		}

		$rows = $this->select($whereItem);
		$resultado = "";
		if (count($rows)) {
			foreach ($rows as $row) {
				$resultado .= "<li rel='".$row->id_menu."'>".$row->titulo;
				$this->_mapTraducao[$row->id_menu] = $row->id_main;
				$this->_listAssoc[$row->id_menu] = $row->titulo;
				$submenu = $this->montaComboMenu($where, $row->id_menu, $listMain, $row->id_main);
				if($submenu){
					$resultado .= "<ul>";
					$resultado .= $submenu;
					$resultado .= "</ul>";
				}
				$resultado .= "</li>";
			}
		}
		return $resultado;
	}

	function montaMenu($where='', $idPai=0, $nivel=0, $separador="&nbsp;", $listMain = false, $idPaiMain=0, $pos_pai=0) {
		if ($nivel==0) {
			$this->_mapTraducao = array();
		}

		if ($where) {
			$whereItem = $where;
			if ($listMain) {
				WModel::andWhere($whereItem,"(parent=$idPai or parent=$idPaiMain)");
			} else {
				WModel::andWhere($whereItem,"parent=$idPai");
			}
			$rows = $this->select($whereItem);
		} else {
			$whereItem = $where;
			if ($listMain) {
				WModel::andWhere($whereItem,"(m.parent=$idPai or m.parent=$idPaiMain)");
			} else {
				WModel::andWhere($whereItem,"m.parent=$idPai");
			}
			$this->_db->setQuery("SELECT m.*, c.id_conteudo as id_conteudo FROM #__menu m
                                  LEFT JOIN #__conteudo c ON c.id_conteudo = m.id_conteudo
                                  ".$whereItem." 
                                  ORDER BY ordering asc");
			$rows = $this->_db->loadObjectList();
		}

		$menu = array();
		if (count($rows)) {
			foreach ($rows as $row) {
				$n_pai = count($menu);
				$row->nivel = $nivel;
				$row->pos_pai = $pos_pai;
				$row->titulo = str_repeat(str_repeat($separador,4), $nivel) . $row->titulo;
				$menu[] = $row;
				$this->_mapTraducao[$row->id_menu] = $row->id_main;
				$this->_listAssoc[$row->id_menu] = $row->titulo;
				$submenu = $this->montaMenu($where, $row->id_menu, ($nivel+1), $separador, $listMain, $row->id_main, $n_pai);
				if (count($submenu)) {
					$menu = array_merge($menu, $submenu);
				}
			}
		}
		if (!$where) {
			if (false) {
				//if($nivel==0){
				$cacheLA->bind($this->_listAssoc);
				$cacheMT->bind($this->_mapTraducao);
				$cache->bind($menu);
				$cacheMT->store();
				$cacheLA->store();
				$cache->store();
			}
		}
		return $menu;
	}

	function montaMenuFront($Itemid, $nivelVisivel, $nivelMax=15, $idPai=0, $where='WHERE publicado=1', $nivel=0){
		$nm = $nivelMax;
		$nv = $nivelVisivel;
		$nivelMax--;
		$nivelVisivel--;
		if($nivel==0) $this->_mapTraducao = array();
		$whereItem = $where;
		WModel::andWhere($whereItem,"parent=$idPai");
		$rows = $this->select($whereItem);
		$menu = array();
		if (count($rows)) {
			foreach ($rows as $row) {
				$row->nivel = $nivel;
				$row->titulo = $row->titulo;
				$row->marcado = (Menu::isParent($row->id_menu, $Itemid) or ($row->id_menu==$Itemid));
				$menu[] = $row;
				if((($nivel<=$nivelVisivel)or($row->marcado))and($nivel<=$nivelMax)){
					$menu = array_merge($menu, $this->montaMenuFront($Itemid, $nv, $nm, $row->id_menu, $where, ($nivel+1)));
				}
			}
		}
		return $menu;
	}
	 
	function montaMenuFrontTpl(&$tpl, $idParent=0, $nivel=0) {
		$rows = $this->select("WHERE publicado = 1 AND parent = $idParent", "", !$nivel ? 5 : "");

		if (count($rows)) {
			foreach ($rows as $i => $row) {
				$this->montaMenuFrontTpl($tpl, $row->id_menu, $nivel+1);

				$tpl->titulo = $row->titulo;
				$tpl->link   = $this->getLinkRow($row);
				$tpl->imagem = WFormat::html($row->titulo);

				$tpl->parseBlock("NIVEL_".$nivel);
			}

			$tpl->parseBlock("BOX_NIVEL_".$nivel);
		} else {
			return false;
		}
	}

	function montaMenuListaAdmin($listMain = true, $where=''){
		return $this->montaMenu($where, 0, 0, "&nbsp;", $listMain);
	}

	function temFilhos($Itemid) {
		return $this->selectCount("WHERE parent = $Itemid AND publicado = 1");
	}

	function getParent($Itemid, $parent=0) {
		$menu = $this->select("WHERE id_menu = $Itemid");
		if ($menu[0]->parent == $parent) {
			return $Itemid;
		} else {
			return $this->getParent($menu[0]->parent,$parent);
		}
	}

	function isParent($idPai,$ItemId){
		$menu = $this->select("WHERE id_menu = $ItemId");
		if ($menu[0]->parent==$idPai) {
			return true;
		} elseif ($menu[0]->parent==0) {
			return false;
		} else {
			return $this->isParent($idPai, $menu[0]->parent);
		}
	}

	function loadParents($Itemid, $paginaInicial=false, $apenasNome =false ,$vMenu=array()) {
		$menus = $this->selectBy("id_menu", $Itemid);

		if (count($menus)) {
			$menu = $menus[0];

			if ($menu->id_main==1 and !$paginaInicial) {
				return array_reverse($vMenu);
			} else {
				if($apenasNome){
					$vMenu[] = $menu->titulo;
				}
				else{
					$vMenu[] = $menu;
				}
			}

			return $this->loadParents($menu->parent, $paginaInicial, $apenasNome, $vMenu);
		} else {
			return array_reverse($vMenu);
		}
	}

	function getLink($id_main, $seo=true) {
		$menu = new Menu();
		$menu->load($id_main);
		return $menu->getLinkRow($menu, $seo);
	}

	function getLinkAtual($seo=false) {
		return Menu::getLinkRow(WMain::$menu, $seo);
	}
	 
	function getLinkRow($row="", $seo=true) {
		if (!$row) {
			$row = $this;
		}
		 
		$linkExterno = WValidate::linkExterno($row->link);
		 
		if (strpos($row->link, "#")===0) {
			return $row->link;
		} elseif (strpos($row->link, "modal=true")!==false) {
			return WLink($row->link.'&Itemid=10000');
		} elseif ($row->link=="conteudo") {
			$link = "index.php?option=conteudo&Itemid=".$row->id_menu;
		} elseif (strpos($row->link, "Itemid")) {
			parse_str(str_replace("index.php?", "", $row->link), $vars);
			return Menu::getLink($vars['Itemid'], $seo);
		} else {
			$link = $row->link . (strpos($row->link,"http")!==false ? "" : "&Itemid=".$row->id_menu);
		}
		 
		return ($seo and !$linkExterno and strpos($link,"http")===false) ? WSEOUrl::format($link) : $link;
	}

}

?>