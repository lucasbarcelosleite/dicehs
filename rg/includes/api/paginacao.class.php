<?

class WPaginacao {

	var $pag;
	var $total;
	var $totalPag;
	var $regPorPag;
	var $link;
	var $classAtual = "txt-bold";
	var $semLink = 'javascript:void(0)';

	var $limit;
	var $offset;
	var $maxPaginas = 5;

	function __construct($total, $regPorPag="") {
		$this->regPorPag = $regPorPag ? $regPorPag : WConfig::$regPorPag;
		$this->pag = pega("pag", 1);
		$this->calcLimit($total);
	}

	private function calcLimit($total) {
		$this->total    = $total;
		$this->totalPag = ceil($this->total/$this->regPorPag);

		if (pega("pag")=="ultima") {
			$this->pag = $this->totalPag;
		}
		if (pega("pag")=="primeira") {
			$this->pag = 1;
		}

		$this->limit  = $this->regPorPag;
		$this->offset = ($this->pag - 1) * $this->regPorPag;
	}

	function getHtml($link="", $tpl="paginacao") {

		if (!$link) {
			$this->link = LIVE.WSEOUrl::$atualNew;
			if (($pos = strpos($this->link, "?pag="))!==false) {
				$this->link = substr($this->link, 0, $pos);
			}
		} else {
			$this->link = $link;
		}

		$this->totalPag = ceil($this->total/$this->regPorPag);

		if ($this->totalPag > 1) {
			$tpl = new WTemplate(WPath::tpl($tpl));
			$l_max = ceil($this->maxPaginas/2)-1;
			$r_max = $this->maxPaginas-$l_max-1;

			$this->link .= ( ( strpos($this->link,'&') || strpos($this->link,'=') ) ? '&' : (strpos($this->link,'?') ? '' : '?') ) . 'pag=';

			$tpl->link_primeira = ($this->pag>1) ? $this->link."primeira" : $this->semLink;
			$tpl->link_anterior = ($this->pag>1) ? $this->link.($this->pag-1) : $this->semLink;
			$tpl->link_proxima  = ($this->pag<$this->totalPag) ? $this->link.($this->pag+1) : $this->semLink;
			$tpl->link_ultimo   = ($this->pag<$this->totalPag) ? $this->link."ultima" : $this->semLink;
				
			$tpl->pag_proxima  = ($this->pag<$this->totalPag) ? $this->pag+1 : $this->totalPag;
			$tpl->pag_anterior = ($this->pag>1) ? $this->pag-1 : 1;
			$tpl->pag_ultima = $this->totalPag;
			$tpl->pag_primeira = 1;

			if (($this->pag > $l_max+1) and ($this->totalPag-$this->pag >= $r_max)) {
				for ($i=$l_max-1; $i>=0; $i--) {
					$tpl->pag       = $this->pag-$i-1;
					$tpl->link_pag  = $this->link.$tpl->pag;
					$tpl->pag_atual = "";
					//$tpl->parseBlock("PAGITEM_SEPARADOR");
					$tpl->parseBlock("PAGITEM");
				}

				$tpl->pag       = $this->pag;
				$tpl->link_pag  = $this->semLink;
				$tpl->pag_atual = $this->classAtual;
				if ($i+1 < $this->maxPaginas) {
					//$tpl->parseBlock("PAGITEM_SEPARADOR");
				}
				$tpl->parseBlock("PAGITEM");

				for ($i=1; $i<($r_max+1); $i++) {
					$tpl->pag = $this->pag+$i;
					$tpl->pag_atual = "";
					$tpl->link_pag = $this->link.$tpl->pag;
					if ($i+1 < $r_max+1) {
						//$tpl->parseBlock("PAGITEM_SEPARADOR");
					}
					$tpl->parseBlock("PAGITEM");
				}

			} else {
				$max_pag = $r_max+$l_max+1;

				if (($this->totalPag-$this->pag < $r_max) and ($this->totalPag > $max_pag)) {
					$inicio = $this->totalPag-$max_pag+1;
					$fim    = $this->totalPag;
				} else {
					$inicio = 1;
					$fim    = min($max_pag, $this->totalPag);
				}

				for ($i=$inicio; $i<=$fim; $i++) {
					$tpl->pag = $i;
					if ($this->pag==$tpl->pag) {
						$tpl->link_pag  = $this->semLink;
						$tpl->pag_atual = $this->classAtual;
					} else {
						$tpl->link_pag  = $this->link.$tpl->pag;
						$tpl->pag_atual = "";
					}
						
					if ($tpl->pag < $fim) {
						//$tpl->parseBlock("PAGITEM_SEPARADOR");
					}
					$tpl->parseBlock("PAGITEM");
				}
			}
			return $tpl->getContent();
		}
	}

	function show($link="", $tpl="") {
		echo $this->getHtml($link, $tpl);
	}
}

?>