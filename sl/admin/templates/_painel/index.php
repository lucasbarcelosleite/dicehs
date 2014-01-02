<?php

$tpl = new WTemplate(WPath::tpl("_painel"));

$tpl->editor = WHtmlEditorArea::init();

$tpl->toolbar = WMain::getModuloAdmin("toolbar", true);
$tpl->mosmsg = WMain::getModuloAdmin("mosmsg", true);
$tpl->inc_js = WJs::inc();

foreach (WLang::$lang_rows as $row){
	$tpl->ativo = (WLang::$lang->id_lang==$row->id_lang)?"ativo":"";
	$tpl->bind($row);
	$tpl->imagem = WPath::arquivo($row->imagem,"lang");
	$tpl->link = WProject::defaultLinkAdmin()."&sis_id_lang=".$row->id_lang;
	$tpl->parseBlock("DL_LANG");
}

$tpl->show();

?>
