<?php

class WAdminPaginacao {

	public $pag = 1;
	public $total = 0;
	public $regPorPag = 10;
	public $totalPag = 1;
	public $limit = 0;
	public $offset = 0;

	function __construct($total="") {
		persiste("page");
		persiste("rp");

		$this->regPorPag = pega('rp', 10);
		$this->pag = pega('page', 1);

		if ($this->regPorPag) {
			$this->limit  = $this->regPorPag;
			$this->offset = ($this->pag - 1) * $this->regPorPag;
		}

		if ($total) {
			$this->total = $total;
			if ($this->regPorPag) {
				$this->totalPag = ceil($this->total/$this->regPorPag);
			}
		}
	}

	function show() {

		$link = 'index.php?option='.WMain::$option.'&task='.WMain::$task.'&Admind='.WMain::$Adminid;

		echo '<div class="pagination">

				<div class="limit-registros">Exibir #
					<select onchange="document.location.href = \''.$link.'&page=1&rp=\'+this.value" size="1" class="inputbox" name="rp">';

		$vRegPorPag = array(10, 15, 30, 50, 100, 'Tudo');
		foreach ($vRegPorPag as $reg) {
			$i = is_numeric($reg) ? $reg : 0;
			echo '<option value="'.$i.'" '.($i==$this->regPorPag ? 'selected="selected"' : '').'>'.$reg.'</option>';
		}

		echo '</select>
				</div>';

		
		if ($this->totalPag > 1) {

			echo '<div class="limit-pages">';
			
			if ($this->pag > 1) {
				echo '<div class="button2-right">
								<div class="start">
									<a href="'.$link.'&page=1" title="Início">Primeiros Registros</a>
								</div>
							</div>
							<div class="button2-right">
								<div class="prev">
									<a href="'.$link.'&page='.($this->pag-1).'" title="Anterior">Registros Anteriores</a>
								</div>
							</div>';	
			} else {
				echo '<div class="button2-right off">
							<div class="start"><span>Primeiros Registros</span></div>
						  </div>
						  <div class="button2-right off">
							<div class="prev"><span>Registros Anteriores</span></div>
						  </div>';
			}
			/*
			echo '<div class="button2-left">
							<div class="page">';

			$inicio = $this->pag > 3 ? $this->pag - 3 : 1;
			$fim = $inicio + 7;
			if ($fim > $this->totalPag) {
				$fim = $this->totalPag + 1;
				$inicio = $fim - 7 > 0 ? $fim - 7 : 1;
			}
				
			for ($i=$inicio; $i<$fim; $i++) {
				if ($this->pag==$i) {
					echo '<span>'.$i.'</span>';
				} else {
					echo '<a href="'.$link.'&page='.$i.'" title="Página '.$i.'">'.$i.'</a>';
				}
			}
				
			echo '</div>
						</div>';
			*/
				
				
			if ($this->pag < $this->totalPag) {
				echo '<div class="button2-left">
						<div class="next">
							<a href="'.$link.'&page='.($this->pag+1).'" title="Próximo">Próximos Registros</a>
						</div>
					</div>
					<div class="button2-left">
						<div class="end">
							<a href="'.$link.'&page='.$this->totalPag.'" title="Fim">Últimos Registros</a>
						</div>
					</div>';	
			} else {
				echo '<div class="button2-left off">
						<div class="next"> <span>Próximos Registros</span> </div>
					  </div>
					  <div class="button2-left off">
						<div class="end"><span>Últimos Registros</span></div>
					  </div>';
			}
			
			echo '</div>';
			
		}
			
		echo '<div class="limit-atual">página '.$this->pag.' de '.$this->totalPag.'</div>
			  <br class="clr" />
			</div>';
			
	}

}