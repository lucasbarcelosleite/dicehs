<input type="hidden" name="upload_flash" value="1" />

<fieldset class="box-midia"
	lang="{tipo}"><input type="hidden" name="_nro_{tipo}" class="nro"
	value="{ind}"> <legend><img src="{diradmin_img}/menu/{label_img}"
	align="left" />&nbsp; {label_txt}</legend> <input
	class="f-right add-midia" type="button" value="Adicionar {tipo}"
	alt="Adicionar" title="Adicionar"> <br class="clr" />

<div class="{tipo}-conteudo clone box hide">
<div class="coluna-padrao nro-show">Item <b>#0#</b></div>
<div class="f-left"><input class="rem-midia" type="button"
	value="Remover" lang=""></div>
<br class="clr" />
<br />

<input class="input-mg tam-original {hide_arquivo}" type="checkbox"
	value="1" name="is_original_{tipo}_#0#" alt="Manter Tamanho Original" />
<div class="text-mg {hide_arquivo}">Manter tamanho original</div>
<br class="clr {hide_arquivo}" />
<div class="coluna-padrao"><label class="f-left">T�tilo</label><input
	class="f-left campo-grande" type="text" name="descricao_{tipo}_#0#" /><br
	class="clr" />
</div>
<div class="coluna-padrao tam-not-original {hide_arquivo}"><label
	class="f-left">Largura</label><input class="f-left campo-pequeno"
	value="{width}" type="text" name="width_{tipo}_#0#" /><br class="clr" />
</div>
<div class="coluna-padrao tam-not-original {hide_arquivo}"><label
	class="f-left">Altura</label><input class="f-left campo-pequeno"
	value="{height}" type="text" name="height_{tipo}_#0#" /><br class="clr" />
</div>
<br class="clr" />

<div class="upload">
<div id="input_{tipo}_#0#_principal">
<div id="upload-{tipo}_#0#">Problemas com javascript</div>
<br />
<div id="hide-id-{tipo}_#0#"></div>
</div>
<input type="hidden" name="{tipo}_#0#_remove" value="0"> <input
	type="hidden" name="{tipo}_#0#_anterior" value=""></div>

<div class="separador-horizontal-mod1">&nbsp;</div>

<input type="hidden" name="id_{tipo}_#0#"> <input type="hidden"
	name="id_main_#0#"> <input type="hidden" name="id_lang_#0#"></div>
<!-- BEGIN UPLOAD -->
<div class="{tipo}-conteudo box">
<div class="coluna-padrao nro-show">Item <b>{ind}</b></div>
<div class="f-left"><input class="rem-midia" type="button"
	value="Remover" lang="remover_{tipo}_{ind}();"></div>
<br class="clr" />
<br />

<input class="input-mg tam-original {hide_arquivo}" type="checkbox"
	value="1" name="is_original_{tipo}_{ind}" alt="Manter Tamanho Original" {checked} />
<div class="text-mg {hide_arquivo}">Manter tamanho original</div>
<br class="clr {hide_arquivo}" />
<div class="coluna-padrao"><label class="f-left">T�tulo</label><input
	class="f-left campo-grande" type="text" value="{descricao}"
	name="descricao_{tipo}_{ind}" /><br class="clr" />
</div>
<div class="coluna-padrao tam-not-original {hide_arquivo} {hide}"><label
	class="f-left">Largura</label><input class="f-left campo-pequeno"
	type="text" value="{width}" name="width_{tipo}_{ind}" /><br class="clr" />
</div>
<div class="coluna-padrao tam-not-original {hide_arquivo} {hide}"><label
	class="f-left">Altura</label><input class="f-left campo-pequeno"
	type="text" value="{height}" name="height_{tipo}_{ind}" /><br
	class="clr" />
</div>
<br class="clr" />

<div class="upload">{botao_upload}</div>

<div class="separador-horizontal-mod1">&nbsp;</div>

<input type="hidden" name="id_{tipo}_{ind}" value="{id_conteudo_midia}">
<input type="hidden" name="id_main_{ind}" value="{id_main}"> <input
	type="hidden" name="id_lang_{ind}" value="{id_lang}"></div>
<!-- END UPLOAD --></fieldset>
