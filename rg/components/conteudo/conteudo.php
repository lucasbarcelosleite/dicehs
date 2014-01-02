<?

if (WMain::$menu->id_conteudo) {
	$conteudo = new Conteudo();
	$conteudo->load(Wmain::$menu->id_conteudo);
	
	$tpl = new WTemplate(WPath::tpl("conteudo"));
	$tpl->texto = $conteudo->texto;
	$tpl->show();
}

?>