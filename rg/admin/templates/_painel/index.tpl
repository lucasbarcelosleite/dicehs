<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>{site_name} - Painel de Administração</title>

<style type="text/css">
@import "{diradmin_css}/template_css.css";

@import "{diradmin_css}/themeoffice.css";

@import "{diradmin_css}/calendar-mos.css";

@import "{diradmin_css}/flexigrid.css";

@import "{diradmin_css}/jquery.mcdropdown.css";

@import "{diradmin_css}/jquery.treeview.css";

@import "{diradmin_css}/ui/ui.all.css";
</style>


<link rel="shortcut icon" href="{diradmin_img}/favicon.ico" />

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

<meta http-equiv="Content-Type" content="text/html;" />
<meta name="Generator" content="" />

</head>
<body>

{editor}
<div style="height: 100%; width: 100%;">

<div id="loading"><img src="{diradmin_img}/loadingAnimation.gif" />
<div>Carregando ...</div>
<br class="clr" />
</div>

<div id="component">
<div id="component-head">
<div id="component-title">
<div id="icon"><img src="{diradmin_img}/system_run.png" id="icone"
	width="32" height="32" /></div>
<h2 id="titulo">Painel de Controle</h2>
<br class="clr" />
<h3 id="subtitulo">&nbsp;</h3>
</div>
<div id="component-toolbar">{toolbar}</div>
<br class="clr" />
<div class="error">{mosmsg}</div>
</div>
<br class="clr" />
<div id="component-main">
<div id="resultArea"></div>
{main_bodyadmin}</div>
</div>

</div>

<div class="dialog" id="dialog-remove-idiomas">

<p>Selecione os idiomas abaixo para excluir os textos correspondentes:</p>
<!-- BEGIN DL_LANG --> <input type="checkbox" checked="checked"
	class="ck-lang" value="{id_lang}" /><img src="{imagem}" width="16"
	height="11" title="{nome}" alt="{nome}" /> {nome}<br />
<!-- END DL_LANG -->
<p class="msg"></p>
</div>
<div id="dialog" class="dialog" title="Dialog"></div>


</body>
</html>
