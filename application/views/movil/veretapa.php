
<ul data-role="listview" data-inset="true" class="margen">
    <?php foreach($etapas as $e):?>
    <li>
        <h3><a href="<?=site_url('movil/etapas/ver/'.$e->id)?>"><?=$e->nombre?></a></h3>
        <p><?=$e->descripcion?></p>
    </li>
    <?php endforeach; ?>
</ul>
