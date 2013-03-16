<div id="content" class="clearfix">
    <div id="maincontent" class="left clearfix">
        <h2 class="title"><?= $entidad->nombre ?></h2>
        <p><?=$entidad->sigla?></p>
        <p><a target="_blank" href="<?=$entidad->url?>"><?=$entidad->url?></a></p>
        <hr class="shadow" />


        <h3 class="first_topic">Misión Institucional</h3>
        <p><?= $entidad->mision ?></p>
        <hr class="hidden" />
        <h3>Servicios y/o beneficios que entrega la institución</h3>
        <ul data-role="listview" data-inset="true">
        <?php foreach($fichas as $f):?>
            <li><a href="<?=site_url('movil/fichas/ver/'.$f->Maestro->id)?>"><?=$f->titulo?></a></li>
        <?php endforeach; ?>
        </ul>

    </div>
</div>