<?php

class WAdminLista {

	public $campos = array();
	public $dados  = array();
	public $rows   = array();

	public $id = null;
	public $obj = null;

	public $campoOrdemPadrao = "";
	public $ordemPadrao = "asc";
	public $wordem = "asc";
	public $wordemData = array();
	public $is_ordering = false;

	public $url = "";
	public $totalItens = 0;
	public $isResultAdmin = false;
	public $doubleClick = true;

	public $linkEdita = true;
	public $colCheck = true;
	public $search = "";
	public $pageNav = array();

	public $showFiltro = true;

	function WAdminLista($campos=array(), $dados=array(), $url="", $chave=false, &$pageNav) {
		$this->campos = $campos;
		$this->dados = $dados;
		$this->url = $url;
		$this->setUrlAdmin();
		$this->persiste($chave);

		$this->search = pega("search");

		$this->pageNav =& $pageNav;
	}

	function persiste($chave=false){
		if($chave==false){
			$chave = WMain::$option.WMain::$Itemid;
		}
	}

	function setUrlAdmin($taskResult="lista") {
		$this->isResultAdmin = (WMain::$task==$taskResult);
		$this->url = "index_ajax.php?option=".WMain::$option."&task=".$taskResult."&Adminid=".WMain::$Adminid;
	}

	function setObj(&$obj) {
		$this->obj = $obj;

		$this->id = $this->obj->_tbl_key;
		$auxOrd = explode(",",$this->obj->_tbl_default_ordem);
		$auxOrd = explode(" ",$auxOrd[0]);
		$this->ordemPadrao(strtolower($auxOrd[0]),(isset($auxOrd[1]))?strtolower($auxOrd[1]):"asc");
	}

	function autoLista($rows, $total) {
		$this->rows = $rows;
		$cam = $this->id;

		if (count($rows)) {
			foreach ($rows as $i => $row) {
				$this->dados[$i]["id"]  = $row->$cam;
				foreach ($this->campos as $field => $objGridColuna) {
					$this->dados[$i][$field] = $this->trataCampo($row,$field);
				}
				if ($this->obj->_wordem) {
					$this->wordemData[$i] = $row;
				}
			}
			$this->totalItens = $total;
		}
	}

	function trataCampo(&$row,$field){
		$aux = explode("->",$field);
		if(count($aux)>1){
			$obj = $aux[0];
			$campo = $aux[1];
			$obj2 = $row->$obj;
			return $obj2->$campo;
		}
		return $row->$field;
	}

	function add($col){
		$this->campos[$col->campo] = $col;
	}

	function ordemPadrao($campo, $ordem="asc") {
		$this->campoOrdemPadrao = $campo;
		$this->ordemPadrao = $ordem;
	}

	function ordering($wordem="asc") {
		$this->ordemPadrao = "asc";
		$this->campoOrdemPadrao = "ordering";
		$this->is_ordering = true;
		$this->wordem = $wordem;
	}

	function verificaWordem($i, $sinal) {

		if(is_array($this->obj->_wordem)){
			$cod = "";
			foreach ($this->obj->_wordem as $wo){
				$cod .= (($cod)?' && ':'').'($this->wordemData[$i]->'.$wo.'=="'.$this->wordemData[$i]->$wo.'")';
			}
			$cod = '$b_cond = ('.$cod.');';
		}
		else{
			$wo = $this->obj->_wordem;
			$cod = '$b_cond = ($this->wordemData[$i]->'.$wo.'=="'.$this->wordemData[$i]->$wo.'");';
		}
		while ($i>=0 and $i<count($this->dados)) {

			($sinal=='>') ? $i++ : $i--;
			eval($cod);
			if ($b_cond) {
				return true;
			}
		}

		return false;
	}

	function montaLink($vLink, $row) {
		$condicao = $vLink['3'] ? chamaFuncao($vLink['3'], array($row)) : true;

		if ($condicao) {
			while (($pos = strpos($vLink['0'], "{"))!==false) {
				$campo = substr($vLink['0'], $pos+1, strpos($vLink['0'], "}")-$pos-1);
				$vLink['0'] = str_replace("{".$campo."}", $row->$campo, $vLink['0']);
			}

			return '<a href="'.$vLink['0'].'" title="'.$vLink['2'].'">
						<img src="'.WPath::img($vLink['1'] ? $vLink['1'] : 'config_g.png').'" border="0" width="24" alt="'.$vLink['2'].'">
					</a>';
		}
	}

