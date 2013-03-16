
<div class="breadcrumbs" style="margin: 0 0 20px 17px;"><a href="<?= site_url('/') ?>">Portada</a> / Listado de Instituciones</div>

<h2 class="empresas">Listado de Instituciones </h2>
<div id="topics-filter">
    <ul id="dynamic">
        <li>Índice</li> 
        <?php
        // Listado Alfabético
        $tmpLetra = '';
        foreach ($servicios as $servicio) {
            $tmp = $servicio->nombre;
            $letra = $tmp[0];
            echo ($letra == $tmpLetra) ? '' : '<li class="current"><a href="' . site_url('servicios/directorio/#' . $letra) . '">' . $letra . '</a></li>';
            $tmpLetra = $letra;
        }
        ?>
    </ul>
  <ul class="vistas">
      <li>Vistas</li>
      <li class="grupo"><a href="#" title="Ver como Grupos">Ver como Grupos</a></li>
      <li class="lista"><a href="#" title="Ver como Listas">Ver como Listas</a></li>
  </ul>
</div>

<div id="instituciones" class="clearfix">

    <ul class="clearfix"><li></li>
        <?php
        $tmpLetra = '';
        foreach ($servicios as $servicio) {
            $tmp = $servicio->nombre;
            $letra = $tmp[0];
            echo ($letra == $tmpLetra) ? '' : '</ul><a name="' . $letra . '"></a><h2>' . $letra . '</h2><ul>';
            echo '<li><h3><a href="' . site_url('servicios/ver/' . $servicio->codigo) . '">' . $servicio->nombre . ( ($servicio->sigla) ? ' ('.$servicio->sigla.')' : '' ) . '</a></h3></li>';
            $tmpLetra = $letra;
        }
        ?>
    </ul>
</div>

<!-- Fin Contenido -->