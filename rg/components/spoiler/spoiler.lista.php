<?

$tpl = new WTemplate(WPath::tpl("spoiler.lista"));


$ed = new Edicao();

$rowsEdicao = $ed->select("where is_spoiler = 1");

if (count($rowsEdicao)) {

	foreach ($rowsEdicao as $edicao) {

		$tpl->edicao_nome = $edicao->nome;
		$tpl->edicao_texto = $edicao->texto;

		if ($edicao->imagem) {
			WMain::$facebookTags["imagem"] = WPath::arquivo("home_".$edicao->imagem,"edicao");
		}

		// ========================================================================================
		// PROXIMOS
		// ========================================================================================

		$spoiler = new Spoiler();
		$rows = $spoiler->select("where id_edicao = ".$edicao->id_edicao,"order by id_spoiler desc");

		if (count($rows)) {
			foreach ($rows as $i => $row) {
				$tpl->spoiler_link = WSEOUrl::format("index.php?option=spoiler&Itemid=7&id=".$row->id_spoiler."&edicao=".$edicao->id_edicao);
				$tpl->spoiler_img = WPath::arquivo($row->imagem,"spoiler"); 

				$tpl->parseBlock("SPOILER_ITEM");
			}
		}

		$tpl->parseBlock("EDICAO_ITEM"); 
	}
}

$tpl->show();


?>