<?

class WCache {

	private $chave = null;
	private $file = null;

	function WCache($chave){
		$this->chave = $chave;
	}

	 
	public function load(){
		if(file_exists(WPath::arquivoRoot($this->chave.".php","cache"))){
			include WPath::arquivoRoot($this->chave.".php","cache");
			return $cache;
		}
		return false;
	}

	public function clear(){
		@unlink(WPath::arquivoRoot($this->chave.".php","cache"));
	}

	public function clearLike($nomeArq = 'ALL') {
		$arqs = WFile::lsRecursivo(WPath::arquivoRoot('', 'cache'));
		foreach ($arqs as $arq) {
			if (strpos($arq,$nomeArq) !== false || $nomeArq == 'ALL') {
				@unlink($arq);
			}
		}
	}
	 
	public function store(){
		$arq = '<?php'."\n".$this->file."\n".'?>';
		file_put_contents(WPath::arquivoRoot($this->chave.".php","cache"), $arq);
	}

	static function var2str($varname, $var){
		$str = $varname.'=';
		if($var instanceof stdClass){
			$str .= ' new stdClass();'."\n";
			foreach ($var as $k=>$v){
				$vn = $varname.'->'.$k;
				$str .= WCache::var2str($vn, $v);
			}
		}
		elseif(is_array($var)){
			$str .= ' array();'."\n";
			foreach ($var as $k=>$v){
				if(is_string($var)){
					$vn = $varname.'['.WCache::aspa2str($k).']';
				}
				else{
					$vn = $varname.'['.$k.']';
				}
				$str .= WCache::var2str($vn, $v);
			}
		}
		elseif(is_string($var)){
			$str .= WCache::aspa2str($var).';'."\n";
		}
		elseif($var==''){
			$str .= "'';\n";
		}
		else{
			$str .= $var.';'."\n";
		}
		return $str;
	}

	static function aspa2str($str){
		return '\''.str_replace("'","\\'",str_replace("\\","\\\\",$str)).'\'';
	}

	public function bind($var){
		$this->file = WCache::var2str('$cache',$var);
	}
	 
}

?>