<?php

class WAdminToolbar {

	public $vButton = array();

	function __construct() { }

	function form() {
		$this->btSalvar();
		$this->btCancelar();
	}

	function lista($ordem=true, $publicado=true) {
		if ($publicado) {
			$this->btFlag();
		}
		if ($ordem) {
			$this->btOrdem();
		}
		$this->btNovo();
		$this->btEditar();
		$this->btRemover();
	}

	function btCustom($imagem, $alt, $task, $href='') {
		$button = new stdClass();
		$button->imagem = $imagem;
		$button->alt    = $alt;
		$button->task   = $task;
		$button->href   = $href;
		$this->vButton[] = $button;
	}

	function btOrdem() {
		$button = new stdClass();
		$button->imagem = 'bt-salva_ordem.png';
		$button->task   = 'ordem';
		$button->alt    = 'Ordenar';
		$button->formSubmit = true;
		$this->vButton[] = $button;
	}

	function btVoltar($href='javascript:history.back();') {
		$button = new stdClass();
		$button->imagem = 'bt-voltar.png';
		$button->task   = 'back';
		$button->alt    = 'Voltar';
		$button->href   = $href;
		$this->vButton[] = $button;
	}

	function btRemover() {
		$button = new stdClass();
		$button->imagem = 'bt-excluir.png';
		$button->task   = 'remove';
		$button->alt    = 'Remover';
		$button->checkSelected = true;
		$this->vButton[] = $button;
	}

	function btCancelar() {
		$button = new stdClass();
		$button->imagem = 'bt-cancelar.png';
		$button->task   = 'cancel';
		$button->alt    = 'Cancelar';
		$button->href   = 'javascript:history.back();';
		$this->vButton[] = $button;
	}

	function btSalvar() {
		$button = new stdClass();
		$button->imagem = 'bt-salvar.png';
		$button->task   = 'salvar';
		$button->alt    = 'Salvar';
		$button->formSubmit = true;
		$this->vButton[] = $button;
	}

	function btEditar() {
		$button = new stdClass();
		$button->imagem = 'bt-editar.png';
		$button->task   = 'edit';
		$button->alt    = 'Editar';
		$button->checkSelected = true;
		$button->formSubmit = true;
		$this->vButton[] = $button;
	}

	function btNovo() {
		$button = new stdClass();
		$button->imagem = 'bt-novo.png';
		$button->task   = 'novo';
		$button->alt    = 'Novo';
		$button->checkSelected = false;
		$this->vButton[] = $button;
	}

	function btFlag($flag='publicado') {
		$button = new stdClass();
		$button->imagem = 'bt-publicado.png';
		$button->task   = 'flag['.$flag.'=1]';
		$button->alt    = 'Publicar';
		$button->checkSelected = true;
		$this->vButton[] = $button;

		$button = new stdClass();
		$button->imagem = 'bt-despublicado.png';
		$button->task   = 'flag['.$flag.'=0]';
		$button->alt    = 'Despublicar';
		$button->checkSelected = true;
		$this->vButton[] = $button;
	}

	function show() {
		echo '<ul>';
		foreach ($this->vButton as $button) {
			$href = $button->href ? $button->href : 'index.php?option='.WMain::$option.'&Adminid='.WMain::$Adminid.'&task='.$button->task;
			echo '<li>
					<a class="toolbar" href="'.$href.'" title="'.$button->alt.'">
      					<span class="'.($button->checkSelected ? 'check-selected ' : '')
      								  .($button->formSubmit ? 'form-submit' : '').'"
      						  name="'.$button->task.'">
      					'.$button->alt.'
      					</span>
      					</a>
      			  </li>';
		}		
		echo '</ul>';
		echo '<br class="clr" />';
	}
}

?>