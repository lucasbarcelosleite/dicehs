<?php

$form = new WAdminForm($row);

//---------------------------------------------

$field = new WHtmlInput("Titulo","titulo");
if(pega("titulo")){
	$field->value = pega("titulo");
}
$form->add($field);

/*
$categoria = new ConteudoCategoria();
$field = new WHtmlCombo("Categoria","id_conteudo_categoria");
$field->options = $categoria->selectAssoc();
$field->setLang($this->obj, $categoria->_mapTraducao);
$form->add($field);


if($row->tem_video){
	$field = new WHtmlInput("Link YouTube.com","link");
	$form->add($field);
}
*/

if($row->limit_char){
	$field = new WHtmlTextArea("Texto","texto");
	$field->limite = $row->limit_char;
	$form->add($field);
} else{
	$field = new WHtmlEditorArea("Texto","texto");
	$form->add($field);
}


$field = new WHtmlCheck("Publicado","publicado");
$form->add($field);


//---------------------------------------------
/*
 $midia = new ConteudoMidia();
 if ($this->obj->_isTraducao) {
 $vMidia = $midia->selectBy("id_conteudo", $row->id_main);
 } else {
 $vMidia = $midia->selectBy("id_conteudo", $row->id_conteudo);
 }

 $tpl["imagem"] = new WTemplate(WPath::tpl("conteudo_midia","shared"));
 $tpl["imagem"]->label_img = "thumbnail.png";
 $tpl["imagem"]->label_txt = "Imagens";
 $tpl["imagem"]->tipo = "imagem";
 $tpl["imagem"]->width = 150;
 $tpl["imagem"]->height = "";

 $tpl["arquivo"] = new WTemplate(WPath::tpl("conteudo_midia","shared"));
 $tpl["arquivo"]->label_img = "document_open_folder.png";
 $tpl["arquivo"]->label_txt = "Arquivos";
 $tpl["arquivo"]->hide_arquivo = " hide";
 $tpl["arquivo"]->tipo = "arquivo";

 $tpl["imagem"]->ind = $tpl["arquivo"]->ind = 0;

 if (count($vMidia)) {
 foreach ($vMidia as $i => $midia) {
 $tpl[$midia->tipo]->ind++;
 $tpl[$midia->tipo]->bind($midia);

 if($midia->is_original){
 $tpl[$midia->tipo]->hide = " hide";
 $tpl[$midia->tipo]->checked = ' checked="checked"';
 }
 else{
 $tpl[$midia->tipo]->hide = "";
 $tpl[$midia->tipo]->checked = '';
 }

 $tpl[$midia->tipo]->id_main = $midia->id_conteudo_midia;
 $tpl[$midia->tipo]->id_conteudo_midia = ($this->obj->_isTraducao)?"":$midia->id_conteudo_midia;

 $campo = $midia->tipo."_".$tpl[$midia->tipo]->ind;
 $field = new WHtmlUpload("",$campo);
 $field->dados = $midia;
 $field->dados->$campo = $midia->arquivo;
 $field->dados->_tbl_key = true;
 $tpl[$midia->tipo]->botao_upload = $field->show();
 $tpl[$midia->tipo]->parseBlock("UPLOAD");
 }
 }

 if ($this->obj->_nroImagens) {
 $field = new WHtml();
 $field->campo = $tpl["imagem"]->getContent();
 $form->add($field);
 }

 if ($this->obj->_nroArquivos) {
 $field = new WHtml();
 $field->campo = $tpl["arquivo"]->getContent();
 $form->add($field);
 }
 */
$field = new WHtmlHidden("id_menu",pega("id_menu"));
$form->add($field);

$field = new WHtmlHidden("voltar_cp",pega("voltar_cp"));
$form->add($field);

$field = new WHtmlHidden("voltar_id",pega("voltar_id"));
$form->add($field);

//---------------------------------------------

$form->show();

?>