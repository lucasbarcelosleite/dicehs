<?php

$ed = new Edicao();
$ed->load($edicao);
WSEOUrl::add($ed->nome);

if ($id) {
	WSEOUrl::add("card-".$id);
}

if ($act) {
	WSEOUrl::add("detalhe");
}

?>