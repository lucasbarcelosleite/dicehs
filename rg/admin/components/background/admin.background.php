<?php

class BackgroundController extends AdminController {

	function __construct(&$obj) {
		$this->setUpload("imagem", "adicionarImagem");
		parent::__construct($obj);
	}

	function listar($where = "") {
		$this->vSearch[] = $this->obj->_tbl_alias.".titulo";
		$where = $this->setListVars($where);
		$total = $this->obj->selectCount($where);
		$rows  = $this->obj->select($where, $this->sort, $this->limit, $this->offset);
		require WPath::adminList();
	}	
	 
	function adicionarImagem($nome) {
		$nomeArquivo = uniqid().".jpg";

		$th = new dThumbMaker($_FILES[$nome]["tmp_name"]);
		$th->resizeMinSize(100, 43);
		$th->cropCenter(100, 43);
		$th->build(WPath::arquivoRoot("thumb_".$nomeArquivo),"jpeg");

		copy($_FILES[$nome]["tmp_name"],WPath::arquivoRoot($nomeArquivo));
	
		return $nomeArquivo;
	}
}

$background = new Background();
new BackgroundController($background);

?>