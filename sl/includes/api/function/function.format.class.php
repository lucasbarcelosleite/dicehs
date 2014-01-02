<?

class WFormat {

	static function int($valor) {
		return str_replace("-","",$valor);
	}
	 
	static function link($link) {
		if (WValidate::linkExterno($link) and substr($link,0,4)!="http") {
			$link = "http://".$link;
		}
		return !WMain::$isAdmin ? htmlentities($link) : $link;
	}
	 
	static function substrTexto($texto,$limite=400, $comp = '...') {
		$texto = strip_tags($texto);
		if (strlen($texto)>$limite) {
			$texto = substr($texto,0,$limite);
			$texto = substr($texto,0,strrpos($texto," ")).$comp;
		}
		return $texto;
	}
	 
	static function toLower($string) {
		$retorno = strtr($string,'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÑÒÓÔÕÖØÙÚÛÜİ',
                               'àáâãäåçèéêëìíîïñòóôõöøùúûüı');
		return strtolower($retorno);
	}
	 
	static function toUpper($string) {
		$retorno = strtr($string,'àáâãäåçèéêëìíîïñòóôõöøùúûüı',
                               'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÑÒÓÔÕÖØÙÚÛÜİ');
		return strtoupper($retorno);
	}

	static function removeAcentos($texto) {
		$texto = preg_replace('/[áàãâä]/',"a",$texto);
		$texto = preg_replace('/[éèêë]/' ,"e",$texto);
		$texto = preg_replace('/[íìîï]/' ,"i",$texto);
		$texto = preg_replace('/[óòôõö]/',"o",$texto);
		$texto = preg_replace('/[úùûü]/' ,"u",$texto);
		$texto = preg_replace('/[ñ]/'    ,"n",$texto);
		$texto = preg_replace('/[ç]/'    ,"c",$texto);
		$texto = preg_replace('/[ÁÀÃÂÄ]/',"A",$texto);
		$texto = preg_replace('/[ÉÈÊË]/' ,"E",$texto);
		$texto = preg_replace('/[ÍÌÎÏÏ]/',"I",$texto);
		$texto = preg_replace('/[ÓÒÔÕÖ]/',"O",$texto);
		$texto = preg_replace('/[ÚÙÛÜ]/' ,"U",$texto);
		$texto = preg_replace('/[Ñ]/'    ,"N",$texto);
		$texto = preg_replace('/[Ç]/'    ,"C",$texto);
		$texto = preg_replace('/[Ç]/'    ,"C",$texto);
		$texto = preg_replace('/[Ç]/'    ,"C",$texto);
		$texto = preg_replace('/[?²¹º³ª]/',"",$texto);

		return addslashes($texto);
	}
	 
	/* ucwords, considerando acentos */
	static function capital($palavra){
		$palavra = trim($palavra);
		 
		if(($tamanho = strlen($palavra))==0){
			return "";
		}
		 
		$com_acento_min = "àáâãäåçèéêëìíîïñòóôõöøùúûü";
		$com_acento_mai = "ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÑÒÓÔÕÖØÙÚÛÜİ";
		 
		$palavraFinal = strtoupper(strtr(substr($palavra,0,1),$com_acento_min,$com_acento_mai));
		 
		for($pos=1;$pos<$tamanho;$pos++){
			if (substr($palavra,$pos-1,1)==" ") {
				$palavraFinal .= strtoupper(strtr(substr($palavra,$pos,1),$com_acento_min,$com_acento_mai));
			} else {
				$palavraFinal .= substr($palavra,$pos,1);
			}
		}
		 
		return $palavraFinal;
	}

	/* ucWords, deixando algumas palavras minúsculas */
	static function nome($nome,$ficam_minusculas=0) {
		if ( !is_null($nome) ) {
			 
			if ( $ficam_minusculas==0 ) { $ficam_minusculos = array("de","del","do","dos","da","das","a","as","e","o","os","que","para","em","no","na","nos","nas"); }
			$aspas = array("'","`","'");
			$nome = explode(" ", WFormat::toLower(stripslashes(trim($nome))));
			 
			foreach( $nome as $palavra ) {

				if ( !in_array($palavra, $ficam_minusculos) ) {
					$palavra[0] = WFormat::toUpper($palavra[0]);
					if( isset($palavra[1]) and in_array($palavra[1], $aspas ) ){
						if( isset($palavra[2]) ) {
							$palavra[2] = WFormat::toUpper($palavra[2]);
						}
					}
				}
				$retorno[] = $palavra;
			}
			return implode(" ",$retorno);
		} else {
			return null;
		}
	}
	 
