<?php

class Usuario extends WModel {

	var $id_usuario = null;
	var $nome = null;
	var $login = null;
	var $senha = null;
	var $email = null;
	var $session_id = null;
	var $ultimo_login = null;
	var $ultimo_acesso = null;
	 
	var $_grupos = null;

	function __construct() {
		parent::__construct("#S_usuario", "id_usuario", "nome", "id_usuario");
	}
	 
	function check() {
		if (!WMain::$usuario->permissaoAdmin() and $this->id_usuario!=WMain::$usuario->id_usuario) {
			$this->setErrorJs("nome", "Voce nao tem permissao para editar ou criar usuarios.");
			return false;
		}
		 
		if ($this->nome == "") {
			$this->setErrorJs("nome","Nome deve ser preenchido.");
			return false;
		}
		if ($this->login == "") {
			$this->setErrorJs("login","Login deve ser preenchido.");
			return false;
		}
		 
		$usuarios = $this->select("WHERE login = '$this->login'" . ($this->id_usuario ? " AND id_usuario != $this->id_usuario" : ""));
		if ($usuarios[0]->id_usuario) {
			$this->setErrorJs("login","Login já cadastrado");
			return false;
		}
		 
		if ($this->email == "") {
			$this->setErrorJs("email","E-mail deve ser preenchido.");
			return false;
		}
		if (!WValidate::email($this->email)) {
			$this->setErrorJs("email","E-mail inválido.");
			return false;
		}
		 
		$usuarios = $this->select("WHERE email = '$this->email'" . ($this->id_usuario ? " AND id_usuario != $this->id_usuario" : ""));
		if ($usuarios[0]->id_usuario) {
			$this->setErrorJs("email","E-mail já cadastrado");
			return false;
		}
		 
		if ($this->id_usuario=="" and $this->senha=="") {
			$this->setErrorJs("senha","Senha deve ser preenchida.");
			return false;
		}
		 
		return true;
	}

	function isLogado() {
		if ($_SESSION["usuario_id_usuario"]){
			/*debug(session_id());
			 debug($this);
			 debug($this->session_id);exit;*/
			return (session_id()==$this->session_id);
		}
		return false;
	}
	 
	function loadLogado() {
		if ($_SESSION["usuario_id_usuario"]) {
			$this->load($_SESSION["usuario_id_usuario"]);
			$this->loadGrupos();
		}
	}

	function login() {
		$senha = md5($this->senha);
		$this->loadBy("login",$this->login);
		if ($senha==$this->senha) {
			$_SESSION["usuario_id_usuario"] = $this->id_usuario;
			$this->session_id = session_id();
			$this->ultimo_login  = date("Y-m-d H:i:s");
			$this->ultimo_acesso = date("Y-m-d H:i:s");
			$this->store();
			$_SESSION["usuario_id_usuario"] = $this->id_usuario;
			return true;
		}
		return false;
	}
	 
	function loadGrupos($where="") {
		$this->_db->setQuery("SELECT g.id_usuario_grupo, nome FROM #S_usuario_grupo g
                            INNER JOIN #S_usuario_usuario_grupo ug ON ug.id_usuario_grupo = g.id_usuario_grupo
                            WHERE ug.id_usuario = ".$this->id_usuario.($where ? " AND ".$where : ""));
		$rows = $this->_db->loadObjectList();
		foreach ($rows as $row) {
			$this->_grupos[$row->id_usuario_grupo] = $row->nome;
		}
	}
	 
	function permissao() {
		return true;
		if (!WMain::$Adminid) {
			WMain::$Adminid = 1;
		}

		if (!$this->_grupos) {
			return false;
		}

		if (WMain::$option) {
			 
			$this->_db->setQuery("SELECT link FROM #__menu_admin WHERE id_menu_admin = ".WMain::$Adminid);
			$vars = explode("&",str_replace("index.php?", "", $this->_db->loadResult()));

			foreach ($vars as $var) {
				$var = explode("=",$var);
				if ($var[0]=="option") {
					if ($var[1]==WMain::$option) {
						break;
					} else {
						return false;
					}
				}
			}
		}

		$usuarioGrupoMenu = new UsuarioGrupoMenuAdmin();
		$permissao = $usuarioGrupoMenu->select("WHERE id_menu_admin = ".WMain::$Adminid."
                                              AND id_usuario_grupo IN (".implode(", ", array_keys($this->_grupos)).")");
		if ($permissao[0]->id_usuario_grupo) {
			return true;
		} else {
			return false;
		}
	}
	 
	/*function loginAdmin() {
	 $senha = md5($this->senha);
	 $this->loadBy("login",$this->login);
	 if ($senha==$this->senha){
	 $this->session_id = session_id();
	 $this->ultimo_login = date("Y-m-d H:i:s");
	 $this->ultimo_acesso = date("Y-m-d H:i:s");
	 $this->store();
	 $this->loadSession(true);
	 return true;
	 }
	 return false;
	 }*/
	 
	function loadSession($isAdmin = false) {
		$_SESSION["usuario_id_usuario"] = $this->id_usuario;

		if (!($isAdmin)) {

			$sessaoGravada = unserialize($this->sessao);
			 
			if (count($sessaoGravada)) {
				foreach ($sessaoGravada as $var => $value) {
					$_SESSION[$var] = $value;
				}
			}
			 
			if (isset($_SESSION["phpself"])) {
				$url = $_SESSION["phpself"];
				unset($_SESSION["phpself"]);
				header("Location: ".$url);
				exit();
			}
		}
	}
	 
	function acessoRestrito() {
		echo "Acesso restrito";
	}
	 	 
	function permissaoAdmin() {
		return ($this->id_usuario_grupo <= 2);
	}
	 
	function inatividade(){
		if (time()-strtotime($this->ultimo_acesso)>WConfig::$sessionLifeTime) {
			$this->logout();
		} else{
			$this->ultimo_acesso = date("Y-m-d H:i:s");
			$this->store();
		}
	}
	 
	function monitoraAcesso($isAdmin = false) {
		if (!($this->inatividade())) {
			$this->ultimo_acesso = date("Y-m-d H:i:s");
			$this->store();
		}
	}
	 
	function isOnline() {
		return ((!(time()-strtotime($this->ultimo_acesso)>WConfig::$sessionLifeTime)) and ($this->session_id));
	}
	 
	function logout(){
		if (isset($_SESSION["usuario_id_usuario"])) {
			$this->load($_SESSION["usuario_id_usuario"]);
			$this->session_id = "";
			$this->store();
		}

		session_unset();
	}
	 
}
?>