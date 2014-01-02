<?

$tpl = new WTemplate(WPath::tpl("_login"));

$tpl->login     = pega("login");

if ($msg_login) {
	$tpl->msg_login = $msg_login;
	$tpl->parseBlock("MSG_ERRO");
}

$tpl->show();

?>