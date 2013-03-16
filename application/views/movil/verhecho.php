
<div id="hecho" data-role="content" data-theme="c">
    <div class="ui-grid-b">

        <div class="ui-block-a"><span class="titulo"><?=$etapa->nombre?></span><br>
            <span class="edad"><?=$etapa->descripcion?></span>
        </div>

        <div class="ui-block-b">&nbsp;</div>
        <div class="ui-block-c"><span class="titulo2"><?=$hecho->nombre?></span><br>
        </div>
    </div>
    <ul data-role="listview" data-inset="true">
        <?php foreach($fichas as $f): ?>
        <li><a href="<?=site_url('movil/fichas/ver/'.$f->Maestro->id)?>"><?=$f->titulo?></a></li>
        <?php endforeach; ?>
    </ul>
</div>
