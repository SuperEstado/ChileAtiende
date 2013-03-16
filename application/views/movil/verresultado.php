<div data-role="fieldcontain">
    <form action="<?= site_url('movil/buscar') ?>" method="post" id="main_search">
        <input type="search" name="buscar" id="search" value="" />
    </form>
</div>
<?php
if (isset($fichas_busqueda)) {
    echo '<ul data-role="listview" data-inset="true">';
    foreach ($fichas_busqueda as $ficha) {
        echo "<li>" . anchor("movil/fichas/ver/" . $ficha->maestro_id, $ficha->titulo, "class='resultado_more_info'") . "</li>";
    }
    echo '</ul>';
} else {
    echo "<p>Sin resultados</p>";
}
?>