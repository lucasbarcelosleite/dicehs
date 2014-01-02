<?

$tpl = new WTemplate(WPath::tpl("publicacao.lista"));

$publicacao = new Publicacao();
$cat = $publicacao->join("left", new PublicacaoCategoria());

$filtro = "";

if (pega("categoria")) {

	$filtro = " and ".$publicacao->_tbl_alias.".id_publicacao_categoria = ".pega("categoria");

	$pubCategoria = new PublicacaoCategoria();
	$pubCategoria->load(pega("categoria"));

	$tpl->categoria_nome = $pubCategoria->nome;
	$tpl->parseBlock("TEM_CATEGORIA");
}


$rows = $publicacao->select("where ".$publicacao->_tbl_alias.".publicado = 1 
							   ".$filtro."
							   and ".$publicacao->_tbl_alias.".publicar_em <> 2","order by data desc");

if (count($rows)) {
	foreach ($rows as $i => $row) {
		$tpl->pub_link = WSEOUrl::format("index.php?option=publicacao&Itemid=3&id=".$row->id_publicacao);
		$tpl->pub_img = WPath::arquivo("home_".$row->imagem,"publicacao"); 
		$tpl->pub_data = WDate::format($row->data);
		$tpl->pub_class = ($i == 0) ? "first" : (($i == 2) ? "last" : "");
		$tpl->pub_titulo = $row->titulo;
		$tpl->pub_chamada = $row->chamada;

		if ($row->id_publicacao_categoria) {
			$tpl->cat_nome = $row->publicacao_categoria->nome;
			$tpl->cat_class = PublicacaoCategoria::getClass($row->id_publicacao_categoria);
			$tpl->cat_link = WSEOUrl::format("index.php?option=publicacao&Itemid=3&categoria=".$row->id_publicacao_categoria);
		} else {
			$tpl->cat_nome = "";
		}

		$tpl->parseBlock("PUBLICACAO_ITEM");

		if  ((($i+1) % 3 == 0)or(count($rows) == $i+1)) $tpl->parseBlock("PUBLICACAO_CONTAINER");		
	}
} 



$tpl->show();


?>