	static function nomePadrao($formato, $nomeDesformat) {
		$nomeFormat = trim(WFormat::removeAcentos($nomeDesformat));

		switch ($formato) {
			case "html":
				$nomeFormat = str_replace(",","",$nomeFormat);
				$nomeFormat = str_replace(" ","_",$nomeFormat);
				$nomeFormat = str_replace("-","_",$nomeFormat);
				$nomeFormat = strtolower($nomeFormat);
				break;
			case "css":
				$nomeFormat = str_replace(",","",$nomeFormat);
				$nomeFormat = str_replace(" ","-",$nomeFormat);
				$nomeFormat = str_replace("_","-",$nomeFormat);
				$nomeFormat = strtolower($nomeFormat);
				break;
			case "nome":
				$nomeFormat = str_replace("_"," ",$nomeFormat);
				$nomeFormat = WFormat::nome($nomeFormat);
				break;
			case "class":
				$nomeFormat = str_replace("_"," ",$nomeFormat);
				$nomeFormat = WFormat::capital($nomeFormat);
				$nomeFormat = str_replace(" ","",$nomeFormat);
				break;
			case "var":
			case "function":
			case "method":
				$nomeFormat = str_replace("_"," ",$nomeFormat);
				$nomeFormat = WFormat::capital($nomeFormat);
				$nomeFormat[0] = strtolower($nomeFormat[0]);
				$nomeFormat = str_replace(" ","",$nomeFormat);
				break;
		}
		return $nomeFormat;
	}
	 
	static function html($nome) {
		return $prefixo.WFormat::nomePadrao('html', $nome);
	}
	 
	static function css($nome) {
		return $prefixo.WFormat::nomePadrao('css', $nome);
	}

	static function moeda($valor,$casas="2") {
		return $valor ? "R$ ".number_format($valor, $casas, ",", ".") : "";
	}
	 
	static function moedaToNumber($valor,$casas="2") {
		return trim(str_replace(array("R$",".", ","), array("","", "."), $valor));
	}
	 
	static function numero($valor,$casas="0") {
		return $valor ? number_format($valor, $casas, ",", ".") : "";
	}
	 
	static function urlString($vetor) {
		$str = "";
		foreach ($vetor as $i => $v) {
			$str .= "&$i=".$v;
		}
		return $str;
	}
	 
	static function flashVars($vetor, $comFlashEncode = false) {
		$str = "";
		foreach ($vetor as $i => $v) {
			$str .= "&$i=".($comFlashEncode? WFormat::flashEncode($v) : $v);
		}
		return $str;
	}

	static function flashEncode($string){
		$string = rawurlencode(utf8_encode($string));
		 
		$string = str_replace("%C2%96", "-", $string);
		$string = str_replace("%C2%91", "%27", $string);
		$string = str_replace("%C2%92", "%27", $string);
		$string = str_replace("%C2%82", "%27", $string);
		$string = str_replace("%C2%93", "%22", $string);
		$string = str_replace("%C2%94", "%22", $string);
		$string = str_replace("%C2%84", "%22", $string);
		$string = str_replace("%C2%8B", "%C2%AB", $string);
		$string = str_replace("%C2%9B", "%C2%BB", $string);
		 
		return $string;
	}

	static function htmlButTags($str) {
		// Take all the html entities
		$caracteres = get_html_translation_table(HTML_ENTITIES);
		// Find out the "tags" entities
		$remover = get_html_translation_table(HTML_SPECIALCHARS);
		// Spit out the tags entities from the original table
		$caracteres = array_diff($caracteres, $remover);
		// Translate the string....
		$str = strtr($str, $caracteres);
		// And that's it!
		return $str;
	}
	 
	function byteToString($size) {
		$bytes = array('bytes','Kb','Mb','Gb','Tb');
		foreach($bytes as $val) {
			if($size > 1024){
				$size = $size / 1024;
			} else{
				break;
			}
		}
		return round($size, 2)." ".$val;
	}
	 
	static function trim($texto) {
		return preg_replace('/\s\s+/', ' ', $texto);
	}
	 
	static function porcentagem($numero, $casas = 0) {
		return $numero ? WFormat::numero($numero,$casas)."%" : "";
	}

}

?>