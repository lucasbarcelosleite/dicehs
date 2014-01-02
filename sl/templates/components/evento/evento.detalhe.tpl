
<div class="row" id="evento-detalhe">

    <div class="span4">
        <img src="{imagem}" />
    </div>
    <div class="span8">

        <h4>{titulo}</h4>

        <!-- BEGIN POSSUI_LIGA -->
        <div class="bloco-liga">
            <i class="icon icon-tasks"></i> Evento v&aacute;lido pela <b><a href="{liga_url}">{liga_nome}</a></b>
        </div>        
        <!-- END POSSUI_LIGA -->

        <!-- BEGIN POSSUI_FORMATO -->
        <div class="place"><i class="icon icon-leaf"></i> <span><b>Formato</b>: {formato_nome}</span></div>
        <!-- END POSSUI_FORMATO -->

        <!-- BEGIN TIPO_EVENTO_PONTUAL --> 
            <!-- BEGIN EVENTO_ANUNCIO -->
            <div class="date"><i class="icon icon-calendar"></i> Dia {data} ({dia_semana}), as {hora}</div>
            <div class="place"> <i class="icon icon-home"></i> <span><b>Onde?</b> {endereco_dice}</span></div>

            <h6>An&uacute;ncio do Evento</h6>
            {texto_anuncio}
            <!-- END EVENTO_ANUNCIO -->

            <!-- BEGIN EVENTO_REALIZADO -->
            <h5 class="date">Realizado dia {data}, as {hora}</h5>

            <h6>Report do Evento</h6>
            {texto_report}

                <!-- BEGIN POSSUI_RANKING -->
                <p><a href="{ranking_url}">Confira o Ranking deste Evento!</a></p>
                <!-- END POSSUI_RANKING -->

            <!-- END EVENTO_REALIZADO -->

        <!-- END TIPO_EVENTO_PONTUAL -->

        <!-- BEGIN TIPO_EVENTO_REGULAR --> 
        <h5>{dia_hora_semana}</h5>

        {texto_anuncio}
        <!-- END TIPO_EVENTO_REGULAR -->

        <!-- BEGIN POSSUI_PREMIACAO -->
        <h6>Premia&ccedil;&atilde;o</h6>
        {texto_premiacao}
        <!-- END POSSUI_PREMIACAO -->
    </div>
    
    <br class="clear" />

</div>


<div class="row">
    <div class="span4">
        &nbsp;
    </div>
    <div class="span8">
        <h6 class="titulo-interno">Coment&aacute;rios</h6>
        <div class="fb-comments" data-href="{pg_atual}" data-numposts="5" data-colorscheme="light"></div>
    </div>
</div>