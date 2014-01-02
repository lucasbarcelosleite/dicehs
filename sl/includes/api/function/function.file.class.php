<?

class WFile {
	 
	static function tamanho($arquivo) {
		$tamanho = filesize($arquivo);
		return WFormat::byteToString($tamanho);
	}
	 
	static function dimensoes($arquivo, $diretorio="") {
		return getimagesize(WPath::arquivoRoot($arquivo,$diretorio));
	}
	 
	static function extensao($arquivo) {
		return substr($arquivo,strrpos($arquivo,"."));
	}
	 
	static function existe($arquivo, $diretorio="") {
		return is_file(WPath::arquivoRoot($arquivo,$diretorio)) and file_exists(WPath::arquivoRoot($arquivo,$diretorio));
	}
	 
	static function remove($diretorio, $nomeArquivo) {
		$vArquivos = scandir($diretorio);
		 
		foreach ($vArquivos as $arquivo) {
			if ($nomeArquivo!="" and $diretorio!="" and !(strpos($arquivo, $nomeArquivo)===false)) {
				@unlink($diretorio.$arquivo);
			}
		}
	}

	static function lsRecursivo($dir, $mostrarOcultos=false, $mostrarDiretorios=false) {
		$vRetorno = array();

		$vDir = scandir($dir);
		foreach ($vDir as $arq) {
		 if((!$mostrarOcultos) && ($arq[0]==".")){
		 	continue;
		 }
		 if (($arq == ".") or ($arq == "..")) {
		 	continue;
		 }
		 if (is_dir($dir."/".$arq)) {
		 	$vRetorno = array_merge($vRetorno,WFile::lsRecursivo($dir."/".$arq,$mostrarOcultos,$mostrarDiretorios));
		 	if(!$mostrarDiretorios) continue;
		 }
		  
		 $vRetorno[] = $dir."/".$arq;
		}
		return $vRetorno;

	}

}

?>