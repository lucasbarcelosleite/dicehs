<?

require_once WPath::inc("admin/admin.fullmenu.class.php");


$tpl = new WTemplate(WPath::tpl("_admin"));

$linkAtual = "index.php?option=".WMain::$option."&task=".WMain::$task."&Adminid=".WMain::$Adminid;

$tpl->editor = WHtmlEditorArea::init();
$tpl->nome_usuario = WMain::$usuario->nome;

$adminFullMenu = new WAdminFullMenu("Main");
$adminFullMenu->montaMenu(0);
$rows0 = $adminFullMenu->vetItemMenu;

foreach ($rows0 as $itemP0) {
	$tpl->p0_titulo = $itemP0->titulo;
	$tpl->p0_url = $itemP0->link;
	if (count($rows1 = $itemP0->vetItemMenu)) {
		foreach ($rows1 as $itemP1) {
			$tpl->p1_titulo = $itemP1->titulo;
			$tpl->p1_url = $itemP1->link;
			$tpl->parseBlock("MENU_ITEM_P1");					
		}
		$tpl->parseBlock("MENU_BLOCO_P1");
	}	
	$tpl->parseBlock("MENU_ITEM_P0");	
}

$tpl->toolbar = WMain::getModuloAdmin("toolbar", true);
$tpl->mosmsg = WMain::getModuloAdmin("mosmsg", true);
$tpl->inc_js = WJs::inc();

$tpl->show();

?>