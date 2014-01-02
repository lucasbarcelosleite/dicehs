<?php

$tpl = new WTemplate(WPath::tpl('comment'));
$tpl->pg_atual = WSEOUrl::getUrlAtual();
$tpl->show();

?>