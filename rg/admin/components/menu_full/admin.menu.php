<?php

persiste("cid[]");

$objPai = false;
$classe = persiste("classe");

persiste("voltar_cp");
persiste("voltar_id");

if ($classe) {
	$objPai = new $classe();
	$objPai->load(pega("classe_id"));
	manipulaVar($objPai->_tbl_key,pega("classe_id"));
}

class MenuController extends AdminController {

	public $pai;
	 
	function __construct(&$obj, &$objPai) {
		$this->pai = $objPai;
		if($this->pai){
			$cp = $this->pai->_tbl_default_descricao;
			$this->subtitulo = $this->pai->$cp;
		}
		$this->setUpload();
		parent::__construct($obj);
	}

	function removerLang() {
		foreach ($_REQUEST["cid_lang"] as $cid){
			$cache = new WCache("lista_menu_admin".$cid);
			$cache->clear();
		}
		if (!count($this->cid)) {
			mostraErro("Selecione pelo menos um registro para excluir!");
			exit;
		}
		foreach ($this->cid as $id_menu){
			$this->obj->deletaComFilhos($id_menu);
		}
		WGrid::reload();
	}

	function flag(){
		$cache = new WCache("lista_menu_admin".WLang::$lang->id_lang);
		$cache->clear();
		parent::flag();
	}

	function listar() {
		$this->setListVars();
		$menus = $this->obj->montaMenuListaAdmin(WLang::$adminListMain);
		$menus = array_filter($menus, 'filtro');
		$total = count($menus);
		if ($this->limit) {
			$rows = array_slice($menus, $this->offset, $this->limit);
		} else {
			$rows = $menus;
		}
		require WPath::adminList();
	}

	function redirectJs($task, $linkExtra="") {
		if (pega("tpl")=="painel") {
			echo "parent.window.preencheArvore(".$this->obj->parent.",true);";
			echo "document.location.href='index.php?option=".pega("voltar_cp")."&Adminid=".pega("voltar_id").$linkExtra."'; ";
		} else {
			echo "document.location.href='index.php?option=".WMain::$option."&task=".($task ? $task : $this->task).$linkExtra."'; ";
		}
	}

	function adicionarImagem($nome) {

		$menu = new Menu();
		$menu->load($this->obj->parent);

		if(strpos($menu->link,'home_interna') === false){
			 
			$nomeArquivo = uniqid().".jpg";
				
			$th = new dThumbMaker($_FILES[$nome]["tmp_name"]);
			$th->resizeMaxSize(90,90);
			$th->build(WPath::arquivoRoot("thumb_".$nomeArquivo),"jpeg");

			$th = new dThumbMaker($_FILES[$nome]["tmp_name"]);
			$th->resizeMaxSize(50,50);
			$th->cropCenter(50,50);
			$th->build(WPath::arquivoRoot("lateral_".$nomeArquivo),"jpeg");
				
			$th = new dThumbMaker($_FILES[$nome]["tmp_name"]);
			$th->resizeMaxSize(90);
			$th->cropCenter(90,65);
			$th->build(WPath::arquivoRoot("menu_".$nomeArquivo),"jpeg");

			$th = new dThumbMaker($_FILES[$nome]["tmp_name"]);
			$th->build(WPath::arquivoRoot($nomeArquivo),"jpeg");

			return $nomeArquivo;
		} else {
			return $this->adicionarArquivo($nome);
		}

	}

	function adicionarArquivo($nome) {
		$nomeArquivo = "menu_".WFormat::nomePadrao("html",$_FILES[$nome]["name"]);

		if (file_exists(WPath::arquivoRoot($nomeArquivo,"menu"))) {
			$nomeArquivo = time().WFile::extensao($nomeArquivo);
		}
		if (copy($_FILES[$nome]["tmp_name"], WPath::arquivoRoot($nomeArquivo,"menu"))) {
			return $nomeArquivo;
		}
	}

	function beforeCheck() {

		if (pega('link_tipo')=='N'){
			$this->obj->id_conteudo = "";
		}

		if ($this->obj->id_conteudo) {
			$this->obj->link = "index.php?option=conteudo";
		}

		if (!$this->obj->parent) {
			$this->obj->parent = 0;
		}
	}
	 
	function afterStore() {
		$seoMenu = new SeoMenu();
		$seoMenu->loadBy("id_menu", $this->obj->id_menu);
		 
		if (pega("page_title") or pega("meta_description") or pega("meta_keywords")) {
			$seoMenu->bind($_POST);
			$seoMenu->id_menu = $this->obj->id_menu;
			$seoMenu->store();
		} else {
			$seoMenu->delete();
		}
	}
}

new MenuController(new Menu(), $objPai);

$menusPai = array();
function filtro( $menu ){
	global $menusPai;
	if ($search = pega("search")) {
		$retorno = ((strpos(WFormat::toLower(WFormat::removeAcentos($menu->titulo)), WFormat::toLower(WFormat::removeAcentos($search)))!==false)or(isset($menusPai[$menu->parent])));
		if($retorno){
			$menusPai[$menu->id_menu] = true;
		}
		return $retorno;
	}
	return true;
}

?>