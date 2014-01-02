<?php

$modelos = array(
	"1" => "Título centralizado",
	"2" => "Título a esquerda",
	"3"	=> "Título a direita"
);

class DestaqueController extends AdminController {

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
		
		copy($_FILES[$nome]["tmp_name"],WPath::arquivoRoot("home_".$nomeArquivo));
		
		$th = new dThumbMaker($_FILES[$nome]["tmp_name"]);
		$th->resizeMinSize(100, 43);
		$th->cropCenter(100, 43);
		$th->build(WPath::arquivoRoot("thumb_".$nomeArquivo),"jpeg");

		//copy($_FILES[$nome]["tmp_name"],WPath::arquivoRoot("home_".$nomeArquivo));
		copy($_FILES[$nome]["tmp_name"],WPath::arquivoRoot($nomeArquivo));
	
		return $nomeArquivo;
	}
}

$destaque = new Destaque();
new DestaqueController($destaque);

?>