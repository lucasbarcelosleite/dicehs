<?php

class UsuarioController extends AdminController {
	 
	function __construct(&$obj) {
		$this->setTask("alterarSenha","editarSenha");
		$this->setTask("editarSenha","editarSenha");
		$this->setTask("salvarEditarSenha","salvarEditarSenha");
		$this->setTask("salvarAlterarSenha","salvarAlterarSenha");

		parent::__construct($obj);
	}
	 
	function listar() {
		$where = (WConfig::$habilitaPermissoes and !WMain::$usuario->permissaoAdmin()) ? "WHERE usuario.id_usuario = ".WMain::$usuario->id_usuario : "";
		parent::listar($where);
	}
	 
	function beforeDelete() {
		if (!WMain::$usuario->permissaoAdmin()) {
			echo "alert('Voce nao possui permissao para excluir usuarios!')";
			exit;
		}
	}
	 
	function editarSenha() {
		$row = new Usuario();
		$row->load(WMain::$usuario->id_usuario);
		$row->senha = "";
		$form = new WAdminForm($row);

		if ($this->task=="alterarSenha") {
			$field = new WHtmlPassword("Senha Atual","senha_atual");
			$form->add($field);
			$form->task = "salvarAlterarSenha";
		} else {
			$this->obj->load(pega("id"));

			$field = new WHtmlHidden("id");
			$field->value = $this->obj->id_usuario;
			$form->add($field);

			$field = new WHtml("Login","");
			$field->campo = $this->obj->login;
			$form->add($field);
			$form->task = "salvarEditarSenha";
		}

		$field = new WHtmlPassword("Nova Senha","senha");
		$form->add($field);

		$field = new WHtmlPassword("Confirmar Senha","confirma");
		$form->add($field);

		$form->titulo = "Alterar Senha";
		$form->icone = "editar";
		$form->show();
		$this->showTitulo();
	}
	 
	function salvarSenha(&$usuario){
		if (!pega("senha")) {
			echo "alert('Nova Senha deve ser preenchida.'); $('#senha').focus(); ";
			return false;
		}

		if(pega("senha")==pega("confirma")){
			$usuario->senha = md5(pega("senha"));
			$usuario->store();
			echo "alert('Senha alterada com sucesso');";
			return true;
		} else {
			echo "alert('O campo Confirmar Senha dever estar igual a Nova Senha'); $('#senha').focus(); ";
			return false;
		}
	}
	 
	function salvarEditarSenha() {
		$usuario = new Usuario();
		$usuario->load(pega("id"));
		if($this->salvarSenha($usuario)){
			$this->redirectJs("grid");
		}
	}
	 
	function salvarAlterarSenha(){
		if(!pega("senha_atual")){
			echo "alert('Senha Atual deve ser preenchida.'); $('#senha_atual').focus(); ";
			return false;
		}
		if(md5(pega("senha_atual"))!=WMain::$usuario->senha){
			echo "alert('Senha Atual n�o confere.'); $('#senha_atual').focus(); ";
			return false;
		}
		if($this->salvarSenha(WMain::$usuario)){
			echo "history.back();";
		}
	}
	 
	function beforeCheck(){
		$this->obj->senha = $_POST['senha'] ? md5($this->obj->senha) : null;
	}
	 
	function afterStore() {
		if (WMain::$usuario->permissaoAdmin()) {
			$usuarioUsuarioGrupo = new UsuarioUsuarioGrupo();
			$usuarioUsuarioGrupo->deleteWhere("WHERE id_usuario = ".$this->obj->id_usuario);
			 
			if (count($_POST["id_usuario_grupo"])) {
				foreach ($_POST["id_usuario_grupo"] as $id_usuario_grupo) {
					$usuarioUsuarioGrupo->id_usuario_usuario_grupo = "";
					$usuarioUsuarioGrupo->id_usuario       = $this->obj->id_usuario;
					$usuarioUsuarioGrupo->id_usuario_grupo = $id_usuario_grupo;
					$usuarioUsuarioGrupo->store();
				}
			}
			return $this->obj->store();
		}
	}
	 
}

new UsuarioController(new Usuario());

?>