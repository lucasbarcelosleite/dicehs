<?php

$tpl = new WTemplate(WPath::tpl('footer'));

$tpl->url_contato = WSEOUrl::format("index.php?option=conteudo&task=detalhe&id=2&Itemid=8");

$tpl->show();
?>