<?

class WValidate {

	static function data($dataDMY) {
		return WValidate::dataYMD(WDate::format($dataDMY));
	}

	static function dataYMD($dataYMD) {
		$separador = strpos($dataYMD,'/') ? '/' : '-';
		list($ano, $mes, $dia) = explode($separador,$dataYMD);
		if (trim($dia)!='' and trim($mes)!='' and trim($ano)!='') {
			return checkdate($mes,$dia,$ano);
		} else {
			return false;
		}
	}

	static function email($email) {
		return preg_match("/[\w\.\-]+@\w+[\w\.\-]*?\.\w{1,4}/",$email);
	}

	static function imagem($imagem) {
		return in_array(strtolower(WFile::extensao($imagem)), array(".jpg", ".gif", ".jpeg", ".png", ".bmp"));
	}

	static function cpf($cpf) {
		 
		$cpf = preg_replace("@[./-]@", "", $cpf);
		 
		if (strlen($cpf) != 11 || !is_numeric($cpf)) { return false; }
		else {
			 
			if (($cpf == "11111111111") || ($cpf == "22222222222") ||
			($cpf == "33333333333") || ($cpf == "44444444444") ||
			($cpf == "55555555555") || ($cpf == "66666666666") ||
			($cpf == "77777777777") || ($cpf == "88888888888") ||
			($cpf == "99999999999") || ($cpf == "00000000000")) {
				return false;
			} else {
				 
				$dv_informado = substr($cpf, 9,2);
				 
				for ($i=0; $i<=8; $i++) { $digito[$i] = substr($cpf, $i,1); }
				 
				$posicao = 10;
				$soma = 0;
				 
				for ($i=0; $i<=8; $i++) {
					$soma = $soma + $digito[$i] * $posicao;
					$posicao = $posicao - 1;
				}
				 
				$digito[9] = $soma % 11;
				 
				$digito[9] = $digito[9] < 2 ? 0 : 11 - $digito[9];
				 
				$posicao = 11;
				$soma = 0;
				 
				for ($i=0; $i<=9; $i++) {
					$soma = $soma + $digito[$i] * $posicao;
					$posicao = $posicao - 1;
				}
				 
				$digito[10] = $soma % 11;
				 
				$digito[10] = $digito[10] < 2 ? 0 : 11 - $digito[10];
				 
				$dv = $digito[9] * 10 + $digito[10];
				 
				if ($dv != $dv_informado) { return false; }
			}
		}
		 
		return true;
	}
	 
	static function cnpj($cnpj) {
		 
		$cnpj = preg_replace("@[./-]@", "", $cnpj);
		 
		if (strlen($cnpj) != 14 || !is_numeric($cnpj)) { return false; }
		else {
			$j = 5;
			$k = 6;
			$soma1 = "";
			$soma2 = "";
			 
			for ($i = 0; $i < 13; $i++) {
				$j = $j == 1 ? 9 : $j;
				$k = $k == 1 ? 9 : $k;
				$soma2 += ($cnpj{$i} * $k);
				 
				if ($i < 12) { $soma1 += ($cnpj{$i} * $j); }
				$k--;
				$j--;
			}
			 
			$digito1 = $soma1 % 11 < 2 ? 0 : 11 - $soma1 % 11;
			$digito2 = $soma2 % 11 < 2 ? 0 : 11 - $soma2 % 11;
			 
			if ($cnpj{12} != $digito1 || $cnpj{13} != $digito2) { return false; }
		}
		 
		return true;
	}
	 
	static function arrayVazio($array) {
		if (!is_array($array)) {
			return false;
		}
		return (trim(implode("",$array)) == "");
	}

	static function html($texto) {
		return (!((strpos($texto,"<") === false) and (strpos($texto,">") === false)));
	}
	 
	static function linkExterno($link) {
		return (strpos($link, LIVE)===false and (strpos($link,"http")!==false or strpos($link,"www")!==false));
	}
}

?>