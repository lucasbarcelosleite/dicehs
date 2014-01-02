<html>
<head>

<title>{site_name} - Painel de Administração - op64 content management system</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<script type="text/javascript">
    var $live_site = "{live_site}";
    var $dir_img = "{dir_img}";
    var $dir_js  = "{dir_js}";
    var $dir_css = "{dir_css}";
    var $dir_flash = "{dir_flash}";
    var $diradmin_img = "{diradmin_img}";
    var $diradmin_js  = "{diradmin_js}";
    var $diradmin_css = "{diradmin_css}";
    var $diradmin_flash = "{diradmin_flash}";
    var $Adminid = "{Adminid}";
    var $option = "{option}";    
</script>

<script type="text/javascript" src="{diradmin_js}/lib/jquery-1.3.1.min.js"></script>
<script type="text/javascript" src="{diradmin_js}/lib/jquery.autocomplete.js"></script>
<script type="text/javascript" src="{diradmin_js}/lib/jquery.form.js"></script>
<script type="text/javascript" src="{diradmin_js}/lib/jquery.ifixpng.js"></script>
<script type="text/javascript" src="{diradmin_js}/lib/jquery.maskedinput-1.2.2.pack.js"></script>
<script type="text/javascript" src="{diradmin_js}/lib/jquery.metadata.js"></script>
<script type="text/javascript" src="{diradmin_js}/lib/jquery.rightClick.js"></script>
<script type="text/javascript" src="{diradmin_js}/lib/jquery.uploadify.js"></script>
<script type="text/javascript" src="{diradmin_js}/functions.admin.js"></script>

{editor}

<link rel="stylesheet" href="{diradmin_css}/base.css">
<link rel="stylesheet" href="{diradmin_css}/style.css">

</head>
<body>

<div id="layout">
	<div id="bar">
		<div id="logo">
			<b>{site_name}</b> - Painel de Administração
		</div>
		<div id="menu-apoio">
			<ul>
				<li><label>Usuário:</label> {nome_usuario}</li>
				<li><a href='{live_site}' target="_blank">Visualizar o site</a></li>
				<li><a href="index.php?task=logout">Sair</a></li>			
		</div>		
	</div>	
	<div id="menu">
		<ul class="menu-container">
			<!-- BEGIN MENU_ITEM_P0 -->
			<li class="parent0"><span>{p0_titulo}</span></li>
				<!-- BEGIN MENU_BLOCO_P1 -->
				<li class="parent1">		
					<ul>
						<!-- BEGIN MENU_ITEM_P1 -->
						<li {menu_ativo}><a href="{p1_url}">{p1_titulo}</a></li>	
						<!-- END MENU_ITEM_P1 -->
					</ul>	
				</li>
				<!-- END MENU_BLOCO_P1 -->
			<!-- END MENU_ITEM_P0 -->
			
		</ul>	
	</div>
	<div id="content">
		<div id="header">
			<h1>Titulo da Pagina</h1>
			<h2>Subtítulo da Pagina</h2>
		</div>
		<div id="toolbar">
			{toolbar}
		</div>
		<br class="clr" />
		
		<div id="main">
			<div class="error">{mosmsg}</div>
			<div id="resultArea"></div>		
			{main_bodyadmin}
		</div>		
	</div>
	
	<div id="dialog" class="dialog" title="Dialog"></div>	
</div>

</body>
</html>