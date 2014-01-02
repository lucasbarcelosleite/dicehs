
<div class="row" id="evento-lista">

    <div class="span12">

    <!-- BEGIN EVENTO_1_CONTAINER -->
    <div id="showcase">
        <div class="container">
            <div class="section_header">
                <h3>Pr&oacute;ximos Eventos</h3>
            </div>            
            <!-- BEGIN EVENTO_1_ITEM -->
            <div class="row feature lista-destacada">
                <div class="span6">
                    <a href="{evento_link}"><img src="{evento_img}" /></a>
                </div>
                <div class="span6 info">
                    <h3><a href="{evento_link}">{evento_titulo}</a></h3>
                    <p>
                        <b>{evento_data} ({evento_dia_semana}), as {evento_hora}</b> <br />
                        <a href="{evento_link}">{evento_chamada}</a>
                    </p>
                    <a class="ver-mais" href="{evento_link}">Ver Mais</a>
                </div>
            </div>
            <!-- END EVENTO_1_ITEM -->
            
        </div>
    </div>
    <!-- END EVENTO_1_CONTAINER -->

    </div>
    

    <!-- BEGIN EVENTOS_REALIZADOS_CONTAINER -->
    <div class="span8">
        <div class="section_header">
            <h3>Eventos Realizados</h3>
        </div>            
        <!-- BEGIN EVENTO_REALIZADO_ITEM -->
        <div class="bloco-evento-1-real">
            <div class="imagem">
                <a href="{evento_link}">
                    <img src="{evento_img}" width="150" />
                </a>
            </div>
            <div class="texto">
                <h4><a href="{evento_link}">{evento_titulo}</a></h4>
                <p>Realizado em {evento_data}</p>
                <a href="{evento_link}">Ver Report do Evento</a>
            </div>
            <br class="clear" />
        </div>
        <!-- END EVENTO_REALIZADO_ITEM -->
    </div>
    <!-- END EVENTOS_REALIZADOS_CONTAINER -->       

   <!-- BEGIN EVENTO_2_CONTAINER -->
    <div class="{classe_regulares}">
        <div class="section_header">
            <h3>Eventos Regulares</h3>
        </div>

        <!-- BEGIN EVENTO_2_ITEM -->
        <div class="bloco-evento-2">
            <h6><a href="{evento_link}">{evento_titulo}</a></h6>
            <b>{evento_dia_hora_permanente}</b>
            <p>{evento_chamada}</p>
        </div>
        <!-- END EVENTO_2_ITEM -->
    </div>
    <!-- END EVENTO_2_CONTAINER --> 
</div>