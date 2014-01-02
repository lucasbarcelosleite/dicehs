<?php

class RankingController extends AdminController {

	function __construct(&$obj) {
		$this->setUpload("imagem", "adicionarImagem");
		parent::__construct($obj);
	}

	function listar($where = "") {
		$aLiga = $this->obj->join("left", new Liga());
	
		$this->vSearch[] = $this->obj->_tbl_alias.".chamada";
		$this->vSearch[] = $this->obj->_tbl_alias.".data";
		$this->vSearch[] = $this->obj->_tbl_alias.".rodada";
		$this->vSearch[] = $aLiga.".nome";
	
		$where = $this->setListVars($where);
		$total = $this->obj->selectCount($where);
		$rows  = $this->obj->select($where, $this->sort, $this->limit, $this->offset);
		
		require WPath::adminList();
	}	
	 
	function adicionarImagem($nome) {
		$nomeArquivo = uniqid().".jpg";
		
		$th = new dThumbMaker($_FILES[$nome]["tmp_name"]);
		$th->resizeMinSize(280,179);
		$th->cropCenter(280,179);
		$th->build(WPath::arquivoRoot("home_".$nomeArquivo),"jpeg");

		$th = new dThumbMaker($_FILES[$nome]["tmp_name"]);
		$th->resizeMinSize(120,77);
		$th->cropCenter(120,77);
		$th->build(WPath::arquivoRoot("thumb_".$nomeArquivo),"jpeg");
		
		copy($_FILES[$nome]["tmp_name"],WPath::arquivoRoot($nomeArquivo));
	
		return $nomeArquivo;
	}
}

$ranking = new Ranking();
new RankingController($ranking);

?>