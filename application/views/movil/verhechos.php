
<div data-role="content" data-theme="c">
    <div class="ui-grid-b">
        <div class="ui-block-a"><span class="titulo"><?=$etapa->nombre?></span><br>
            <span class="edad"><?=$etapa->descripcion?></span>
        </div>
    </div>
    <ul data-role="listview" data-inset="true">
        <?php foreach($etapa->HechosVida as $h):?>
        <li><a href="<?=site_url('movil/hechos/ver/'.$etapa->id.'/'.$h->id)?>"><?=$h->nombre?></a></li>
        <?php endforeach; ?>
    </ul>
</div>
