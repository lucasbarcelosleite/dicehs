<?

class WHtml {

	var $label = null;
	var $campo = null;
	var $propriedades = null;

	var $name = null;

	var $value = null;

	var $dados = null;

	function __construct($label="",$name="", $value="") {
		$this->label = $label;
		$this->name = $name;
		if ($value!="") $this->value = $value;
	}

	function WHtml($label="", $name="", $value="") {
		$this->__construct($label,$name, $value);
	}

	function abreForm($nome, $action="", $propriedades = array()){
		return '<form name="'.$nome.'" action="'.$action.'" id="'.$nome.'" '.$this->montaPropriedades("form", $propriedades).'>';
	}

	function montaPropriedades($tipo, $propriedades,$validacao = ""){
		if (!is_array($propriedades))
		$propriedades = array();
		$retorno = "";
		if(isset($propriedades["onclick"]))
		$onClick = $propriedades["onclick"];
		else
		$onClick = "";
		foreach ($propriedades as $chave => $valor)
		$retorno .= " $chave=\"$valor\" ";
		return $retorno;
	}

	function show() {
		return $this->campo;
	}

}

class WHtmlInput extends WHtml {

	var $maxlength = "";
	 
	function show(){
		if ($this->maxlength) {
			$this->propriedades["maxlength"] = $this->maxlength;
		}

		if ($this->mask) {
			$jquery = " <script> $(document).ready(function(){
                        $('input[name=".$this->name."]').mask('".$this->mask."',{placeholder:' '});
                     }); </script> ";
		} else {
			$jquery = "";
		}

		return $jquery . ' <input type="text" name="'.$this->name.'" id="'.$this->name.'" value="'.str_replace('"', "&quot;", $this->value).'" '.$this->montaPropriedades("input", $this->propriedades, $validacao).' />';
	}
	 
}

class WHtmlPassword extends WHtml {

	function show(){
		return '<input type="password" name="'.$this->name.'" id="'.$this->name.'" value="'.$this->value.'"'.$this->montaPropriedades("input", $this->propriedades, $validacao).' />';
	}

}

class WHtmlInputData extends WHtml {

	function show(){
		$jquery = " <script> $(document).ready(function(){
                     $('input[name=".$this->name."]').mask('99/99/9999',{placeholder:' '});
                  }); </script> ";

		return $jquery .'<input class="inputbox" type="text" name="'.$this->name.'" id="id_'.$this->name.'" value="'.($this->value!="" ? WDate::format($this->value) : date("d/m/Y")).'" maxlength="10" title="Data" '.$this->montaPropriedades("input", $this->propriedades, $validacao).' />';

		//' <input type="text" name="'.$this->name.'" id="'.$this->name.'" value="'.$this->value.'"'.$this->montaPropriedades("input", $propriedades, $validacao).' />';
	}

}

class WHtmlInputMoeda extends WHtml {

	function show(){
		$jquery = " <script> $(document).ready(function(){
                  	$('input[name=".$this->name."]').priceFormat({
                         limit: 20,
                  		 prefix: 'R$ ',
                         centsSeparator: ',',
                         thousandsSeparator: '.'
                     });
                  }); </script> ";

		return $jquery .'<input class="inputbox" type="text" name="'.$this->name.'" id="id_'.$this->name.'" value="'.($this->value?$this->value:0).'" maxlength="20" title="Data" '.$this->montaPropriedades("input", $this->propriedades, $validacao).' size="20" />';
	}

}

class WHtmlSubmit extends WHtml {

	function show(){
		if (!($valor)) $valor = $this->obj->$nome;
		return '<input type="password" name="'.$nome.'" id="'.$nome.'" value="'.$valor.'"'.$this->montaPropriedades("input", $this->propriedades, $validacao).' />';
	}

}

class WHtmlButton extends WHtml {

	function show(){
		return '<input type="button" id="'.$label.'" value="'.$label.'"'.$this->montaPropriedades("botao", $this->propriedades).' />';
	}

}

class WHtmlTextArea extends WHtml {

	var $linhas  = 4;
	var $colunas = 102;
	var $limite  = 255;
	 
