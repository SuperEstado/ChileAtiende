<div class="breadcrumbs" style="margin: 0 0 20px 17px;"><a href="<?= site_url('/') ?>">Portada</a> / Empresa y Organizaciones</div>

<h2 class="empresas">Empresas y Organizaciones</h2>

<ul class="empresas">
<?php foreach ($empresas->ChileclicTemas as $t):?>

    <li>
        <h2><?=$t->nombre?></h2>
        <ul>
        <?php foreach($t->ChileclicSubtemas as $s): ?>
            <?php
            $total = count($s->Fichas);
            if($total):
            ?>
            <li><a href="<?=site_url('empresas/subtemas/'.$s->id)?>"><?=$s->nombre?> (<?=$total?>)</a></li>
            <?php endif; ?>
        <?php endforeach;?>
        </ul>
    </li>

<?php endforeach; ?>
</ul>