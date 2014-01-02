<?php

$tpl = new WTemplate(WPath::tpl('header.content'));

$menu = new Menu();
$menu->load(WMain::$Itemid);

$tpl->titulo = $menu->titulo;

if ($menu->html_id != 'produto') {
	$tpl->introducao = $menu->introducao;
	$tpl->parseBlock("BLOCO_TITULO");	
} 

$pathway = $menu->loadParents(WMain::$Itemid, true);
unset($pathway[count($pathway)-1]);

foreach ($pathway as $i => $menuItem) {
	$tpl->menu_url = $menu->getLinkRow($menuItem);
	$tpl->menu_titulo = $menuItem->titulo;
	$tpl->parseBlock("MIGALHA_ITEM");
}

if ($menu->html_id == 'produto') {
	$produto = new Produto();
	$produto->load(pega("id"));
	
	$tpl->menu_url = $produto->getLinkDetalhe($produto->id_produto);
	$tpl->menu_titulo = $produto->nome;
	$tpl->parseBlock("MIGALHA_ITEM");	
}

$tpl->show();

?>