	function show(){
		if (!($valor)) $valor = $this->obj->$nome;

		if ($this->limite) {
			$jquery = " <script>
                         $(document).ready(function(){
                            $('#".$this->name."').keyup(function(){
                          		limitChars('".$this->name."', '".$this->limite."', 'charLimitInfo-".$this->name."');
                          	});
                         });
                      </script>";
		}

		$html = '<textarea name="'.$this->name.'" rows="'.$this->linhas.'" cols="'.$this->colunas.'" id="'.$this->name.'" '.$this->montaPropriedades("input", $this->propriedades, $validacao).' />'.$this->value.'</textarea>';
		if ($this->limite) {
			$html .= '<div id="charLimitInfo-'.$this->name.'">'.($this->limite - strlen($this->value)).' caracteres restantes.</div>';
		}

		return $jquery . $html;
	}

}


class WHtmlEditorArea extends WHtml {

	var $tem_diagramacao = true;
	var $linhas;
	var $colunas;
	function WHtmlEditorArea($label="", $name="", $value="", $linhas=30, $colunas=1000) {
		$this->__construct($label,$name, $value);
		$this->colunas = $colunas;
		$this->linhas = $linhas;
	}

	function show(){
		$id = uniqid("id_");

		return '<textarea class="editor-area" name="'.$this->name.'" rows="'.$this->linhas.'" cols="'.$this->colunas.'">
           		'.htmlentities($this->value).'
           	 </textarea>
           	 <script type="text/javascript">
           	    var editor = CKEDITOR.replace("'.$this->name.'"); 
           	    CKFinder.SetupCKEditor(editor, "'.str_replace('//','/',str_replace($_SERVER["DOCUMENT_ROOT"], "", WPath::inc("ckfinder"))).'");
           	 </script>';
	}
	 
	function init() {
		return '<script type="text/javascript" src="'.WPath::inc("ckeditor/ckeditor.js", GET_LIVE).'"></script>
              <script type="text/javascript" src="'.WPath::inc("ckfinder/ckfinder.js", GET_LIVE).'"></script>';
	}
}


class WHtmlHidden extends WHtml {

	function WHtmlHidden($name, $value="") {
		$this->name = $name;
		if ($value!="") $this->value = $value;
	}
	 
	function show(){
		return '<input type="hidden" name="'.$this->name.'" id="'.$this->name.'" value="'.$this->value.'" />';
	}

}

class WHtmlUpload extends WHtml {

	var $prefixoForm = null;
	var $mostraNomeArquivo = false;
	var $multiplo = false;
	var $crop = false;
	 
	var $arquivosTipoNome = null;
	var $arquivosTipoExt = null;
	 
	function WHtmlUpload($label, $name='imagem',$prefixoForm='thumb',$multiplo=false) {
		$this->label = $label;
		$this->name = $name;
		$this->prefixoForm = $prefixoForm;
		$this->multiplo = $multiplo;
	}
	 
	function setTipoArquivo($nome, $extensao='') {
		switch ($nome) {
			case 'imagem':
				$this->arquivosTipoNome = 'Imagens';
				$this->arquivosTipoExt = '*.jpg;*.jpeg;*.png;*.gif';
				break;
			case 'audio':
				$this->arquivosTipoNome = 'Audios';
				$this->arquivosTipoExt = '*.wav;*.snd;*.au;*.wma;*.mp3;*.ogg;*.avi';
				break;
			case 'video':
				$this->arquivosTipoNome = 'Videos';
				$this->arquivosTipoExt = '*.wmv;*.mpg;*.flv;*.mpeg;*.m1v;*.mp2;*.avi';
				break;
			default:
				$this->arquivosTipoNome = $nome;
				$this->arquivosTipoExt = $extensao;
				break;
		}
	}
	 
