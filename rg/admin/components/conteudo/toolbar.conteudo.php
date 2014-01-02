<?php

$toolbar = new WAdminToolbar();

switch (WMain::$task) {
	case "novo":
	case "edit":
		if (pega("voltar_cp")) {
			$toolbar->btSalvar();
			$toolbar->btVoltar("index.php?option=".pega("voltar_cp")."&Adminid=".pega("voltar_id"));
		} else {
			$toolbar->form();
		}
		break;
	default:
		if (IN_DEVEL) {
			$toolbar->btNovo();
			$toolbar->btRemover();
		}				
		$toolbar->btEditar();
		break;
}

$toolbar->show();

?>