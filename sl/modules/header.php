<?php

$tpl = new WTemplate(WPath::tpl('header'));

$menu = new Menu();

$menuParent0 = $menu->montaMenuFront(0,0,0,0);

$menuParentFilho = null;
foreach($menuParent0 as $menuItem) {
	
	$tpl->link_n1 = $menu->getLinkRow($menuItem);
	$tpl->titulo_n1 = $menuItem->titulo;

	$menuParentFilho = $menu->montaMenuFront(0,0,0,$menuItem->id_menu);
	if (count($menuParentFilho) != 0) {
		$tpl->class_parent = "parent";			
		foreach ($menuParentFilho as $menuFilho) {
			$tpl->link_n2 = $menu->getLinkRow($menuFilho);
			$tpl->titulo_n2 = $menuFilho->titulo;
			$tpl->parseBlock("MENU_ITEM_FILHO");							
		}		
		$tpl->parseBlock("TEM_FILHOS");
	} else {
		$tpl->class_parent = "";
	}
	
	$tpl->parseBlock("MENU_ITEM");		
}

$tpl->url_contato = WSEOUrl::format("index.php?option=conteudo&task=detalhe&id=2&Itemid=8");
$tpl->url_busca = WSEOUrl::format("index.php?option=busca&Itemid=11");


$tpl->show();

?>