<?php
$entidad = UsuarioBackendSesion::getEntidad();
$servicio = UsuarioBackendSesion::getServicio();
$cntflujos = FALSE;//deshabilitamos los flujos para que los contadores solo muestren las fichas que faltan procesar (creadas, actualizables, etc)

$creadas = Doctrine::getTable('Ficha')->findMaestros($entidad, $servicio, array('estado' => 'creadas', 'justCount' => TRUE, 'flujos' => $cntflujos));
$pendientes = Doctrine::getTable('Ficha')->findMaestros($entidad, $servicio, array('estado' => 'actualizables', 'justCount' => TRUE, 'flujos' => $cntflujos));
$rechazadas = Doctrine::getTable('Ficha')->findMaestros($entidad, $servicio, array('estado' => 'rechazado', 'justCount' => TRUE, 'flujos' => $cntflujos));
$revision = Doctrine::getTable('Ficha')->findMaestros($entidad, $servicio, array('estado' => 'enrevision', 'justCount' => TRUE, 'flujos' => $cntflujos));
$publicados = Doctrine::getTable('Ficha')->findMaestros($entidad, $servicio, array('estado' => 'publicados', 'justCount' => TRUE, 'flujos' => $cntflujos));
$nopublicados = Doctrine::getTable('Ficha')->findMaestros($entidad, $servicio, array('estado' => 'nopublicados', 'justCount' => TRUE, 'flujos' => $cntflujos));
$flujospublicados = Doctrine::getTable('Ficha')->findMaestros($entidad, $servicio, array('estado' => 'publicados', 'justCount' => TRUE, 'flujos' => TRUE));
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title><?= $title ?></title>
        <base href="<?= base_url() ?>" />
        <link rel="icon" type="image/x-icon" href="<?= site_url('assets/images/favicon.ico') ?>" />
        <link rel="stylesheet" type="text/css" href="<?= site_url('assets/css/reset.css') ?>" />
        <link rel="stylesheet" type="text/css" href="<?= site_url('assets/css/backend-new.css') ?>" />
        <link rel="stylesheet" type="text/css" href="<?= site_url('assets/css/jquery-ui/jquery.ui.autocomplete.custom.css') ?>" />
        <link rel="stylesheet" type="text/css" href="<?= site_url('assets/css/chosen.css') ?>" />
        <link rel="stylesheet" type="text/css" href="<?= site_url('assets/js/fileuploader/fileuploader.css') ?>" />
        <script type="text/javascript">
            var site_url="<?= site_url() ?>";
        </script>
        <script type="text/javascript" src="<?= site_url('assets/js/jquery-1.7.1.min.js') ?>" ></script>
        <script type="text/javascript" src="<?= site_url('assets/js/jquery-ui/jquery-ui-1.8.16.custom.min.js') ?>"></script>
        <script type="text/javascript" src="<?= site_url('assets/js/jquery-tools/jquery-tools-1.2.5.js') ?>" ></script>
        <script type="text/javascript" src="<?= site_url('assets/js/tag-it/tag-it.js') ?>"></script>
        <script type="text/javascript" src="<?= site_url('assets/js/tiny_mce/tiny_mce.js') ?>"></script>
        <script type="text/javascript" src="<?= site_url('assets/js/chosen/chosen.jquery.js') ?>"></script>
        <script type="text/javascript" src="<?= site_url('assets/js/highcharts/highcharts.js') ?>"></script>
        <script type="text/javascript" src="<?= site_url('assets/js/fileuploader/fileuploader.js') ?>"></script>
        <script type="text/javascript" src="<?= site_url('assets/js/script.js') ?>" ></script>
        <script type="text/javascript" src="<?= site_url('assets/js/backend.js') ?>" ></script>
        <script type="text/javascript" src="<?= site_url('assets/js/comentarios.backend.js') ?>" ></script>
    </head>

    <body>
        <div id="wrapper">
            <div id="header">
                <div class="logo">Chile Atiende</div>
                <div class="logo-ChA">Chile Atiende</div>
                <div class="tools">
                    <ul class="menu">
                        <li class="usuario"><a href="<?= site_url('backend/cuenta/index') ?>"><?= UsuarioBackendSesion::usuario()->nombres . ' ' . UsuarioBackendSesion::usuario()->apellidos ?></a></li>
                        <li><?=dia(strftime("%u")).strftime(", %d de "). mes( (strftime("%m")<9) ? substr(strftime("%m"), -1 ,1 ) : strftime("%m")  ) .strftime(" de %Y") ?></li>
                        <li class="home"><a href="<?= site_url('/') ?>" target="_blank">Ver Portada</a></li>
                        <li class="salir"><a href="<?= site_url('backend/autenticacion/logout') ?>">Salir</a></li>
                    </ul>
                </div>
            </div>

            <div id="main">
                <div id="secondary">
                    <h2>Menú Principal</h2>
                    <ul>
                        <li><strong></strong></li>
                        <li><a href="<?= site_url('backend/cuenta/index') ?>">Mis datos</a></li>
                        <li><a href="<?= site_url('backend/portada') ?>">Panel de Control</a></li>
                    </ul>
                    <?php if (UsuarioBackendSesion::usuario()->tieneRol('mantenedor')) { ?>
                        <br />
                        <h2>Administración</h2>
                        <ul>
                            <li><a href="<?= site_url('backend/configuraciones') ?>">Configuración</a></li>
                            <li><a href="<?= site_url('backend/mantenimiento') ?>">Mantenimiento</a></li>
                            <li><a href="<?= site_url('backend/usuariosbackend') ?>">Usuarios </a></li>
                            <li><a href="<?= site_url('backend/servicios') ?>">Instituciones</a></li>
                            <li><a href="<?= site_url('backend/etapasvida') ?>">Etapas</a></li>
                            <li><a href="<?= site_url('backend/hechosvida') ?>">Hechos</a></li>
                            <li><a href="<?= site_url('backend/temas') ?>">Temas</a></li>
                            <li><a href="<?= site_url('backend/oficinas') ?>">Oficinas</a></li>
                            <li><a href="<?= site_url('backend/sectores') ?>">Sectores</a></li>
                            <li><a href="<?= site_url('backend/entidades') ?>">Entidades</a></li>
                            <li><a href="<?= site_url('backend/modulosatencion') ?>">Módulos de atención</a></li>
                            <li><a href="<?= site_url('backend/uploads') ?>">Carga de archivos</a></li>
                        </ul>
                    <?php } ?>

                    <?php if (UsuarioBackendSesion::usuario()->tieneRol(array('editor', 'aprobador', 'publicador', 'mantenedor'))) { ?>
                        <br />
                        <h2>Trámites y Servicios</h2>
                        <ul>
                            <?php if (UsuarioBackendSesion::usuario()->tieneRol(array('editor'))) { ?>
                                <li><a href="<?= site_url('backend/fichas/agregar') ?>" title="Permite crear una nueva ficha de información en el sistema">Agregar Ficha</a></li>
                            <?php } ?>
                            <li>
                                <a href="<?= site_url('backend/fichas') ?>" title="Listar todas las fichas disponibles en el sistema">Ver Fichas</a>
                                <ul>
                                    <li><a href="<?= site_url('backend/fichas/index/creadas') ?>" title="Fichas para revisión del servicio">Para revisión <?= ($creadas) ? '(' . $creadas . ')' : ''; ?></a></li>
                                    <li><a href="<?= site_url('backend/fichas/index/enrevision') ?>" title="Fichas en proceso de revisión editorial">En revisión ChileAtiende <?= ($revision) ? '(' . $revision . ')' : ''; ?></a></li>
                                    <li><a href="<?= site_url('backend/fichas/index/rechazado') ?>" title="Fichas con comentarios editoriales ChileAtiende">Con observaciones <?= ($rechazadas) ? '(' . $rechazadas . ')' : ''; ?></a></li>

                                    <?php if (UsuarioBackendSesion::usuario()->tieneRol(array('publicador'))) { ?>

                                        <li><a href="<?= site_url('backend/fichas/index/nopublicados') ?>" >No Publicadas <?= ($nopublicados) ? '('. $nopublicados .')' : '' ?></a></li>
                                        <li><a href="<?= site_url('backend/fichas/index/actualizables') ?>" >Actualizables <?= ($pendientes) ? '(' . $pendientes . ')' : ''; ?></a></li>

                                        <li><a href="<?= site_url('backend/fichas/index/destacado') ?>" >Destacadas</a></li>
                                        <li><a href="<?= site_url('backend/fichas/index/chileclic') ?>" >ChileClic</a></li>

                                    <?php } ?>

                                    <li><a href="<?= site_url('backend/fichas/index/publicados') ?>" title="Fichas disponibles a la ciudadanía en el portal">Publicadas <?= ($publicados) ? '(' . $publicados . ')' : ''; ?></a></li>
                                </ul>
                            </li>
                        </ul>
                    <?php } ?>

                    <?php if (UsuarioBackendSesion::usuario()->tieneRol(array('publicador'))) { ?>
                        <br />
                        <h2>Diagramación</h2>
                        <ul>
                            <li><a href="<?= site_url('backend/fichas/index/pendiente') ?>">Pendiente</a></li>
                            <li><a href="<?= site_url('backend/fichas/index/enproceso') ?>">En Proceso</a></li>
                            <li><a href="<?= site_url('backend/fichas/index/finalizada') ?>">Finalizada</a></li>
                        </ul>
                    <?php } ?>

                    <?php if (UsuarioBackendSesion::usuario()->tieneRol(array('mantenedor','publicador'))) { ?>
                        <br />
                        <h2>Flujos</h2>
                        <ul>
                            <li><a href="<?= site_url('backend/fichas/agregarflujo') ?>" title="Permite crear un flujo de información en el sistema">Agregar Flujo</a></li>
                            <li>
                                <a href="<?= site_url('backend/fichas/listarflujos') ?>">Ver Flujos</a>
                                <ul>
                                <?php if (UsuarioBackendSesion::usuario()->tieneRol(array('publicador'))) { ?>
                                    <li><a href="<?= site_url('backend/fichas/listarflujos/nopublicados') ?>" >No Publicados</a></li>
                                <?php } ?>
                                    <li><a href="<?= site_url('backend/fichas/listarflujos/publicados') ?>" title="Flujos disponibles a la ciudadanía en el portal">Publicadas <?= ($flujospublicados) ? '(' . $flujospublicados . ')' : ''; ?></a></li>
                                </ul>
                            </li>
                        </ul>
                    <?php } ?>

                    <?php if (UsuarioBackendSesion::usuario()->tieneRol(array('reportero', 'mantenedor'))) { ?>
                        <br />
                        <h2>Noticias</h2>
                        <ul>
                            <li>
                                <a href="<?= site_url('backend/noticias') ?>">Listar Noticias</a>
                                <?php if (UsuarioBackendSesion::usuario()->tieneRol(array('reportero', 'mantenedor'))) { ?>
                                    <ul>
                                        <li><a href="<?= site_url('backend/noticias/agregar') ?>">Agregar Noticia</a></li>
                                    </ul>
                                <?php } ?>
                            </li>
                        </ul>
                    <?php } ?>
                </div>
                <div id="primary">
                    <?php $this->load->view($content); ?>
                </div>
            </div>

            <div id="footer">
                <address>
                    Gobierno de Chile - Modernización y Gobierno Electrónico - Ministerio Secretaría General de la Presidencia<br />
                    Dirección: Teatinos 333 Piso 4, Santiago de Chile<br />
                    Teléfono: +56 2 688 77 01
                </address>
            </div>
        </div>
    </body>
</html>