<?

$tpl = new WTemplate(WPath::tpl("spoiler.lista"));

$edicao = new Edicao();
$edicao->load(pega("edicao"));

$tpl->edicao_nome = $edicao->nome;
$tpl->edicao_texto = $edicao->texto;

// ========================================================================================
// PROXIMOS
// ========================================================================================

$spoiler = new Spoiler();
$rows = $spoiler->select("where id_edicao = ".$edicao->id_edicao,"order by id_spoiler desc");
$rows = array_merge($rows,$rows);

if (count($rows)) {
	foreach ($rows as $i => $row) {
		$tpl->spoiler_link = WSEOUrl::format("index.php?option=spoiler&Itemid=7&id=".$row->id_spoiler."&edicao=".$edicao->id_edicao);
		$tpl->spoiler_img = WPath::arquivo($row->imagem,"spoiler"); 

		$tpl->parseBlock("SPOILER_ITEM");
	}
} 


$tpl->show();


?>