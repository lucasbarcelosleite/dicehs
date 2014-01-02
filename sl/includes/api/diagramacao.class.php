<?

class Diagramacao {
	 
	var $texto = null;
	var $html = null;
	var $vImage = null;
	var $vFile = null;
	var $diretorio = null;
	 
	function __construct($texto, $image, $vFile, $diretorio="") {
		$this->Diagramacao($texto, $image, $vFile, $diretorio);
	}
	 
	function Diagramacao($texto, $vImage, $vFile, $diretorio="") {
		$this->vImage = $vImage;
		$this->vFile  = $vFile;
		$this->texto  = $texto;
		$this->diretorio = $diretorio;
	}
	 
	function setImageMarks() {
		$this->texto = str_replace('<img style="float: right;" src="images/mark-image.gif" alt="" />', '[img_r]', $this->texto);
		$this->texto = str_replace('<img style="float: left;" src="images/mark-image.gif" alt="" />', '[img_l]', $this->texto);
		$this->texto = str_replace('<p style="text-align: center;"><img src="images/mark-image.gif" alt="" /></p>', '[img_c]', $this->texto);
		$this->texto = str_replace('<img src="images/mark-image.gif" alt="" />', '[img_l]', $this->texto);
		$this->texto .= '<br class="clr" />';

		if (strpos($this->texto, "[img_")===false) {
			$this->texto = "[img_l]" . $this->texto;
		}
	}
	 
	function getImageHtml($imagem, $align, $lightbox=true) {

		if (WFile::existe($imagem["arquivo"], $this->diretorio)) {

			list($width, $height) = WFile::dimensoes($imagem["arquivo"], $this->diretorio);
			 
			$tpl = new WTemplate(WPath::tpl("imagem"));

			$tpl->align  = $align;
			$tpl->class  = $width > $height ? 1 : 2;
			$tpl->width  = $width;
			$tpl->imagem = WPath::arquivo($imagem["arquivo"], $this->diretorio);
			if($lightbox){
				$tpl->imagem_grande = WPath::arquivo("original_".$imagem["arquivo"], $this->diretorio);
				$tpl->parseBlock("IMG_LIGHTBOX");
			}else{
				$tpl->parseBlock("IMG");
			}
			$tpl->descricao = $imagem["descricao"];

			return $tpl->getContent();
		}
	}
	 
	function addImages() {

		$vAlign["l"] = "left";
		$vAlign["r"] = "right";
		$vAlign["c"] = "center";

		$i = 0;
		while (($posicao = strpos($this->texto, "[img_"))!==false) {
			if(strpos(substr($this->texto, $posicao, 12), "</a>")!=0){
				$this->texto = substr_replace($this->texto, $this->getImageHtml($this->vImage[$i], $vAlign[substr($this->texto, $posicao+5, 1)], false), $posicao, 7);
			}else{
				$this->texto = substr_replace($this->texto, $this->getImageHtml($this->vImage[$i], $vAlign[substr($this->texto, $posicao+5, 1)]), $posicao, 7);
			}
			$i++;
		}

		$this->html .= $this->texto;
	}
	 
	function addFiles() {

		if (count($this->vFile)) {
			 
			//$tpl = new WTemplate(WPath::tpl("arquivo"));
			 
			foreach ($this->vFile as $file) {
				$b = 'href="#arquivo';
				$pi = strpos($this->texto,$b);
				$bt = strlen($b);
				if($pi>0){
					$this->texto = substr($this->texto,0,$pi).'href="'.WPath::arquivo($file["arquivo"], $this->diretorio).substr($this->texto,$pi+$bt);
					//$this->texto = substr($this->texto,0,$pi);
					//$this->texto = str_replace('href="#arquivo','href="#'.WPath::arquivo($file["arquivo"], $this->diretorio),$this->texto,1);
				}
			}
			$this->html = $this->texto;
		}
	}
	 
	function getHtml() {

		$this->setImageMarks();
		$this->addImages();
		$this->addFiles();

		return $this->html;
	}
	 
	function show() {
		echo $this->getHtml();
	}

}

?>