	function showHTML() {
		$totalColunas = count($this->campos) + 3;

		echo '
		    <form action="index.php" method="GET" name="adminForm" id="adminFormList">
		        <input type="hidden" name="option" id="option" value="'.WMain::$option.'" />
		        <input type="hidden" name="Adminid" id="adminid" value="'.WMain::$Adminid.'" />
		        <input type="hidden" name="task" id="task" value="listar" />';
		
		if($this->showFiltro){
			echo '<div class="form-filtro">
						<input type="text" name="search" id="search" value="'.$this->search.'" class="text_area" />
						<button id="bt-search">Buscar</button>
						<button id="bt-search-clear">Limpar Filtro</button>
						<br class="clr" />
					</div>';
		}
		
		echo '<div class="toolbar-lista"> &nbsp; </div>';
		echo '<br class="clr" />';
		
		echo '				
				<table class="adminlist">
					<thead>
						<tr>
				    		<th width="15" class="coluna-pequena"> Cód. </th>';
		if ($this->colCheck) {
					echo '<th width="20" class="coluna-pequena">
							<input type="checkbox" name="toggle" value="" onclick="checkAll('.$this->totalItens.');" />
						</th>';
		}

		$disableOrder = false;
		foreach ($this->campos as $campo) {
			if ($campo->is_ordering) {
				$disableOrder = true;
				break;
			}
		}
		foreach ($this->campos as $campo) {
			echo '<th '.($campo->width ? 'width="'.$campo->width.'"' : '').' class="title">';
			if (!$disableOrder and $campo->ordem) {
				echo '<a href="index.php?option='.WMain::$option.'&task='.WMain::$task.'&sortname='.str_replace('->', '.', $campo->campo).'">'.$campo->label.'</span>';
			} else {
				echo $campo->label;
			}
			echo '</th>';
		}

		echo '
							</tr>
					</thead>';

		if ($this->dados) {
			echo '<tfoot>
									<tr>
										<td colspan="'.$totalColunas.'">';
			$paginacao = new WAdminPaginacao($this->totalItens);
			$paginacao->show();
			echo '</td>
									</tr>
							  </tfoot>
							  <tbody>';

			foreach ($this->dados as $i => $linha) {
				$row = $this->dados[$i];

				echo '<tr class="row'. ($i % 2 == 0 ? 0 : 1) .'" id="row'.$row[id].'">
									<td width="15" align="center">'.$row[id].'</td>';
				if ($this->colCheck) {
					echo '<td width="20" align="center">
		                		<input type="checkbox" name="cid[]" value="'.$row[id].'" id="cb'.$i.'" />
	                		</td>';
				}
					
				foreach ($linha as $campo => $valor) {

					if ($campo!='id') {
							
						$col = $this->campos[$campo];
							
						$wo_isp = $wo_isu = true;

						if ($this->obj->_wordem) {
							$valWordem = WModel::getSQLWordem($this->obj->_wordem, $this->wordemData[$i]);

							if ($this->verificaWordem($i, '>')) {
								$wo_isu = false;
							}
							if ($this->verificaWordem($i, '<')) {
								$wo_isp = false;
							}
						} else {
							$wo_isp = $wo_isu = false;
							$valWordem = "";
						}

						$valor = $col->getValor($linha['id'],$this->rows[$i],count($this->rows),$campo,$valor,array($i,$valWordem,$wo_isp,$wo_isu));
							
						echo '<td align="'.$col->align.'" '.($col->is_ordering ? 'class="order"' : '').'>';
							
						if (strpos($valor, "<")!==false or !$this->linkEdita) {
							echo $valor;
						} else {
							echo '<a href="index.php?option='.WMain::$option.'&task=edit&cid[]='.$linha[id].'">'.$valor.'</a>';
						}

						echo '</td>';
					}
				}
					
				echo '
	            				</tr>';
			}

			echo '</tbody>';

		} else {
			echo '<tbody>
								<tr><td align="center" colspan="'.$totalColunas.'">Nenhum registro encontrado</td></tr>
							  </tbody>';
		}
			
		echo'
			</table>
		</form>';
	}

	function show($result=false) {
		$this->showHTML();
	}

}
?>