	function show() {

		if (!$this->arquivosTipoNome) {
			$this->arquivosTipoNome = 'Tudo (*,*)';
		}
		if (!$this->arquivosTipoExt) {
			$this->arquivosTipoExt = '*.*;';
		}
		 
		$display = "";
		$name   = $this->name;
		$multiplo = ($this->multiplo)?'true':'false';

		$js = '<script>
               function remover_'.$name.'(){
      				document.adminForm.'.$name.'_remove.value = 1;
      				document.getElementById("atual_'.$name.'_principal").style.display = "none";
      				document.getElementById("input_'.$name.'_principal").style.display = "inline";
      			}
      		</script>';

		$width=false;

		if ($this->dados->$name) {
			if (file_exists($arquivo = WPath::arquivoRoot($this->prefixoForm.'_'.$this->dados->$name))) {

				$display  = " style=\"display:none;\" ";
				$ehImagem = WValidate::imagem($arquivo);
				$imagem   = WPath::arquivo($this->prefixoForm.'_'.$this->dados->$name);
			}
			elseif (file_exists($arquivo = WPath::arquivoRoot($this->dados->$name))) {
				$display  = " style=\"display:none;\" ";
				$ehImagem = WValidate::imagem($arquivo);
				$imagem   = WPath::arquivo($this->dados->$name);
				$dimensao = WFile::dimensoes($this->dados->$name);
				if($dimensao[0]>500){
					$width=500;
				}
			}
		}
		if($this->multiplo){
			$complete = '$("#hide-id-'.$name.'").append(retorna.replace(/#x#/g,"["+ind_numero_'.$name.'+"]"));';
		}
		else{
			$complete = '$("#hide-id-'.$name.'").append(retorna.replace(/#x#/g,""));';
		}
		$html = '<div id="input_'.$name.'_principal" '.$display.'>
                    <div id="upload_'.$name.'">É necessário instalar o Adobe Flash Player.<br>Para instalá-lo clique <a target="_blank" href="http://get.adobe.com/br/flashplayer/"><b>aqui</b></a> <input type="hidden" name="upload_flash" value="1" /></div><br />
                    <div id="hide-id-'.$name.'"></div>
                </div>
                <script type="text/javascript">
                    $(document).ready(function(){
                        var ind_numero_'.$name.'=0;
                        $("#upload_'.$name.'").fileUpload({
                            uploader: "'.WPath::flash('uploader.swf').'",
                            cancelImg: "'.WPath::img('cancel.png').'",
                            script: "../index.php",
                            scriptData: {option:"upload", notpl:"1"},
                            multi: '.$multiplo.',
                            auto: true,
                            fileDataName: "'.$name.'_principal",
                            fileDesc: "'. $this->arquivosTipoNome .'",
                            fileExt: "'. $this->arquivosTipoExt .'",
                            buttonText: "Adicionar '.(($this->multiplo)?"Arquivos":"Arquivo").'",
                            displayData: "speed",
                            onSelect: function() {
                                ind_numero_'.$name.'=0;
                                $("#hide-id-'.$name.'").html("");
                            },
                            onComplete: function (event, queueID ,fileObj, retorna) {
                                '.$complete.'
                                ind_numero_'.$name.'++;
                                
                                '.($this->crop ? 'uploadCrop("'.$name.'", "'.$this->crop.'", $(\'input[name="files['.$name.'_principal][tmp_name]"]\').val().replace("'.ROOT.'", "'.LIVE.'"));' : '').'
                            }
                        });
                    });
                </script>';

		if ($display) {
			$html .= '<div id="atual_'.$name.'_principal">';
			 
			if ($ehImagem) {
				$html .= '<img src="'.$imagem.'" hspace="5" '.($width?"width=".$width:"").' align=absmiddle>';
			} else {
				$html .= '<img src="'.WPath::img('folder.png').'" hspace="5" align=absmiddle alt="Arquivo">'.($this->mostraNomeArquivo ? "<br>" . $this->dados->$name : "");
			}
			 
			$html .= '<a href="javascript:remover_'.$name.'()"><font color=red><img src="'.WPath::img('edit_delete.png').'" border=0 alt="Remover"></font></a>
      		    </div>'; 
		}
		 
		$html .= '<input type="hidden" name="'.$name.'_remove" value="'.(($display and $this->dados->_tbl_key) ? 0 : 1).'">
				    <input type="hidden" name="'.$name.'_anterior" value="'.$this->dados->$name.'">';

		return $js . $html;
	}

}

class WHtmlCheck extends WHtml {

	var $default = 0;

	function show(){

		if ($this->name=='publicado') {
			$this->default = 1;
		}

		$propriedades = $this->montaPropriedades("checkbox", $this->propriedades);

		$hidden = new WHtmlHidden("checks[]",$this->name);

		$key = $this->dados->_tbl_key;

		return $hidden->show().'<input type="checkbox" class="checkbox" name="'.$this->name.'" '.(($this->value==1 or (!($this->dados->$key) and $this->default))? "checked=\"checked\"" : " ").$propriedades.' value="1"/> ';
	}

}

class WHtmlRadioGroup extends WHtml {

