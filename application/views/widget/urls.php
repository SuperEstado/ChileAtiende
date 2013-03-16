<div class="breadcrumbs" style="margin: 0 0 20px 17px;"><a href="<?= site_url('/') ?>">Portada</a> / <a href="<?=site_url('widget')?>">ChileAtiende en tu sitio</a> / URLs GobiernoTransparente</div>

<h2 class="oficinas">URLs GobiernoTransparente</h2>
<div class="clearfix">&nbsp;</div>

<table class="oficinas">
    <tr>
        <th>Servicio</th>
        <th>URL</th>

    </tr>
    <?php
    foreach ($servicios as $s) {
        ?>
        <tr>
            <td><?= $s->nombre ?></td>
            <td><a href="<?=$s->sigla? site_url('transparencia/'.$s->sigla) : site_url('servicios/ver/'.$s->codigo) ?>"><?=$s->sigla? site_url('transparencia/'.$s->sigla) : site_url('servicios/ver/'.$s->codigo) ?></a></td>
        </tr>
        <?php
    }
    ?>
</table>

<div class="clearfix">&nbsp;</div>
