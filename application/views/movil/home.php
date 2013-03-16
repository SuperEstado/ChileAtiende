<div data-role="fieldcontain">
    <form action="<?= site_url('movil/buscar') ?>" method="post" id="main_search">
        <input type="search" name="buscar" id="search" value="" />
    </form>
</div>
<div data-role="collapsible">
    <h3>Destacados</h3>
    <?php foreach ($fichas_destacadas as $ficha): ?>
        <p><?= anchor("movil/fichas/ver/" . $ficha->maestro_id, $ficha->titulo, "class='resultado_more_info'") ?></p>
    <?php endforeach; ?>
</div>
<div data-role="collapsible">
    <h3>Más Vistos</h3>
    <?php foreach ($fichas_mas_vistas as $ficha): ?>
        <p><?= anchor("movil/fichas/ver/" . $ficha->maestro_id, $ficha->titulo, "class='resultado_more_info'") ?></p>
    <?php endforeach; ?>
</div>