	var $options = null;
	var $qtdLinha = 3;
	var $isTraducao = false;
	var $mapTraducao = array();
	 
	function setLang(&$obj, $mapTraducao){
		if($obj->_isTraducao){
			$this->isTraducao = true;
			$this->mapTraducao = $mapTraducao;
		}
	}

	function show(){
		$selecionado = $this->value;
		$valores = $this->options;
		$nome = $this->name;
		$qtdLinha = $this->qtdLinha;
		$ret = "<table><tr>";
		$propriedades = $this->montaPropriedades("checkbox", $this->propriedades);
		$cont = 0;
		foreach ($valores as $chave => $label){
			$v_sel = ($this->isTraducao)?$this->mapTraducao[$chave]:$chave;
			$ret .= ($cont == $qtdLinha ? "</tr><tr>" : "").'<td class="labelN"><input type="radio" class="radio" name="'.$nome.'" id="'.$nome.'" value="'.$chave.'"'.($v_sel==$selecionado ? " checked=\"checked\"" : "").$propriedades.' /> '.$label."</td>";
			$cont = ($cont%$qtdLinha)+1;
		}
		$ret .= "</tr></table>";
		return $ret;
	}

}


class WHtmlCombo extends WHtml {

	var $options = null;
	var $isTraducao = false;
	var $mapTraducao = array();

	function setLang(&$obj, $mapTraducao){
		if($obj->_isTraducao){
			$this->isTraducao = true;
			$this->mapTraducao = $mapTraducao;
		}
	}
	 
	function show() {
		$selected = $this->value;
		$opcoes = $this->options;
		$propriedades = $this->montaPropriedades("select", $this->propriedades);
		$resultado = "<select name=\"".$this->name."\" id=\"".$this->name."\" $propriedades >";
		if($this->propriedades["multiple"] != "multiple") $resultado .= "<option value=\"\">--- Selecione ---</option>";

		if (count($opcoes)) {
			foreach($opcoes as $valor=>$label){
				$v_sel = ($this->isTraducao)?$this->mapTraducao[$valor]:$valor;
				$b_sel = ($selected==$v_sel || is_array($selected) && in_array($v_sel, $selected));
				$resultado .= "<option value=\"".$valor."\"".($b_sel?" selected=\"selected\" ":"").">".$label."</option>";
			}
		}

		$resultado .= "</select>";
		return $resultado;
	}

}


class WHtmlAutocomplete extends WHtml {

	var $btSalvar = true;
	var $vSelected = false;
	var $linkAjaxListar = "index_ajax.php?option=tag&task=autocomplete_listar";
	var $linkAjaxSalvar = "index_ajax.php?option=tag&task=autocomplete_salvar";

	function WHtmlAutocomplete($label, $nome, $vSelected=array(), $btSalvar=true) {
		$this->name      = $nome;
		$this->label     = $label;
		$this->vSelected = $vSelected;
		$this->btSalvar  = $btSalvar;
	}

	function show() {
		$js = '<script type="text/javascript">
                $(document).ready(function(){
                    $("#'.$this->name.'-input").autocomplete("'.$this->linkAjaxListar.'", { width: 310, scroll: true, scrollHeight: 300 });
               });
           </script>';
		 
		$html = '<ul id="'.$this->name.'-ul" class="autocomplete-ul">';

		if (count($this->vSelected)) {
			foreach ($this->vSelected as $id => $value) {
				$html .= '<li>
                            <a href="javascript:void(0)" class="autocomplete-remover" title="Remover">x</a>'
                            .$value
                            .'<input type="hidden" name="'.$this->name.'[]" value="'.$id.'" />
                          </li>';
			}
		}

		$html .= '</ul>
                 <br class="clr" />
                 <input type="text" name="'.$this->name.'-input" class="autocomplete-input" id="'.$this->name.'-input" value="" />
                 '.($this->btSalvar ? '<a href="'.$this->linkAjaxSalvar.'" class="autocomplete-salvar" title="Salvar"><img src="'.WPath::img("save.png").'" alt="Salvar" title="Salvar" /></a>' : '').'
                 <br class="clr" />';

		return $js . $html;
	}

}

class WHtmlDropDownMenu extends WHtmlCombo {
	 
