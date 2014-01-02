<?php

class WGridColuna{

	public $label;
	public $align = "left";
	public $search = true;
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

	private $is_ordering  = false;
	private $ordering_max = 0;

	private $is_flag = false;
	private $is_flag_unica = false;
	private $flagStatus = array();
	private $flagImages = array("publish_x.png","publish_g.png");

	function __construct($label, $campo = "") {
		$this->WGridColuna($label,$campo);
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

	function WGridColuna($label, $campo = "") {
		$this->label = $label;
		$this->campo = $campo;
		/*
		 if (strpos($this->campo,'->')) {
		 $this->search = false;
		 $this->ordem  = false;
		 }*/
	}

	function getValor($id, $row, $campo, $valor, $dataOrdem=array()) {

		$this->campo = $campo;

		if ($this->funcao) {
			$valor = chamaFuncao($this->funcao,array_merge(array($valor),$this->funcaoParametros));
		}

		if ($this->funcaoObj) {
			$valor = chamaFuncao($this->funcaoObj,array($row));
		}

		if ($this->is_link) {
			$valor = chamaFuncao("WGrid::montaLink",array($this->vLink, $row));
		}

		if ($this->is_flag) {
			$valor = "<a class='flag' href='javascript:clickFlag(\"".$id."\",\"".$this->campo."\",\"".$this->flagStatus[$valor]."\", ".($this->is_flag_unica ? 1 : 0).");'><img src='".WPath::img($this->flagImages[$valor])."' /></a>";
		}

		if ($this->is_image and $valor) {
			if (WFile::existe('thumb_'.$valor)) {
				$valor = '<img src="'.WPath::arquivo('thumb_'.$valor).'" />';
			} elseif (WFile::existe($valor)) {
				$valor = '<img src="'.WPath::arquivo($valor).'" />';
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

			$ret = "<div style='width:20px; float:left;'>";

			if(($i>0)&&(!$wo_isp)) {
				$ret .= "<a class='flag' href='javascript:clickOrdering(\"".$id."\",\"".$wordem."\",\"-1\");'><img src='".WPath::img("uparrow.png")."' width=\"16\" height=\"16\" /></a>";
			}

			$ret .= " </div><div style='width:20px; float:left;'>";

			if(($i+1<$this->ordering_max)&&(!$wo_isu)) {
				$ret .= "<a class='flag' href='javascript:clickOrdering(\"".$id."\",\"".$wordem."\",\"1\");'><img src='".WPath::img("downarrow.png")."' width=\"16\" height=\"16\" /></a>";
			}

			if ($this->orderingEdit) {
				$ret .= "</div> &nbsp; <input type='text' value='".$valor."' size='1' name='cp_ord[]' class='input-ordering'>";
				if ($wordem) {
					$ret .= "<input type='hidden' value='".$wordem."' size='1' name='cp_wordem[]'>";
				}
			}

			$ret .= "<br clear='left'>";
			$valor = $ret;
		}

		$valor = WFormat::htmlButTags($valor);

		return $valor;
	}

	function setOrdering($ordering_max){
		$this->is_ordering = true;
		$this->search = false;
		$this->ordering_max = $ordering_max;
	}

	function ajustaTamanhoColuna() {
		if (!($this->largura)) {
			if ($this->is_flag) {
				$this->largura = 65;
			} elseif ($this->is_ordering) {
				$this->largura = 110;
			} elseif ($this->is_image) {
				$this->largura = 100;
			} elseif ($this->is_link) {
				$this->largura = 90;
			} elseif ($this->is_data) {
				$this->largura = 70;
			} else {
				$this->largura = 180;
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

	function setImage() {
		$this->is_image = true;
		$this->search = false;
	}

	function setData() {
		$this->is_data = true;
		$this->search  = false;
		$this->setFuncao("WDate::inverte");
	}

	function setLink($link, $img="", $alt="", $condicao="") {
		$this->is_link = true;
		$this->ordem   = false;
		$this->search  = false;
		$this->align   = 'center';
		 
		$this->vLink = array($link, $img, $alt, $condicao);
	}

	function setFlagUnica($vStatus="", $vImages=array("publish_x.png","publish_g.png")) {
		$this->setFlag(true, $vStatus, $vImages);
	}

	function setFlag($isUnica=false, $vStatus="", $vImages=array("publish_x.png","publish_g.png")) {
		$this->is_flag_unica = $isUnica;
		$this->is_flag = true;
		$this->search = false;
		$this->align = "center";
		if ($vStatus == "") {
			$vStatus = array(0=>1,1=>0);
		}
		$this->flagImages = $vImages;
		$this->flagStatus = $vStatus;
	}

}

class WGrid {

	public $campos = array();
	public $dados  = array();
	public $rows   = array();

	public $id = null;
	public $obj = null;

	public $campoOrdemPadrao = "";
	public $ordemPadrao = "asc";
	public $campoWordem = "";
	public $wordem = "asc";
	public $wordemData = array();
	public $is_ordering = false;

	public $url = "";
	public $totalItens = 0;
	public $isResultAdmin = false;
	public $doubleClick = true;
	public $is_lang = false;
	public $is_lang_hide = false;

	function WGrid($campos=array(), $dados=array(), $url="", $chave=false) {
		$this->campos = $campos;
		$this->dados = $dados;
		$this->url = $url;
		$this->setUrlAdmin();
		$this->persiste($chave);
	}

	function persiste($chave=false){
		if($chave==false){
			$chave = WMain::$option.WMain::$Itemid;
		}
		persiste("page",$chave);
		persiste("qtype",$chave);
		persiste("query",$chave);
		persiste("rp","main");
		persiste("sortname",$chave);
		persiste("sortorder",$chave);
	}

	function setUrlAdmin($taskResult="lista") {
		$this->isResultAdmin = (WMain::$task==$taskResult);
		$this->url = "index_ajax.php?option=".WMain::$option."&task=".$taskResult."&Adminid=".WMain::$Adminid;
	}

	function setObj(&$obj) {
		$this->obj = $obj;
		$this->id = $this->obj->_tbl_key;
		if(Lang::objIsLang($obj)){
			$this->is_lang = true;
			$this->iniLang();
		}
		$auxOrd = explode(",",$this->obj->_tbl_default_ordem);
		$auxOrd = explode(" ",$auxOrd[0]);
		$this->ordemPadrao(strtolower($auxOrd[0]),(isset($auxOrd[1]))?strtolower($auxOrd[1]):"asc");
	}

	function iniLang(){
		$this->is_lang = true;

		$col = new WGridColuna("Editar","lang_editar");
		$col->largura = 25*count(WLang::$lang_rows);
		$col->setFuncaoObj("WBandeira::editar");
		$col->align = "center";
		$col->ordem = false;
		$col->search = false;
		$this->add($col);

		$col = new WGridColuna("#","id_lang");
		$col->largura = 25;
		$col->setFuncaoObj("WBandeira::atual");
		$col->align = "center";
		$col->search = false;
		$this->add($col);
	}

	function fimLang(){
		if ($this->is_lang and count(WLang::$lang_rows)>1) {
			$col = new WGridColuna("Traduzir","lang_traduzir");
			$col->largura = ((count(WLang::$lang_rows)-1)==1?35:25*(count(WLang::$lang_rows)-1));
			$col->setFuncaoObj("WBandeira::traduzir");
			$col->align = "center";
			$col->ordem = false;
			$col->search = false;
			$col->hide = $this->is_lang_hide;
			$this->add($col);
		}
	}

	function hideLinguagens(){
		$this->is_lang_hide = true;
		if($this->is_lang){
			$this->campos["lang_editar"]->hide = true;
			$this->campos["id_lang"]->hide = true;
		}
	}

	function autoLista($rows, $total) {

		$this->fimLang();
		$this->rows = $rows;
		$cam = $this->id;

		if (count($rows)) {
			foreach ($rows as $i => $row) {

				$this->dados[$i]["id"]  = $row->$cam;
				foreach ($this->campos as $field => $objGridColuna) {
					$this->dados[$i][$field] = $this->trataCampo($row,$field);
				}

				if ($this->campoWordem) {
					$this->wordemData[$i] = $row;
				}
			}
			$this->totalItens = $total;
		}
	}

	function trataCampo(&$row,$field){
		$aux = explode("->",$field);
		if(count($aux)>1){
			$obj = $aux[0];
			$campo = $aux[1];
			$obj2 = $row->$obj;
			return $obj2->$campo;
		}
		return $row->$field;
	}

	function add($col){
		$this->campos[$col->campo] = $col;
	}

	function ordemPadrao($campo, $ordem="asc") {
		$this->campoOrdemPadrao = $campo;
		$this->ordemPadrao = $ordem;
	}

	function ordering($wordem="asc") {
		$this->ordemPadrao = "asc";
		$this->campoOrdemPadrao = "ordering";
		$this->is_ordering = true;
		$this->wordem = $wordem;
		$this->campoWordem = $this->obj->_wordem;
	}

	function reload() {
		echo "wgrid.populate();";
	}

	function showXML() {
		global $mosConfig_live_site, $mosConfig_absolute_path, $search;

		/*
		 header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
		 header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" );
		 header("Cache-Control: no-cache, must-revalidate" );
		 header("Pragma: no-cache" );
		 header("Content-type: text/xml");
		 $xml = "<?xml version=\"1.0\" encoding=\"utf-8\">\n";
		 */
		$xml = "";
		$xml .= "<rows>";
		$xml .= "<page>".$_REQUEST['page']."</page>";
		$xml .= "<total>".$this->totalItens."</total>";

		if ($this->is_ordering) {
			$this->campos[$this->campoOrdemPadrao]->setOrdering($this->totalItens);
		}
		foreach ($this->dados as $i => $linha) {

			$xml .= "<row id=\"".$linha['id']."\"> \n";

			foreach ($linha as $campo => $valor) {
				if ($campo!='id') {

					$wo_isp = $wo_isu = true;

					if ($this->campoWordem) {
						$valWordem = WModel::getSQLWordem($this->campoWordem, $this->wordemData[$i]);

						if ($this->verificaWordem($i, '>')) {
							$wo_isu = false;
						}
						if ($this->verificaWordem($i, '<')) {
							$wo_isp = false;
						}
					} else {
						$wo_isp = $wo_isu = false;
						$valWordem = "";
					}
					$xml .= "<cell><![CDATA[".$this->campos[$campo]->getValor($linha['id'],$this->rows[$i],$campo,$valor,array($i,$valWordem,$wo_isp,$wo_isu))."]]></cell> \n";
				}
			}
			$xml .= "</row>";
		}

		$xml .= "</rows>";
		echo $xml;
	}

	function verificaWordem($i, $sinal) {

		if(is_array($this->campoWordem)){
			$cod = "";
			foreach ($this->campoWordem as $wo){
				$cod .= (($cod)?' && ':'').'($this->wordemData[$i]->'.$wo.'=="'.$this->wordemData[$i]->$wo.'")';
			}
			$cod = '$b_cond = ('.$cod.');';
		}
		else{
			$wo = $this->campoWordem;
			$cod = '$b_cond = ($this->wordemData[$i]->'.$wo.'=="'.$this->wordemData[$i]->$wo.'");';
		}
		while ($i>=0 and $i<count($this->dados)) {

			($sinal=='>') ? $i++ : $i--;
			eval($cod);
			if ($b_cond) {
				return true;
			}
		}

		return false;
	}

	function montaLink($vLink, $row) {
		$condicao = $vLink['3'] ? chamaFuncao($vLink['3'], array($row)) : true;

		if ($condicao) {
			while (($pos = strpos($vLink['0'], "{"))!==false) {
				$campo = substr($vLink['0'], $pos+1, strpos($vLink['0'], "}")-$pos-1);
				$vLink['0'] = str_replace("{".$campo."}", $row->$campo, $vLink['0']);
			}

			return '<a href="'.$vLink['0'].'" title="'.$vLink['2'].'"><img src="'.WPath::img($vLink['1'] ? $vLink['1'] : 'copy_f2.png').'" border="0" alt="'.$vLink['2'].'"></a>';
		}
	}

	function showHTML() {
		$this->fimLang();

		$busca  = array();
		$campos = array();

		if ($this->is_ordering) {
			$this->campos[$this->campoOrdemPadrao]->setOrdering($this->totalItens);
		}

		foreach ($this->campos as $cp=>$obj) {
			$campos[] = "{display: '".$obj->label."', name : '".$cp."', width : ".$obj->width.", sortable : ".((($obj->ordem) and (!($this->is_ordering)))?' true ':' false ').", align: '".$obj->align."', hide:".(($obj->hide)?' true ':' false ')."}";

			if($obj->search) {
				$busca[] = "{display: '".$obj->label."', name : '".$cp."', isdefault: true}";
			}
		}

		if ($this->campoWordem) {
			$wo = ((is_array($this->campoWordem))?implode(" ".$this->wordem.", ",$this->campoWordem):$this->campoWordem)." ".$this->wordem;
			$ordenacao = $wo.", ".$this->campoOrdemPadrao;
		} else {
			$ordenacao = $this->campoOrdemPadrao;
		}
		echo '
    <form action="index_ajax.php" method="GET" name="adminForm" id="adminFormList">
        <input type="hidden" name="option" id="option" value="'.WMain::$option.'" />
        <input type="hidden" name="Adminid" id="adminid" value="'.WMain::$Adminid.'" />
        <input type="hidden" name="task" id="task" value="'.WMain::$task.'" />
        <input type="hidden" name="is_lang" id="is_lang" value="'.$this->is_lang.'" />
        <table id="flex1"></table>
    </form>
    <script type="text/javascript">

       var task = "'.WMain::$task.'";

        $(document).ready(function(){

           '.($this->doubleClick ? "" : "wgrid_dbl = null;").'

           $("#flex1").flexigrid({
                    url: \''.$this->url.'&is_grid=true\',
                    dataType: \'xml\',
                    colModel : ['.implode(",",$campos).'],
                    searchitems : ['.implode(",",$busca).'],
                    sortname: "'.pega("sortname",$ordenacao).'",
                    sortorder: "'.pega("sortorder",$this->ordemPadrao).'",
                    usepager: true,
                    title: false,
                    useRp: true,
                    rp: '.pega("rp",15).',
                    page: '.pega("page",1).',
                    showTableToggleBtn: true,
                    height: screen.availHeight - 528,
                    query: "'.pega("query").'",
                    qtype: "'.pega("qtype").'"
            });

        });
   </script>
   ';
	}

	function showAdmin() {
		$this->show($this->isResultAdmin);
	}

	function show($result=false) {
		if($result) $this->showXML();
		else        $this->showHTML();
	}

}

class WBandeira {

	static function editar($obj){
		$html = '';
		foreach (WLang::$lang_rows as $lang){
			$pl = "lang_".$lang->id_lang;
			$alt = "Editar";
			if($obj->$pl){
				$html .= '<a href="index.php?option='.WMain::$option.'&task=edit&Adminid='.WMain::$Adminid.'&cid[]='.$obj->id_main.'&tid_lang='.$lang->id_lang.'" title="'.$alt.' - '.$lang->nome.'"><img src="'.WPath::arquivo($lang->imagem,"lang").'" title="'.$alt.' - '.$lang->nome.'" alt="'.$alt.' - '.$lang->nome.'" /></a>&nbsp;';
			}

		}
		return $html;
	}

	static function traduzir($obj){
		$html = '';
		foreach (WLang::$lang_rows as $lang){
			$pl = "lang_".$lang->id_lang;
			$alt = "Traduzir";
			if(!$obj->$pl){
				$html .= '<a href="index.php?option='.WMain::$option.'&task=edit&Adminid='.WMain::$Adminid.'&cid[]='.$obj->id_main.'&tid_lang='.$lang->id_lang.'" title="'.$alt.' - '.$lang->nome.'"'.$class.'><img src="'.WPath::arquivo($lang->imagem,"lang").'" title="'.$alt.' - '.$lang->nome.'" alt="'.$alt.' - '.$lang->nome.'" /></a>&nbsp;';
			}
		}
		return $html;
	}

	function atual($obj){
		$html = '';
		foreach (WLang::$lang_rows as $lang){
			if($lang->id_lang==$obj->id_lang){
				$html .= '<input type="hidden" class="id_main" value="'.$obj->id_main.'"><a href="index.php?option='.WMain::$option.'&task=edit&Adminid='.WMain::$Adminid.'&cid[]='.$obj->id_main.'&tid_lang='.$lang->id_lang.'" title="'.$alt.' - '.$lang->nome.'"'.$class.'><img src="'.WPath::arquivo($lang->imagem,"lang").'" title="'.$alt.' - '.$lang->nome.'" alt="'.$alt.' - '.$lang->nome.'" /></a>&nbsp;';
			}
		}
		return $html;
	}

}
?>