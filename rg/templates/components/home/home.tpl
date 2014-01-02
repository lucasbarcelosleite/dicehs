<section id="feature_slider" class="">
     <!-- BEGIN DESTAQUES_MOD_1 -->
     <article class="slide" id="ideas" style="background: url('{imagem}') repeat-x top center;">
        <div class="info">
            <h2>{titulo}</h2>
            <!-- BEGIN DESTAQUES_MOD_1_LINK -->
            <a href="{url}">Veja Mais</a>
            <!-- END DESTAQUES_MOD_1_LINK -->
        </div>
    </article>
    <!-- END DESTAQUES_MOD_1 -->

    <!-- BEGIN DESTAQUES_MOD_2 -->
    <article class="slide" id="showcasing" style="background: url('{imagem}') repeat-x top center;">
        <div class="info">
            <h2>{titulo}</h2>
            <!-- BEGIN DESTAQUES_MOD_2_LINK -->
            <a href="{url}">Veja Mais</a>
            <!-- END DESTAQUES_MOD_2_LINK -->
        </div>
    </article>
    <!-- END DESTAQUES_MOD_2 -->
   
    <!-- BEGIN DESTAQUES_MOD_3 -->
    <article class="slide" id="tour" style="background: url('{imagem}') repeat-x top center;">
        <div class="info">
            <h2>{titulo}</h2>
            <!-- BEGIN DESTAQUES_MOD_3_LINK -->
            <a href="{url}">Veja Mais</a>
            <!-- END DESTAQUES_MOD_3_LINK -->
        </div>
    </article>
    <!-- END DESTAQUES_MOD_3 -->       
</section>

<!-- BEGIN EVENTO_1_CONTAINER -->
<div id="showcase">
    <div class="container">
        <div class="section_header">
            <h3>Pr&oacute;ximos Eventos</h3>
            <a href="{liga_ver_mais}" class="ver-mais">Ver mais eventos</a>
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




<!-- BEGIN LIGA_ITEM -->
<div id="showcase">
    <div class="container">
        <div class="section_header">
            <h3>{liga_nome}</h3>
            <a href="{liga_ver_mais}" class="ver-mais">Ver mais rodadas e informa&ccedil;&otilde;es</a>
        </div>            
        <div class="row feature_wrapper">
            <div class="features_op1_row">
                <!-- BEGIN RANK_ITEM -->
                <div class="span4 feature {rank_class}">
                    <div class="img_box">
                        <a href="{rank_link}">
                            <img src="{rank_img}">
                            <span class="circle"> 
                                <span class="plus">&#43;</span>
                            </span>
                        </a>
                    </div>
                    <div class="text">
                        <h6><a href="{rank_link}">Rodada {rank_rodada} em {rank_data}</a></h6>
                        <p>
                            <a href="{rank_link}">{rank_chamada}</a>
                        </p>
                    </div>
                </div>
                <!-- END RANK_ITEM -->
            </div>
        </div>
    </div>
</div>
<!-- END LIGA_ITEM -->

<div id="in_pricing">
    <div class="container">
        <div class="section_header">
            <h3>Artigos e Not&iacute;cias</h3>
            <a href="{pub_ver_mais}" class="ver-mais">Ver mais artigos e not&iacute;cias</a>
        </div>

        <!-- BEGIN PUBLICACAO_CONTAINER -->
        <div class="row charts_wrapp">
            <!-- BEGIN PUBLICACAO_ITEM -->
            <div class="span4">
                <div class="plan">
                    <div class="wrapper">
                        <small>{pub_data}</small>
                        <a href="{cat_link}"><span class="label label-{cat_class}">{cat_nome}</span></a>

                        <h3><a href="{pub_link}">{pub_titulo}</a></h3>

                        
                        <br /><a href="{pub_link}"><img src="{pub_img}" /></a>
                        <div class="features">
                            <p>{pub_chamada}</p>
                        </div>
                        <a class="order" href="{pub_link}">Ver Mais</a>
                    </div>
                </div>
            </div>
            <!-- END PUBLICACAO_ITEM -->
        </div>
        <!-- END PUBLICACAO_CONTAINER -->
    </div>
</div> 