	function show() {
		$v_sel = ($this->isTraducao)?$this->mapTraducao[$this->value]:$this->value;
		$resultado = ' <script type="text/javascript">
                        $(document).ready(function (){
                           $("#'.$this->name.'").mcDropdown("#'.$this->name.'categorymenu",{
                                minRows: 16,
                                maxRows: 100,
                                allowParentSelect: true,
                                hoverOverDelay: 500,
                                hoverOutDelay: 0,
                                delim: " ï¿½ "
                           });
                        });
                     </script>
                     <input type="text" name="'.$this->name.'" id="'.$this->name.'" value="'.$v_sel.'" />
                     <ul id="'.$this->name.'categorymenu" class="mcdropdown_menu">
                     '.$this->options.'
                     </li></ul>';
		return $resultado;
	}
}


class WHtmlInputMultiRelacional {

	var $name;
	var $origem;
	var $destino;
	var $width = 240;
	var $height = 255;
	var $labelOrigem = "Origem";
	var $labelDestino = "Destino";
	var $ordering = false;

	function WHtmlInputMultiRelacional($label, $nome, $labelOrigem="Nï¿½o Selecionados", $labelDestino="Selecionados") {
		$this->name = $nome;
		$this->label = $label;
		$this->labelDestino = $labelDestino;
		$this->labelOrigem  = $labelOrigem;
	}

	function show() {
		$cb_origem = new WHtmlCombo();
		$cb_origem->options = $this->origem;
		$cb_origem->propriedades["multiple"] = "multiple";
		$cb_origem->propriedades["class"] = "cb_multi_origem";
		$cb_origem->propriedades["style"] = 'width:'.$this->width.'px; height:'.$this->height.'px;';
		$cb_destino = new WHtmlCombo();
		$cb_destino->options = $this->destino;
		$cb_destino->propriedades["multiple"] = "multiple";
		$cb_destino->propriedades["class"] = "cb_multi_destino";
		$cb_destino->propriedades["style"] = 'width:'.$this->width.'px; height:'.($this->ordering?($this->height-18):$this->height).'px;';
		$resultado = '<table border="0" cellspacing="0" cellpadding="4" id="'.$this->name.'" class="multi-relacional">
		    <tr>
				<td align="center">'.$this->labelOrigem.'</td>
				<td class="hidden-multi"></td>
				<td align="center">'.$this->labelDestino.'</td>
			 </tr>
		    <tr>
				<td>';
		$resultado .= $cb_origem->show();
		$resultado .= '</td>
				<td><input class="bt-adicionar" type="button" value=">>" title="Adicionar"/><br /><input type="button" value="<<" title="Remover" class="bt-remover" /></td>
				<td>';
		$resultado .= $cb_destino->show();
		$resultado .= (($this->ordering)?'<br><input value="Acima" type="button" class="bt-cima" /><input value="Abaixo" type="button" class="bt-baixo" />':'').
			  '</td>
			</tr>
			</table>';
		return $resultado;
	}

}


class WHtmlComboOptgroup extends WHtml {

	var $isTraducao = false;
	var $mapTraducao = array();
	var $rows = null; // formato = array('grupo'=>0,'id'=>0,'nome'=>0);
	 
	function setLang(&$obj, $mapTraducao){
		if($obj->_isTraducao){
			$this->isTraducao = true;
			$this->mapTraducao = $mapTraducao;
		}
	}

	function show() {
		 
		$selected = $this->value;
		$propriedades = $this->montaPropriedades("select", $this->propriedades);
		$resultado = "<select name=\"".$this->name."\" id=\"".$this->name."\" $propriedades >";
		if($this->propriedades["multiple"] != "multiple") $resultado .= "<option value=\"\">--- Selecione ---</option>";

		if(count($this->rows)){
			 
			foreach ($this->rows as $i => $row){
				 
				if($this->rows[$i-1]->grupo != $row->grupo){
					$resultado .= "<optgroup label='".$row->grupo."'>";
				}
				 
				$v_sel = $this->isTraducao ? $this->mapTraducao[$row->id] : $row->id;
				$b_sel = ( $selected == $v_sel || is_array($selected) && in_array($v_sel, $selected) );

				$resultado .= "<option value=\"".$row->id."\"".($b_sel ? " selected=\"selected\" " : "").">".$row->nome."</option>";

				if($this->rows[$i+1]->grupo != $row->grupo){
					$resultado .= "</optgroup>";
				}

			}
			 
		}

		$resultado .= "</select>";
		return $resultado;

	}

}

?>