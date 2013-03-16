<div id="sidebar" class="right clearfix">
		<div class="telefono">
      <h2>Call Center ChileAtiende</h2>
      <p class="telefonoCHA"><img src="<?= site_url('assets/images/tel.png') ?>" width="11" height="28" alt="Icono telefono" />101</p>
      </div>
    <h2>Temas Sugeridos</h2>
    <?php  fichasRender($fichasDestacadas); ?>

    <?php if(isset($fichasRelacionadas)): ?>
    <h2>Trámites Relacionados</h2>
    <?php fichasRender($fichasRelacionadas); ?>
    <?php endif; ?>

    <h2>Más Vistos Esta Semana</h2>
    <?php fichasRender($fichasMasVistas); ?>

    <h2>Mejor Calificados</h2>
    <?php fichasRender($fichasMasVotadas); ?>

</div>

<?php

function fichasRender($fichas) {
    if (count($fichas) > 0)
        foreach ($fichas as $ficha) {
            echo '<dl><dt>';
            echo "<a href='" . site_url('fichas/ver/' . $ficha->maestro_id ). "'>" . $ficha->titulo . "</a>";
            echo '</dt><dd>' . mb_substr(strip_tags($ficha->objetivo), 0, 150) . '...</dd></dl>';
        }
}
?>