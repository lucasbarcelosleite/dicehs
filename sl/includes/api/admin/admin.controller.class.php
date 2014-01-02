<?

persiste('Adminid');

class AdminController {

	var $obj     = null;
	var $cid     = null;
	var $task    = null;
	var $sort    = null;
	var $limit   = null;
	var $offset  = null;
	var $Adminid = null;
	var $ui      = null;
	var $db      = null;
	var $vUpload = array();
	var $vTask   = array();
	var $vSearch = array();
	 
	var $subtitulo = null;
	 
	function __construct($obj) {
		global $database, $Adminid;

		$this->db      = $database;
		$this->Adminid = $Adminid;
		$this->obj     = $obj;
		$this->task    = WMain::$task;
		$this->cid     = $_REQUEST['cid'];

		$this->getUI();

		switch ($this->task) {
			case "novo":
			case "edit":         $this->editar();      break;
			case "salvar":	     $this->salvar();      break;
			case "remove":       $this->remover();     break;
			case "flag":         $this->flag();        break;
			case "flag_unica":   $this->flagUnica();   break;
			case "ordering":     $this->ordering();    break;
			case "ordem":        $this->ordem();       break;
			default:
				if (isset($this->vTask[$this->task])) {
					$funcao = $this->vTask[$this->task];
					$this->$funcao();
				} else {
					$this->showTitulo();
					$this->listar();
				}
				break;
		}
	}
	 
	function setTask($task, $funcao) {
		$this->vTask[$task] = $funcao;
	}
	 
	function flag() {
		$this->obj->flagMass($this->cid, $_REQUEST["valor"], $_REQUEST["campo"]);
		$this->redirect('lista');
	}
	 
	function flagUnica() {
		$campo = $_REQUEST["campo"];
		$valor = $_REQUEST["valor"];

		$this->obj->load($this->cid[0]);
		$this->obj->$campo = $valor;
		$this->obj->store();

		if ($valor) {
			$where = "WHERE ".$this->obj->_tbl_key." <> ".$this->cid[0];
			$where = WModel::andWhere($where, $this->obj->_wordem ? WModel::getSQLWordem($this->obj->_wordem, $this->obj) : '');
			$this->obj->update($campo, 0, $where);
		}

		$this->redirect('lista');
	}
	 
	function ordering() {
		$_REQUEST["wordem"] = str_replace("\\'","'",$_REQUEST["wordem"]);
		$this->obj->load($this->cid[0]);
		$this->obj->move($_REQUEST["valor"],$_REQUEST["wordem"]);
		$this->obj->updateOrder($_REQUEST["wordem"]);
		$this->redirect('lista');
	}
	 
	function ordem() {
		$auxwordem = array();
		if (count($this->cid)) {
			foreach ($this->cid as $i => $id) {
				$this->obj->_db->setQuery("UPDATE ".$this->obj->_tbl." SET ordering = ".$_REQUEST["cp_ord"][$i]." WHERE ".$this->obj->_tbl_key." = $id");
				$this->obj->_db->query();
				if($_REQUEST["cp_wordem"][$i]) $auxwordem[$_REQUEST["cp_wordem"][$i]] = true;
			}
			if($auxwordem){
				foreach ($auxwordem as $sqlord=>$xxx){
					$this->obj->updateOrder(urldecode($sqlord));
				}
			}
			else{
				$this->obj->updateOrder();
			}
		}
		$this->redirect('lista');
	}
	 
	function listar($where = "") {
		$where = $this->setListVars($where);
		$total = $this->obj->selectCount($where);
		$rows  = $this->obj->select($where, $this->sort, $this->limit, $this->offset);
		require WPath::adminList();
	}
	 
	function setListVars($where="") {
		// Pagina��o
		$paginacao = new WAdminPaginacao();
		$this->limit  = $paginacao->limit;
		$this->offset = $paginacao->offset;

		// ORDER BY
		persiste('sortname');
		$sortName = pega('sortname', $this->obj->_tbl_default_ordem);
		//$sortOrder = pega('sortorder', 'asc');
		if (strpos($sortName, ',')) {
			$vCampoOrdem = explode(',', $sortName);
			foreach ($vCampoOrdem as &$ordem) {
				if (!strpos($ordem, '.')) {
					$ordem = $this->obj->_tbl_alias.'.'.trim($ordem);
				}
			}
			$this->sort = 'ORDER BY '.implode(', ', $vCampoOrdem);
		} else {
			$this->sort = 'ORDER BY '.(!strpos($sortName, '.') ? $this->obj->_tbl_alias.'.' : '').$sortName;
		}

		// WHERE
		persiste('search');
		if ($search = pega("search")) {
			$like = (WConfig::$dbDriver=="mysql") ? "like" : "ilike";
			 
			$where .= $where ? " AND " : " WHERE ";
			 
			if ($this->vSearch) {
				foreach ($this->vSearch as $field) {
					$vWhere[] = $field." $like '%".$search."%'";
				}
				$where .= '('.implode(' OR ', $vWhere).')';
			} else {
				$where .= $this->obj->_tbl_default_descricao." $like '%".$search."%'";
			}
		}
		
		return $where;
	}
	 
	function editar() {
		$this->obj->load($this->cid[0]);
		$row = $this->obj;
		$this->showTitulo();
		require WPath::adminForm();
	}

