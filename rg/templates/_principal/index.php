<?

$tpl = new WTemplate(WPath::tpl("_principal"));

$menu = new Menu();
$menu->load(WMain::$Itemid);


$isModal = ((WMain::$option == "spoiler")and(pega("id"))and(!(pega("act"))));

if (($menu->id_menu == 1) or ($isModal)) {
	$tpl->css_menu = "str-home";
	$tpl->parseBlock("STR_HOME");
} else {
	$tpl->css_menu = "str-interna";
	$tpl->titulo = $menu->titulo;
	$tpl->parseBlock("STR_INTERNA");
}



$rows = $menu->select("where publicado = 1 and parent = 1","order by ordering");

foreach ($rows as $row) {
	$tpl->titulo = $row->titulo;
	$tpl->link = WSEOUrl::format($row->link . "&Itemid=".$row->id_menu);
	// $tpl->link = $row->link . "&Itemid=".$row->id_menu;
	$tpl->parseBlock("MENU_ITEM");
}

if (!($isModal)) {
	$tpl->parseBlock("HEADER");
}


$conteudo = new Conteudo();
$tpl->endereco_dice = $conteudo->getHtmlByChave("endereco_dice");

$tpl->bind(WSEOHead::getInformation());
$tpl->page_title 	 = WMain::$facebookTags["titulo"] . " - " .WConfig::$siteName;

$tpl->fb_admin 		 = WConfig::$facebookUserModerator;
$tpl->og_title 		 = WMain::$facebookTags["titulo"] . " - " .WConfig::$siteName;
$tpl->og_description = htmlentities(WMain::$facebookTags["descricao"]);
$tpl->og_image 		 = WMain::$facebookTags["imagem"];
$tpl->og_url 		 = WSEOUrl::getUrlAtual();
$tpl->site_name 	 = WConfig::$siteName;

if (!($isModal)) {
	$tpl->parseBlock("FOOTER");
}

$tpl->show();

?>