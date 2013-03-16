<?php
$entidades = UsuarioBackendSesion::usuario()->getEntidadesAccesibles();
$servicios = UsuarioBackendSesion::usuario()->getServiciosAccesibles(UsuarioBackendSesion::getEntidad());
?>

<div class="breadcrumb">
    <span>Administración</span>
</div>

<div class="pane">
    <h2>Bienvenidos al administrador</h2>

    <div class="cpanel">
        <?php
        $menu = array(
            array('url' => 'backend/cuenta', 'label' => 'Mis Datos', 'icono' => 'mis_datos.png'),
            array('url' => 'backend/fichas', 'label' => 'Fichas', 'icono' => 'fichas.png')
        );

        if (UsuarioBackendSesion::usuario()->tieneRol('mantenedor')) {
            $menu = array(
                array('url' => 'backend/cuenta', 'label' => 'Mis Datos', 'icono' => 'mis_datos.png'),
                array('url' => 'backend/usuariosbackend', 'label' => 'Usuarios', 'icono' => 'usuarios.png'),
                array('url' => 'backend/servicios', 'label' => 'Instituciones', 'icono' => 'instituciones.png'),
                array('url' => 'backend/etapasvida', 'label' => 'Etapas', 'icono' => 'etapas.png'),
                array('url' => 'backend/hechosvida', 'label' => 'Hechos de Vida', 'icono' => 'hechos_de_vida.png'),
                array('url' => 'backend/temas', 'label' => 'Temas', 'icono' => 'temas.png'),
                array('url' => 'backend/fichas', 'label' => 'Fichas', 'icono' => 'fichas.png'),
                array('url' => 'backend/fichas/listarflujos', 'label' => 'Flujos', 'icono' => 'flujos.png'),
                array('url' => 'backend/noticias', 'label' => 'Noticias', 'icono' => 'noticias.png'),
                array('url' => 'backend/oficinas', 'label' => 'Oficinas', 'icono' => 'oficinas.png')
            );
        }

        foreach ($menu as $option) {
            ?>
            <a href="<?= site_url($option['url']) ?>">
                <div class="cpanel-icon">

                    <img src="assets/images/backend/<?= $option['icono'] ?>" height="60" width="60"  /><br />
                    <span><?= $option['label'] ?></span>

                </div>
            </a>
            <?php
        }
        ?>
    </div>

    <div id="topten">
        <h3>Descarga estadísticas</h3>

        <p><a href="<?=site_url('/backend/portada/topten/vistas')?>">Fichas Más Vistas</a></p>
        <p><a href="<?=site_url('/backend/portada/topten/votadas')?>">Fichas Mejor Evaluadas</a></p>
        <p><a href="<?=site_url('/backend/portada/topten/servicios')?>">Institución con más Fichas</a></p>
        <p><a href="<?=site_url('/backend/portada/topten/masbuscados')?>">Búsquedas Comunes</a></p>
    </div>

</div>