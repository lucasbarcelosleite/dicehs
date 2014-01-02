
<div class="row">

    <div class="span12">
        
        
    </div>

    <div class="span4">
        <img src="{imagem}" />
    </div>
    <div class="span8">

        <div class="bloco-liga">
            <i class="icon icon-tasks"></i> Ranking da Liga <b><a href="{liga_url}">{liga_nome}</a></b>
        </div>
        <h3>Rodada {rodada}, em {data}</h3>
        {texto_report}
    </div>
    
    <br class="clear" />

    <div class="span4">
        <br />
        <h4 class="titulo-interno">Entenda a Classifica&ccedil;&atilde;o</h4>
        {liga_texto}
    </div>
    <div class="span8 ranking-table liga-{id_liga}">
        <br />
        <h4 class="titulo-interno">Classifica&ccedil;&atilde;o do Ranking, Rodada {rodada}</h4>

        {texto_ranking}
    </div>
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