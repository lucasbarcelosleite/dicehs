<?php
if (!empty($_FILES)) {
	foreach ($_FILES as $nome=>$f){
		$dirs = scandir(WPath::arquivoRoot("","temp"));
		foreach ($dirs as $dir){
			if($dir[0]!="." && $dir!=date("Ymd")){
				$arqs = WFile::lsRecursivo(WPath::arquivoRoot($dir,"temp"),true,true);
				foreach ($arqs as $arq){
					@chmod($arq, 0777);
					@unlink($arq);
					@rmdir($arq);
				}
				@rmdir(WPath::arquivoRoot($dir,"temp"));
			}
		}
		if(!file_exists(WPath::arquivoRoot(date("Ymd"),"temp"))){
			mkdir(WPath::arquivoRoot(date("Ymd"),"temp"));
		}
		$tmpFile = uniqid(mktime()).".tmp";
		$tmp = WPath::arquivoRoot($tmpFile,"temp/".date("Ymd"));
		if (is_uploaded_file($f["tmp_name"])) {
			move_uploaded_file($f["tmp_name"], $tmp);
			$f["tmp_name"] = $tmp;
			$retorno = $f["name"].' <br />';
			foreach ($f as $k=>$v){
				$retorno .= '<input type="hidden" name="files['.$nome.']#x#['.$k.']" value="'.$v.'" />';
			}
			exit($retorno);
		}
		else {
			echo "Erro";
		}
	}
}
?>
