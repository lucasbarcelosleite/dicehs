<?php

$form = new WAdminForm($row);

//---------------------------------------------

$field = new WHtmlInput("Titulo","titulo");
$form->add($field);

//-----------------------------------------

if(pega("parent")){
	$field = new WHtmlHidden("parent",pega("parent"));
	$form->add($field);
}else{
	$menu = new Menu();

	$ret = $menu->montaComboMenu($row->id_menu ? 'WHERE id_menu <> '.$row->id_menu : '', 0, WLang::$adminListMain, 1);
	 
	$field = new WHtmlDropDownMenu("Nivel", "parent");
	$field->options = "<li rel='".$menu->id_menu."'>".$menu->titulo."</li>".$ret;
	$field->setLang($this->obj, $menu->_mapTraducao);
	$form->add($field);
}

//-----------------------------------------

$field = new WHtmlRadioGroup("Tipo de Link","link_tipo", ($row->id_conteudo ? 'C' : 'N'));
$field->options['N'] = 'Link Externo ou Conteudo Dinamico';
$field->options['C'] = 'Pagina de Texto';
$form->add($field);

$field = new WHtmlInput("Link","link");
$form->add($field);

$conteudo = new Conteudo();
$asCateg = $conteudo->join("INNER", new ConteudoCategoria());
$textos = $conteudo->selectJoin("WHERE ".$conteudo->getWhereLang(), "ORDER BY $asCateg.nome, conteudo.titulo");

foreach ($textos as $texto) {
	$conteudos[$texto->id_conteudo] = $texto->conteudo_categoria->nome." - ".$texto->titulo;
}

$conteudo = new Conteudo();
$conteudo->loadWhere("WHERE id_menu = ".$row->id_menu." AND ".$conteudo->getWhereLang());

$field = new WHtmlCombo("Selecione a Pagina de Texto", "id_conteudo", $conteudo->id_conteudo);
$field->options = $conteudos;
$form->add($field);

$field = new WHtmlCheck("Publicado","publicado");
$form->add($field);

$field = new WHtmlEditorArea("Texto Introdutorio","introducao");
$form->add($field);

//--------------------------------------------------

$seoMenu = new SeoMenu();
$seoMenu->loadBy("id_menu", $this->obj->id_menu);

$field = new WHtml();
$field->campo = "<h2>Informacoes para os Mecanismos de Busca (SEO)</h2>";
$form->add($field);

$field = new WHtmlInput("Titulo","page_title",$seoMenu->page_title);
$form->add($field);

$field = new WHtmlInput("Descrição","meta_description",$seoMenu->meta_description);
$form->add($field);

$field = new WHtmlInput("Palavras-chave","meta_keywords",$seoMenu->meta_keywords);
$form->add($field);


$form->show();

?>