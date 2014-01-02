<?

class WDate {

	static public $mesExtenso = array(0,"janeiro","fevereiro","mar�o","abril","maio","junho","julho","agosto","setembro","outubro","novembro","dezembro");

	static function valida($dataDMY) {
		return WValidate::data($dataDMY);
	}

	static function validaYMD($dataYMD) {
		return WValidate::dataYMD($dataYMD);
	}

	static function diaExtenso($data,$feira=false){
		if(eregi("-",$data)) {
			$aux = explode("-",$data);
		} else {
			$aux = explode("/",$data);
		}

		$mes = $aux[1];
		if (strlen($aux[0])>2) {
			$dia = $aux[2];
			$ano = $aux[0];
		} else {
			$dia = $aux[0];
			$ano = $aux[2];
		}
		 
		if($feira) {
			$comp = "-feira";
		} else {
			$comp = "";
		}
		 
		switch (date("w",mktime(0,0,0,$mes,$dia,$ano))) {
			case 0: return "Domingo";       break;
			case 1: return "Segunda".$comp; break;
			case 2: return "Ter&ccedil;a"  .$comp; break;
			case 3: return "Quarta" .$comp; break;
			case 4: return "Quinta" .$comp; break;
			case 5: return "Sexta"  .$comp; break;
			case 6: return "S&aacute;bado";        break;
		}
	}
	 
	static function mesExtenso($mes, $limiteNroCaracteres = false){

		if ($mes[0]=="0") $mes = $mes[1];

		$vMes = WDate::$mesExtenso;

		if ($limiteNroCaracteres) {
			return substr($vMes[$mes],0,$limiteNroCaracteres);
		} else {
			return $vMes[$mes];
		}

	}
	 
	static function dataExtenso($data){
		$temp = explode("/",$data);
		if ($temp[1][0]==0) {
			$temp[1] = $temp[1][1];
		}
		return $temp[0]." de ".WDate::$mesExtenso[$temp[1]]." de ".$temp[2];
	}
	 
	static function formatHora($hora, $segundos=false){
		$aux = explode(":",$hora);
		if ($aux[0]>0) {
			$str = $aux[0]."h ";
		}
		if($aux[1]>0) {
			$str .= $aux[1]."min ";
		}
		if($aux[2]>0) {
			$str .= $aux[2]."seg";
		}
		return trim($str);
	}
	 
	static function getData($timestamp) {
		return substr($timestamp,0,10);
	}
	 
	static function getHora($timestamp) {
		return substr($timestamp,11,5);
	}
	 
	static function format($dataOuTimestamp, $comAno = true, $separadorData = "/", $comHora = true) {
		if ($dataOuTimestamp) {
			$data = strpos($dataOuTimestamp," ") === false ? $dataOuTimestamp : substr($dataOuTimestamp,0,strpos($dataOuTimestamp," "));
			$hora = (strpos($dataOuTimestamp," ") === false or (!$comHora)) ? "" : substr($dataOuTimestamp,strpos($dataOuTimestamp," ")+1);
			 
			if (strpos($data,"-") == 4) { // � YYYY-MM-DD
				// Y-m-d  ---> d/m/Y , d/m
				$vetTime = explode("-",$data);
				krsort($vetTime);
				if (!($comAno)) {
					unset($vetTime[count($vetTime)]);
				}
				$data = implode($separadorData,$vetTime);
			} else {
				// d/m/Y  ---> Y-m-d
				$vetTime = explode("/",$data);
				krsort($vetTime);
				$data = implode("-",$vetTime);
			}
			 
			if ($hora) {
				$data .= " ".$hora;
			}

			return $data;
			 
		} else return "";
	}
	 
	function formatMesDiaAno($dataYMD) {
		if ($dataYMD) {
			$vetTime = explode("-",$dataYMD);
			return WDate::mesExtenso($vetTime[1]) ." ". $vetTime[2] .", ". $vetTime[0];
		}
	}

	static function diferencaHoras($data1,$data2) {
		$data1 = explode(" ",$data1);
		$vetdata1 = explode("-",$data1[0]);
		$vethora1 = explode(":",$data1[1]);

		$data2 = explode(" ",$data2);
		$vetdata2 = explode("-",$data2[0]);
		$vethora2 = explode(":",$data2[1]);

		$data_inicial = mktime($vethora1[0], $vethora1[1], $vethora1[2],$vetdata1[1], $vetdata1[2], $vetdata1[0]); // converte tudo em segundos
		$data_final   = mktime($vethora2[0], $vethora2[1], $vethora2[2],$vetdata2[1], $vetdata2[2], $vetdata2[0]);
		$tempo_unix   = $data_final - $data_inicial; // Acha a diferen�a em segundos
		$nro_horas  = floor($tempo_unix /(60*60)); // Converte em horas 60(minutos) 60(segundos)
		return $nro_horas;
	}

	static function diferencaDias($data1,$data2) {
		$vetdata1 = explode("-",$data1);
		$vetdata2 = explode("-",$data2);
		// mes             dia          ano
		$data_inicial = mktime(null,null,null,$vetdata1[1], $vetdata1[2], $vetdata1[0]); // converte tudo em segundos
		$data_final   = mktime(null,null,null,$vetdata2[1], $vetdata2[2], $vetdata2[0]);
		$tempo_unix   = $data_final - $data_inicial; // Acha a diferen�a em segundos
		$nro_dias  = floor($tempo_unix /(24*60*60)); // Converte em dias 24(horas) 60(minutos) 60(segundos)
		return $nro_dias;
	}

	static function diferencaAnos($data, $dataBase = '') {
		if($dataBase == '')
		$dataBase = date("Y-m-d");

		$data = explode("-", $data);
		$dataBase = explode("-", $dataBase);

		$anos = $dataBase[0] - $data[0];

		if($dataBase[1] < $data[1] || ($dataBase[1] == $data[1] && $dataBase[2] < $data[2])) {
			$anos--;
		}
		return $anos;
	}

	static function somaDias($dataYMD, $dias){
		$data = explode("-",$dataYMD);
		return date("Y-m-d",mktime(0,0,0,$data[1],$dias+$data[2],$data[0]));
	}

}

?>