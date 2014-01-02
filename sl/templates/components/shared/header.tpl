<header id="header">
	<div class="wrapper">
		<h1 class="logo"><a class="sprite ir" href="{live_site}" title="Clique para ir para a página inicial">{tl_titulo_pagina}</a></h1>
		<div class="contato">
			<a class="ligue sprite ir" href="{url_contato}">
				Ligue<span>{tl_telefone}</span><br>
			</a>
			<a class="visite sprite ir" href="{url_contato}">Visite a loja</a>
		</div>
		<br class="clear">
	</div>
	<div id="navigation">
		<div class="wrapper">
			<nav id="nav">
				<h1 class="hide">Navegação principal do site</h1>
				<ul class="menu">
					<!-- BEGIN MENU_ITEM -->
					<li class="nivel1 {class_parent}">
						<a class="item1" href="{link_n1}"><span>{titulo_n1}</span></a>
						<!-- BEGIN TEM_FILHOS -->
						<ul class="submenu">
							<!-- BEGIN MENU_ITEM_FILHO -->		
							<li class="nivel2"><a class="bg-left" href="{link_n2}"><span class="bg-right"><span class="item2">{titulo_n2}</span></span></a></li>
							<!-- END MENU_ITEM_FILHO -->									
						</ul>
						<!-- END TEM_FILHOS -->
					</li>
					<!-- END MENU_ITEM -->
				</ul>
			</nav>
			
			<form class="form-search" action="{url_busca}" method="get">
				<input class="field-search sprite" type="text" name="q" placeholder="Busca" title="Digite aqui o que você procura">
				<input class="bt-search sprite" type="submit" name="bt_buscar" value="" title="Clique aqui para efetuar sua busca">
			</form>
			
			<br class="clear">
		</div>
	</div>
</header>

