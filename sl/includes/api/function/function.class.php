<?

class WFunction {

	/**
	 * Fun��o para envio de e-mails
	 *
	 * @param string $destinatario Destinat�rio do e-mail que vai ser enviado
	 * @param string $titulo T�tulo do e-mail que vai ser enviado
	 * @param string $body Texto do e-mail a ser enviado
	 * @return boolean Verifica��o de se foi enviado o e-mail
	 *
	 * */

	static function strip_quotes($text = "")  {
		$text = str_replace(array( '&#8216;', "&#8217;", '&#8242;'), '&#039;', $text);
		$text = str_replace(array("&#8220;", "&#8221;", "&#8243;"), "&#034;", $text);
		return $text;

	}


	static function mandaEmail($remetente, $nomeRemetente, $destinatario, $titulo, $body) {
		
		if (WConfig::$mailDebug) {
			$conteudo = "";
			$conteudo .= "Config: \n";
			$conteudo .= "\n Mail Send: ".WConfig::$mailSend;
			$conteudo .= "\n SMTP HOST: ".WConfig::$smtpHost;
			$conteudo .= "\n SMTP PORT: ".WConfig::$smtpPort;
			$conteudo .= "\n SMTP AUTH: ".WConfig::$smtpAuth;
			$conteudo .= "\n SMTP USER: ".WConfig::$smtpUser;
			$conteudo .= "\n SMTP PASS: ".WConfig::$smtpPassword;
			$conteudo .= "\n SMTP TLS: ".WConfig::$smtpTls;					
			$conteudo .= "Parametros: \n\n  ";
			$conteudo .= "Remetente = $remetente \n
						  Nome do Remetente = $nomeRemetente \n
						  Destinatario = $destinatario \n
						  Titulo = $titulo \n \n
						  Corpo do Email \n $body";
			// file_put_contents(ROOT."/arquivos/debug/mail-".date("dmYHis").".txt", $conteudo);
			// file_put_contents(ROOT."/arquivos/debug/mail-".date("dmYHis").".html", $body);
		}
		
		if ($destinatario) {
			$mailer = new PHPMailer();
			$mailer->SetLanguage("br");
			$mailer->IsHTML();
			$mailer->Mailer  = WConfig::$mailSend;
			$mailer->SetFrom($remetente, $nomeRemetente);
			$mailer->Subject = $titulo;
			$mailer->Body    = $body;
				
			if (is_array($destinatario)) {
				foreach($destinatario as $mail) {
					$mailer->AddAddress($mail);
				}
			} else {
				$mailer->AddAddress($destinatario);
			}
				
			if (WConfig::$smtpTls) {
				$mailer->SMTPSecure = "tls";
			}
				
			if (WConfig::$mailSend=="smtp") {
				$mailer->IsSMTP();
				$mailer->Host = WConfig::$smtpHost . (WConfig::$smtpPort ? ":".WConfig::$smtpPort : "");
				$mailer->SMTPAuth = WConfig::$smtpAuth;
				$mailer->Username = WConfig::$smtpUser;
				$mailer->Password = WConfig::$smtpPassword;
			}
				
			return $mailer->Send();
		}
	}
	 
	static function objectToArray ($object) {
		if (is_object($object)) {
			return get_object_vars($object);
		} elseif (is_array($object)) {
			$arr = array();
			for ($i = 0; $i < count($object); $i++) {
				$arr[] = (is_object($object[$i])?get_object_vars($object[$i]):$object[$i]);
			}
			return $arr;
		} else {
			return false;
		}
	}
	 
	static function getImageMargin($arquivo,$tamanho){
		$altura = @getimagesize($arquivo);
		$altura = $altura[1];
		return ($tamanho - $altura) / 2;
	}
	 
	static function array_walk_key($array,$funcao) {
		$ret = array();
		foreach ($array as $ind => $valor) {
			$iind = $funcao($ind);
			$ret[$iind] = $valor;
		}
		return $ret;

	}
	 
	static function arrayWalk(&$vetor, $funcao){
		foreach ($vetor as &$valor){
			if (is_array($valor)) {
				WFunction::arrayWalk($valor,$funcao);
			} else {
				$valor = chamaFuncao($funcao, array($valor));
			}
		}
	}
	 
	static function obj_walk_key($obj,$funcao){
		$ret = null;
		foreach ($obj as $ind => $valor) {
			$iind = $funcao($ind);
			$ret->$iind = $valor;
		}
		return $ret;
	}
	 
	static function ehPar($valor) {
		return $valor%2===0;
	}
	 
	static function youTubeDuracao($link) {
		$xml = file_get_contents('http://gdata.youtube.com/feeds/api/videos/'.WFunction::youTubeCodigo($link));
		$duration = substr($xml, strpos($xml, "seconds=")+9);
		$duration = substr($duration, 0, strpos($duration, "'"));
		return date('H:i:s', mktime(0,0,$duration));
	}
	 
	static function youTubeCodigo($link) {
		$vURL = parse_url($link);
		parse_str($vURL['query'], $vQuery);
		return $vQuery['v'];
	}

	static function youTubeJQueryMedia($link) {
		return 'http://www.youtube.com/v/'.WFunction::youTubeCodigo($link);
	}

	static function youTubeThumb($link,$hq = false) {
		if($hq) $hq = 'hq';
		return 'http://i2.ytimg.com/vi/'.WFunction::youTubeCodigo($link).'/'.$hq.'default.jpg';
	}
	 
}

?>