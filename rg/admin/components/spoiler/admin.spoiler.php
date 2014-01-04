<?php

class SpoilerController extends AdminController {

	function __construct(&$obj) {
		$this->setUpload("imagem", "adicionarImagem");
		parent::__construct($obj);
	}

	function listar($where = "") {
		$aLiga = $this->obj->join("left", new Edicao());
	
		$this->vSearch[] = $this->obj->_tbl_alias.".texto";
		$this->vSearch[] = $aLiga.".nome";
		$this->vSearch[] = $aLiga.".sigla";
	
		$where = $this->setListVars($where);
		$total = $this->obj->selectCount($where);
		$rows  = $this->obj->select($where, $this->sort, $this->limit, $this->offset);
		
		require WPath::adminList();
	}	
	 
	function adicionarImagem($nome) {
		$nomeArquivo = uniqid().".jpg";
		
		$th = new dThumbMaker($_FILES[$nome]["tmp_name"]);
		$th->resizeMinSize(285);
		$th->crop(17, 41, 259, 195);
		$th->resizeExactSize(120,77);
		$th->build(WPath::arquivoRoot("thumb_".$nomeArquivo),"jpeg");
		
		copy($_FILES[$nome]["tmp_name"],WPath::arquivoRoot($nomeArquivo));
	
		return $nomeArquivo;
	}
}

$spoiler = new Spoiler();
new SpoilerController($spoiler);

?>