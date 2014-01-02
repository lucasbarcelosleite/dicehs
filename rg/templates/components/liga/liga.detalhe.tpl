
<div class="row">

    <div class="span6">
       <h3 class="titulo">{nome}</h3>    
        {texto}

        <h4>Premia&ccedil;&atilde;o</h4>
        {texto_premiacao}
    </div>
    
    <div class="span6">
        <h4 class="titulo-interno">Rodadas</h4>

        <ul id="ranking-mosaico">
            <!-- BEGIN RANK_ITEM -->
            <li>
                <a href="{link}">
                    <img src="{imagem}" width="100" />
                    #{rodada} ({data})
                </a>
            </li>
            <!-- END RANK_ITEM -->    
            <br class="clear" />
        </ul>
    </div>
</div>