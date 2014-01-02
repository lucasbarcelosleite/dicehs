<?php

class WAdminListaColuna{

	public $label;
	public $align = "left";
	public $ordem = true;
	public $campo = "";
	public $hide = false;

	public $largura = 0;

	public $orderingEdit = true;

	private $funcao = null;
	private $funcaoParametros = array();
	private $funcaoObj = null;

	public  $is_link = false;
	public  $vLink   = array();

	public  $is_data  = false;

	public  $is_image = false;
	public  $imageFolder = false;
	public  $prefixoThumb = false;

	public $is_ordering  = false;

	private $is_flag = false;
	private $is_flag_unica = false;
	private $flagStatus = array();
	private $flagImages = array("publish_x.png","publish_g.png");

	function __construct($label, $campo = "") {
		$this->WAdminListaColuna($label,$campo);
	}

	function __set($var,$value) {
		if ($var == "width") {
			$this->largura = $value;
		}
	}

	function __get($var) {
		switch ($var) {
			case "width":
				$this->ajustaTamanhoColuna();
				return $this->largura;
				break;
		}
	}

	function WAdminListaColuna($label, $campo = "") {
		$this->label = $label;
		$this->campo = $campo;

		/*
		 if (strpos($this->campo,'->')) {
		 $this->ordem  = false;
		 }*/
	}

	function getValor($id, $row, $totalRows, $campo, $valor, $dataOrdem=array()) {

		$this->campo = $campo;

		if ($this->funcao) {
			$valor = chamaFuncao($this->funcao,array_merge(array($valor),$this->funcaoParametros));
		}

		if ($this->funcaoObj) {
			$valor = chamaFuncao($this->funcaoObj,array($row));
		}

		if ($this->is_link) {
			$valor = chamaFuncao("WAdminLista::montaLink",array($this->vLink, $row));
		}

		if ($this->is_flag) {
			$valor = '<a class="flag" href="index.php?option='.WMain::$option.'&task='.($this->is_flag_unica ? 'flag_unica' : 'flag').'&campo='.$this->campo.'&valor='.$this->flagStatus[$valor].'&cid[]='.$id.'" ><img src="'.WPath::img($this->flagImages[$valor]).'" /></a>';
		}

		if ($this->is_image and $valor) {
			if (WFile::existe($this->prefixoThumb.$valor, $this->imageFolder)) {
				$valor = '<img src="'.WPath::arquivo($this->prefixoThumb.$valor, $this->imageFolder).'" />';
			} elseif (WFile::existe($valor)) {
				$valor = '<img src="'.WPath::arquivo($valor, $this->imageFolder).'" />';
			} else {
				$valor = '';
			}
		}

		if ($this->is_ordering) {

			$i = $dataOrdem[0];
			if(is_array($dataOrdem[1])){
				$wordem = urlencode(implode(",",$dataOrdem[1]));
			}
			else {
				$wordem = urlencode($dataOrdem[1]);
			}

			$wo_isp = $dataOrdem[2];
			$wo_isu = $dataOrdem[3];

			$ret = '<div class="ordem">
            		  <span>';

			if(($i>0)&&(!$wo_isp)) {
				$ret .= "<a class='flag' href='index.php?option=".WMain::$option."&task=ordering&cid[]=".$id."&wordem=".$wordem."&valor=-1'><img src='".WPath::img("uparrow.png")."' width=\"16\" height=\"16\" /></a>";
			} else {
				$ret .= "&nbsp;";
			}

			$ret .= " </span>
            		  <span>";

			if(($i+1<$totalRows)&&(!$wo_isu)) {
				$ret .= "<a class='flag' href='index.php?option=".WMain::$option."&task=ordering&cid[]=".$id."&wordem=".$wordem."&valor=1'><img src='".WPath::img("downarrow.png")."' width=\"16\" height=\"16\" /></a>";
			} else {
				$ret .= "&nbsp;";
			}

			$ret .= '</span>';

			if ($this->orderingEdit) {
				$ret .= "&nbsp; <input type='text' value='".$valor."' size='1' name='cp_ord[]' class='input-ordering'>";

				if ($wordem) {
					$ret .= "<input type='hidden' value='".$wordem."' size='1' name='cp_wordem[]'>";
				}
			}
			 
			$ret .= "<br clear='left'>";
			$ret .= '</div>';
			$valor = $ret;
		}

		$valor = WFormat::htmlButTags($valor);

		return $valor;
	}

	function ajustaTamanhoColuna() {
		if (!($this->largura)) {
			if ($this->is_flag) {
				$this->largura = 65;
			} elseif ($this->is_ordering) {
				$this->largura = 90;
			} elseif ($this->is_image) {
				$this->largura = 100;
			} elseif ($this->is_link) {
				$this->largura = 90;
			} elseif ($this->is_data) {
				$this->largura = 70;
			}
		}
	}

	function setFuncao($parametrosAdicionais=array()) {
		$vetParametros = func_get_args();
		$funcao = $vetParametros[0];
		array_shift($vetParametros);

		$this->funcao = $funcao;
		$this->funcaoParametros = $vetParametros;
	}

	function setFuncaoObj($funcao) {
		$this->funcaoObj = $funcao;
	}

	function setImage($folder='', $prefixo="thumb_") {
		$this->is_image = true;
		$this->imageFolder = $folder;
		$this->prefixoThumb = $prefixo;
	}

	function setOrdering() {
		$this->is_ordering = true;
	}

	function setData() {
		$this->is_data = true;
		$this->align = 'center';
		$this->setFuncao("WDate::format");
	}

	function setLink($link, $img="", $alt="", $condicao="") {
		$this->is_link = true;
		$this->ordem   = false;
		$this->align   = 'center';		 
		$this->vLink = array($link, $img, $alt, $condicao);
	}

	function setFlagUnica($vStatus="", $vImages=array("publish_x.png","publish_g.png")) {
		$this->setFlag(true, $vStatus, $vImages);
	}

	function setFlag($isUnica=false, $vStatus="", $vImages=array("publish_x.png","publish_g.png")) {
		$this->is_flag_unica = $isUnica;
		$this->is_flag = true;
		$this->align = "center";
		if ($vStatus == "") {
			$vStatus = array(0=>1,1=>0);
		}
		$this->flagImages = $vImages;
		$this->flagStatus = $vStatus;
	}

}

?>