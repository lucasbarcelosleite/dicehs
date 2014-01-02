<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>

<title>{site_name} - op64 content management system</title>

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
{inc_js} 
{editor}

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" href="{diradmin_css}/base.css">
<link rel="stylesheet" href="{diradmin_css}/style.css">

</head>
<body>

<div id="layout">
	<div id="login">

		<!-- BEGIN MSG_ERRO -->
		<div class="erro-padrao">{msg_login}</div>
		<!-- END MSG_ERRO -->

		<div id="selo-login">			
			<h1>{site_name}</h1>
			<h2>Painel de Administração</h2>
		</div>
		<div id="form-login">
		
			<form action="index.php" method="post">
			
				<label title="Usuário">Usuário</label>
				<input class="form-padrao" type="text" name="login" value="{login}" />
				
				<label title="Senha">Senha</label>
				<input class="form-padrao" type="password" name="senha" />
				
				<input class="botao-padrao" type="submit" value="Entrar " alt="Entrar" title="Entrar" />
				
				<input type="hidden" name="submit" class="button" value="Autenticar" />
				<input type="hidden" name="task" value="login" />
			
			</form>
			
		</div>
		
		<br class="clr" />


		
	</div>
	
</div>

</body>
</html>


