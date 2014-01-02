<?php

function banner($id, $arquivo, $largura, $altura, $expandeHorizontal, $expandeVertical, $link) {
	global $mosConfig_live_site, $mainframe;
	ob_start();
	$tpl = new template($mainframe->getPath("tpl", ($expandeHorizontal || $expandeVertical)?"banner_expansivel":"banner_fixo", "com_banner"));
	 
	$extensao = explode(".", $arquivo);
	$is_flash = ($extensao[count($extensao)-1] == "swf");
	 
	$mGlobais["ID"] = $id;
	$mGlobais["WIDTH"] = $largura;
	$mGlobais["HEIGHT"] = $altura;
	$mGlobais["WIDTH_FLASH"] = $largura + $expandeHorizontal;
	$mGlobais["HEIGHT_FLASH"] = $altura + $expandeVertical;
	$mGlobais["ARQUIVO"] = $arquivo;

	$tpl->setBloco("modo_swf", ($is_flash)?array("URL_ENCODE" => urlencode($link), "ARQUIVO" => $arquivo, "WIDTH_FLASH" => ($largura + $expandeHorizontal), "HEIGHT_FLASH" => ($altura + $expandeVertical), "ID_FLASH" => $id):array());
	$tpl->setBloco("modo_img", ($is_flash)?array():array("URL" => $link, "ARQUIVO_IMG" => $arquivo, "WIDTH_IMG" => $largura, "HEIGHT_IMG" => $altura));
	 
	$tpl->setMarcacoes($mGlobais);
	 
	$tpl->show();
	$htmlBanner = ob_get_contents();
	ob_get_clean();
	return $htmlBanner;
}

function bannerPublicacao($posicao, $template="banner", $option="") {
	global $mosConfig_live_site, $database, $mainframe;
	ob_start();
	$tpl = new template($mainframe->getPath("tpl", $template, $option));
	 
	$anoMes = date("Ym");
	$publicados = ($_REQUEST["banners"] == "teste")?0:1;
	$vBanners = $id_banners = array();
	$i = 0;
	 
	$periodo = "(b.data_inicial <= now() AND b.data_final >= now())";
	$visualizacao = "(b.limite_visualizacao > (SELECT CASE WHEN sum(nro_visualizacoes) is NULL
      					THEN 0 ELSE sum(nro_visualizacoes) END AS total_visualizacoes 
      					FROM #av_banner_campanha WHERE id_banner=b.id_banner))";
	$clique = "(b.limite_cliques > (SELECT CASE WHEN sum(nro_cliques) is NULL
   					THEN 0 ELSE sum(nro_cliques) END AS total_cliques
   					FROM #av_banner_campanha WHERE id_banner=b.id_banner))";
	 
	$database->setSafeQuery("SELECT bpt.id_banner_posicao, b.id_banner FROM #av_banner b
                              INNER JOIN #av_banner_posicao_tipo bpt ON bpt.id_banner_tipo = b.id_banner_tipo 
                              INNER JOIN #av_banner_posicao bp ON bpt.id_banner_posicao = bp.id_banner_posicao AND bp.posicao = '$posicao'
                              INNER JOIN #av_banner_banner_posicao bbp ON b.id_banner = bbp.id_banner AND (bbp.id_banner_posicao IS NULL OR bbp.id_banner_posicao = bp.id_banner_posicao)
                              WHERE b.publicado = $publicados AND (
                  								(b.regra = 0 AND $visualizacao) OR
                  								(b.regra = 1 AND $clique) OR
                  								(b.regra = 2 AND ($visualizacao OR $clique)) OR
                  								(b.regra = 3 AND $periodo) OR
                  								(b.regra = 4 AND $periodo AND $clique) OR
                  								(b.regra = 5 AND $periodo AND $visualizacao)
                  							)
       							GROUP BY bpt.id_banner_posicao, b.id_banner
                        	ORDER BY bpt.id_banner_posicao, b.id_banner");
	$rows = $database->loadObjectList();
	if(count($rows) > 0) {
		$posicao = array();
		foreach($rows as $row) {
			if(!in_array($row->id_banner_posicao, $posicao)) $posicao[] = $row->id_banner_posicao;
			$bannersSelecionados[$row->id_banner_posicao][] = $row->id_banner;
		}

		$bannerPosicao = array_rand($posicao, 1);
		$bannerPosicao = $posicao[$bannerPosicao];
		$bannersSelecionados = $bannersSelecionados[$bannerPosicao];

		$database->setSafeQuery("SELECT bpt.id_banner_posicao_tipo, bpt.id_banner_tipo, bpt.quantidade, bt.largura, bt.altura, bt.expande_x, bt.expande_y
                                 FROM #av_banner_posicao_tipo bpt
                                 INNER JOIN #av_banner_tipo bt ON bt.id_banner_tipo = bpt.id_banner_tipo 
                                 INNER JOIN #av_banner_posicao bp ON bpt.id_banner_posicao = bp.id_banner_posicao AND bp.id_banner_posicao = '$bannerPosicao'
                              ORDER BY bpt.ordering");
		$posicoes = $database->loadObjectList();

		foreach($posicoes AS $posicao) {
			$database->setSafeQuery("SELECT b.* FROM #av_banner b
      							        WHERE b.id_banner_tipo=".$posicao->id_banner_tipo." AND b.id_banner in (".implode(",", $bannersSelecionados).")
            							ORDER BY random() LIMIT ".$posicao->quantidade);
			$banners = $database->loadObjectList();
			foreach ($banners AS $banner) {
				$link = sefRelToAbs("index.php?option=com_banner&task=click&id_banner=".$banner->id_banner."&id_banner_posicao=".$bannerPosicao."&Itemid=10000");
				$vBanners[$i++]["BANNER"] = banner($banner->id_banner, $banner->arquivo, $posicao->largura, $posicao->altura, $posicao->expande_x, $posicao->expande_y, $link);
				$id_banners[] = $banner->id_banner;
			}
		}

		if($publicados)  {
			// contagem de visualiza��es
			$id_banners = implode(", ", $id_banners);
			$database->setSafeQuery("INSERT INTO #av_banner_campanha (id_banner, nro_visualizacoes, nro_cliques, ano_mes, id_banner_posicao)
                                 SELECT b.id_banner AS id_banner, 0 AS nro_visualizacoes, 0 AS nro_cliques, $anoMes AS ano_mes, $bannerPosicao AS id_banner_posicao
                                 FROM #av_banner b 
                                 WHERE b.id_banner in ($id_banners) AND b.id_banner not in 
                                       (SELECT bc.id_banner FROM #av_banner_campanha bc 
                                       WHERE bc.ano_mes = $anoMes AND bc.id_banner in ($id_banners) 
                                       AND bc.id_banner_posicao = $bannerPosicao)");
			$database->query();
			 
			$database->setSafeQuery("UPDATE #av_banner_campanha SET nro_visualizacoes = nro_visualizacoes+1 WHERE id_banner in ($id_banners) AND ano_mes = '$anoMes' AND id_banner_posicao = $bannerPosicao");
			$database->query();
		}
	} else {
		$vBanners = array();
	}

	$tpl->setBloco("bloco_banner", $vBanners);
	 
	$tpl->show();
	$htmlBanners = ob_get_contents();
	ob_get_clean();
	return $htmlBanners;
}
?>