<div class="breadcrumbs" style="margin: 0 0 20px 17px;"><a href="<?= site_url('/') ?>">Portada</a> / Sucursales ChileAtiende</div>

<h2 class="oficinas">Sucursales ChileAtiende</h2>
<div class="exportar"><a href="<?=  site_url('oficinas/exporta/xml') ?>" title="Exportar a XML"><img alt="Exportar a XML" src="assets/images/xml.png" /></a> <a href="<?=  site_url('oficinas/exportacsv') ?>" title="Exportar a CSV"><img alt="Exportar a CSV" src="assets/images/csv.png" /></a></div>
<div class="clearfix">&nbsp;</div>
<?php
$flecha_nombre = '';
$flecha_comuna = '';
if( (strpos($order_by, "sector_codigo") === FALSE) ) {
    $orden_nombre = (strpos($order_by, "ASC") === FALSE) ? "ASC" : "DESC";
    $flecha_nombre = site_url( ($orden_nombre=='ASC') ? 'assets/images/backend/arrow_down.png' : 'assets/images/backend/arrow_up.png' );
    $orden_comuna = 'ASC';
} else {
    $orden_nombre = 'DESC';
    $orden_comuna = (strpos($order_by, "ASC") === FALSE) ? "ASC" : "DESC";
    $flecha_comuna = site_url( ($orden_comuna=='ASC') ? 'assets/images/backend/arrow_down.png' : 'assets/images/backend/arrow_up.png' );
}
?>
<table class="oficinas">
    <tr>
        <th><a href="<?= site_url('oficinas/index/o.sector_codigo/'.$orden_comuna.'/'.$offset) ?>">Comuna <?= ($flecha_comuna) ? '<img src="'.$flecha_comuna.'" alt="" />' : '' ?></a></th>
        <th><a href="<?= site_url('oficinas/index/o.nombre/'.$orden_nombre.'/'.$offset) ?>">Sucursal <?= ($flecha_nombre) ? '<img src="'.$flecha_nombre.'" alt="" />' : '' ?></a></th>
        <th>Dirección</th>
        <th>Horario Atención</th>
        <th nowrap="nowrap">Ver Mapa</th>
    </tr>
    <?php
    foreach ($oficinas as $o) {
        ?>
        <tr>
            <td nowrap="nowrap"><?= $o->Sector->nombre ?></td>
            <td><?= $o->nombre ?></td>
            <td><?= $o->direccion ?></td>
            <td><?= $o->horario ?></td>
            <td><a href="<?=  site_url('/') ?>#id=<?= $o->id ?>&amp;lat=<?=$o->lat?>&amp;lng=<?=$o->lng?>" id="oficinaid-<?= $o->id ?>" class="pickoficina icomap" rel="#map" title="Ver en Mapa">Ver</a></td>
        </tr>
        <?php
    }
    ?>
</table>
<div class="paginacion margen_derecho">
    <?php
    if ($total > $per_page) {
        $finpag = floor($total / $per_page) * $per_page;
        $finpag = ($finpag == $total) ? $finpag - 10 : $finpag;
        $siguiente = ( ( ($offset + $per_page) > $total ) ? $offset : $offset + $per_page );
        $anterior = ( ( ($offset + $per_page) < $total ) ? ( ($offset <= 0) ? 0 : ($offset - $per_page) ) : ( ($offset <= 0) ? 0 : ($offset - $per_page) ) );
        ?>
        <?= $offset + 1 ?>-<?= ( ($offset + $per_page) > $total ) ? $total : $offset + $per_page ?> de <?= $total ?> | <a href="<?= $base_url . '/0' ?>">&lt; Inicio</a> | <a href="<?= $base_url . '/' . $anterior ?>">&lt;&lt; Anterior</a> | <a href="<?= $base_url . '/' . $siguiente ?>">Siguiente &gt;&gt;</a> | <a href="<?= $base_url . '/' . $finpag ?>">Fin &gt;</a>
        <?php
    }
    ?>
</div>
<div class="clearfix">&nbsp;</div>
<?php
$this->load->view("modal/mapa_oficina");
?>