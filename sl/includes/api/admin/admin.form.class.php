<?php

class WAdminForm {

	var $titulo;
	var $icone;
	var $task;
	var $objetoBanco;
	var $pkey;
	var $id;
	var $js;
	var $form;
	var $focus;
	var $camposFiltro;
	var $dados = null;
	var $vForm = null;

	function WAdminForm($row) {
		$this->dados = $row;
		$pk = $this->pkey  = $row->_tbl_key;
		$this->id    = $row->$pk;
		$this->task  = "salvar";
	}

	function js($javascript) {
		$this->js = "<script type=\"text/javascript\">";
		$this->js .= $javascript;
		$this->js .= "</script>";
	}

	function geraForm() {

		$html_form = "";

		for ($i = 0; $i < count($this->vForm); $i++) {

			$fim_field = '';

			if (isset($vetField[$i]) && $vetField[$i]) {
				$html_form .= '<fieldset id="fieldset_'.$i.'" class="adminfield"><legend>'.$vetField[$i].'</legend>';
				$fim_field = '</fieldset>';
			}
			$icone2 = '';
			
			$titulo = ($this->titulo ? $this->titulo : ($this->id ? 'Editar' : 'Novo'));
			$icone = ($this->icone ? $this->icone : ($this->id ? 'editar' : 'novo'));
		
			$icone = 'images/bt-'.$icone.'-form.png';
			$html_form .= '<h3>'.$titulo.'</h3>
							<div class="form">
   					        <table>';

			while ($i < count($this->vForm)) {
				$linha = $this->vForm[$i];
				$field = $linha->name;
				$linha->value = (isset($linha->value)) ? $linha->value : ( isset($this->dados->$field) ? $this->dados->$field : '' );
				$linha->label = (isset($linha->label)) ? $linha->label : '';
				$linha->dados = $this->dados;

				if (is_a($linha, 'WHtmlHidden')) {
					$html_form .= $linha->show();
				} else {
					$html_form .= ' <tr id="trform-'.$field.'">
      									<td class="label"><label>'.$linha->label.'</label></td>
      									<td class="campo"><div class="campo-container">'.$linha->show().'</div></td>
         							 </tr>';
				}

				$i++;
				if (isset($vetField[$i]) && $vetField[$i]) { $i--; break; }
			}
			
			$html_form .= ' <tr>
      							<td class="label">&nbsp;</td>
      							<td class="campo">
      								<div class="toolbar-form"></div>
      								<br class="clr" />
      							</td>
         					 </tr>';

			$html_form .= '</table>
   						</div>'.$fim_field;
		}
		return $html_form;
	}

	function add($field) {
		$this->vForm[] = $field;
	}
	 
	function show($js="", $css="") {
		global $search, $titulo;

		$this->form .= '<form action="index_ajax.php" method="post" id="adminForm" name="adminForm" enctype="multipart/form-data" '.$js.' style="'.$css.'">';
		$this->form .= $this->geraForm();
		$this->form .= '<input type="submit" name="Enviar" value="Enviar" class="hiddenField"/>';
		$this->form .= '<input type="hidden" name="option" value="'.WMain::$option.'" />';
		$this->form .= '<input type="hidden" name="'.$this->pkey.'" value="'.$this->id.'" />';
		$this->form .= '<input type="hidden" name="task" value="'.$this->task.'" />';
		$this->form .= '<input type="hidden" name="search" value="'.$search.'" />';
		$this->form .= '<input type="hidden" name="offset" value="'.$_REQUEST["offset"].'" />';
		$this->form .= "</form>";

		if ($this->focus) {
			$this->form .= "<script>document.adminForm.".$this->focus.".focus();</script>";
		} else {
			$this->form .= "<script>document.adminForm.elements[0].focus();</script>";
		}

		echo $this->js . $this->form;
	}
	 
}

?>