	function salvar() {

		if (!isset($_POST['publicado'])) {
			$_POST['publicado'] = 0;
		}

		$this->obj->bind($_POST);

		if (isset($_POST['data'])) {
			$this->obj->data = WDate::format($_POST['data']);
		}

		if (count($this->vUpload)) {
			foreach ($this->vUpload as $campo => $funcao) {
				$this->upload($campo, $funcao);
			}
		}

		$this->beforeCheck();

		if ($this->obj->check() and $this->obj->store()) {
			$this->afterStore();
			$this->redirectJs('lista');
		} else {
			$this->obj->showErrorJs();
		}
	}
	 
	function redirectJs($task, $linkExtra="") {
		echo "document.location.href='index.php?option=".WMain::$option."&task=".($task ? $task : $this->task).$linkExtra."'; ";
	}

	function beforeCheck() {
		return true;
	}
	 
	function afterStore() {
		return true;
	}

	function afterDelete() {
		return true;
	}

	function beforeDelete() {
		return true;
	}
	 
	function remover() {

		if (!count($this->cid)) {
			mostraErro("Selecione pelo menos um registro para excluir!");
		}

		$this->beforeDelete();

		if (count($this->vUpload)) {
			$linhas = $this->obj->selectIn($this->cid);

			foreach ($linhas as $linha) {
				foreach ($this->vUpload as $campo => $funcao) {
					WFile::remove(WPath::arquivoRoot(), $linha->$campo);
				}
			}
		}

		if ($this->obj->deleteMass($this->cid)) {
			$this->afterDelete();
			$this->redirect('lista');
		} else {
			if (strpos($this->obj->_db->getErrorMsg(),"Cannot delete or update a parent row")!==false or
			strpos($this->obj->_db->getErrorMsg(),"chave estrangeira")!==false) {
				mostraErro('Erro ao remover: este item possui registros relacionados');
			} else {
				mostraErro($this->obj->_db->getErrorMsg());
			}
		}
	}
	
		 
	function redirect($task, $linkExtra) {
		header("Location: ".$_SESSION["PHP_SELF"]."?option=".WMain::$option."&task=".($task ? $task : $this->task).$linkExtra);
	}

	 
	//--- USER INTERFACE -------------------------------------
	 
	function getUI() {
		require_once (WPath::classe("menu_admin"));

		$menuAdmin = new MenuAdmin($this->db);
		$menuAdmin->load($this->Adminid);
		$this->ui = $menuAdmin;

		if ($this->subtitulo) {
			$this->ui->subtitulo = $this->subtitulo;
		}
	}

	function showTitulo($return=false) {
		$html = "<script type='text/javascript'>
					$('#header H1').html('".$this->ui->titulo."');
					$('#header H2').html('".$this->ui->subtitulo."');
               </script>";

		if ($return) return $html; else echo $html;
	}
	 
	//--------------------------------------------------------

	 
	//--- UPLOAD ---------------------------------------------
	 
	function setUpload($campo="imagem", $funcao="adicionarImagem") {
		$this->vUpload[$campo] = $funcao;
	}

	function adicionarImagem($nome) {

		$nomeArquivo = uniqid().".jpg";

		$th = new dThumbMaker($_FILES[$nome]["tmp_name"]);
		$th->resizeMaxSize(90,90);
		$th->build(WPath::arquivoRoot("thumb_".$nomeArquivo),"jpeg");

		$th = new dThumbMaker($_FILES[$nome]["tmp_name"]);
		$th->build(WPath::arquivoRoot($nomeArquivo),"jpeg");

		return $nomeArquivo;
	}
	 
	function adicionarArquivo($nome) {
		$nomeArquivo = WFormat::nomePadrao("html",$_FILES[$nome]["name"]);

		if (file_exists(WPath::arquivoRoot($nomeArquivo))) {
			$nomeArquivo = time().WFile::extensao($nomeArquivo);
		}
		if (copy($_FILES[$nome]["tmp_name"], WPath::arquivoRoot($nomeArquivo))) {
			return $nomeArquivo;
		}
	}
	 
	function upload($campo="imagem", $funcao="adicionarImagem", $cp_banco=false, $id = false, $obj = false) {
		if(!$obj) $obj = $this->obj;
		$cid = $obj->_tbl_key;
		if(!$cp_banco) $cp_banco = $campo;
		if(!$id) $id = $obj->$cid;
		if ($id) {
			if($_POST[$campo."_remove"]) {
				WFile::remove(WPath::arquivoRoot(), $_POST[$campo."_anterior"]);
				$nomeArquivo = "";
				if (file_exists($_FILES[$campo."_principal"]["tmp_name"])) {
					$nomeArquivo = $this->$funcao($campo."_principal");
				}

			} else {
				$nomeArquivo = $_POST[$campo."_anterior"];
			}
			 
		} elseif ($_POST["files"][$campo."_principal"]["tmp_name"]) {
			 
			$nomeArquivo = $this->$funcao($campo."_principal");
		} else {
			$nomeArquivo = $_POST[$campo."_anterior"];
		}

		return $this->obj->$campo = $nomeArquivo;
	}
	 
	//--------------------------------------------------------
}

?>