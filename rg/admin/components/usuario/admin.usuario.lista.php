<?php

$grid = new WAdminLista();
$grid->setObj($this->obj);

$col = new WAdminListaColuna("Nome","nome");
$grid->add($col);

$col = new WAdminListaColuna("Login","login");
$col->largura = 150;
$grid->add($col);

function atualizaLogin($obj){
	$usu = new Usuario();
	$usu->load($obj->id_usuario);
	$usu->login = $usu->nome_primeiro.".".$usu->nome_ultimo;
	$usu->login = WFormat::toLower(WFormat::removeAcentos($usu->login));
	$usu->store();
	return $usu->login;
}

$col = new WAdminListaColuna("Último Login","ultimo_login");
$col->largura = 110;
$col->setFuncao("WDate::format");
$grid->add($col);

$col = new WAdminListaColuna("Último Acesso","ultimo_acesso");
$col->largura = 110;
$col->setFuncao("WDate::format");
$grid->add($col);

$col = new WAdminListaColuna("Logado?","session_id");
$col->ordem = false;
$col->setFuncaoObj("trataSessionidTela");
$col->align = 'center';
$col->width = 70;
$grid->add($col);

$col = new WAdminListaColuna("Alterar Senha","altera_senha");
$col->ordem = false;
$col->setLink("index.php?option=usuario&id={id_usuario}&task=editarSenha", null, "Alterar Senha");
$col->largura = 75;
$grid->add($col);

$grid->ordemPadrao("ultimo_acesso","desc");

$grid->autoLista($rows, $total);
$grid->show();

function trataSessionidTela($obj) {
	$usuario = new Usuario();
	$usuario->bind(mosObjectToArray($obj));
	return $usuario->isOnline() ? "Sim" : "";
}

?>