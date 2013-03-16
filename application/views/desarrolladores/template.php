<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title><?= $title ?> | API Portal de Servicios del Estado</title>
        <base href="<?= base_url() ?>" />
        <link rel="stylesheet" type="text/css" href="assets/css/desarrolladores.css" />
    </head>

    <body>
        <div id="wrapper">
            <div id="header">
                <h1 class="logo"><a href="<?= site_url('desarrolladores') ?>">Interfaz para programadores API - Portal de Servicios del Estado</a></h1>
            </div>
            <div id="main">
                <div id="secondary">
                    <ul class="menu">
                        <li><a href="<?= site_url('desarrolladores') ?>">API</a></li>
                        <ul>
                            <li>
                                <a href="<?= site_url('desarrolladores/fichas') ?>">Fichas</a>
                                <ul>
                                    <li><a href="<?= site_url('desarrolladores/fichas_obtener') ?>">obtener</a></li>
                                    <li><a href="<?= site_url('desarrolladores/fichas_listar') ?>">listar</a></li>
                                    <li><a href="<?= site_url('desarrolladores/fichas_listarporservicio') ?>">listarPorServicio</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="<?= site_url('desarrolladores/servicios') ?>">Servicios</a>
                                <ul>
                                    <li><a href="<?= site_url('desarrolladores/servicios_obtener') ?>">obtener</a></li>
                                    <li><a href="<?= site_url('desarrolladores/servicios_listar') ?>">listar</a></li>
                                </ul>
                            </li>
                        </ul>
                        <li><a href="<?= site_url('desarrolladores/politicasdeuso') ?>">Políticas de Uso y Términos del Servicio</a></li>
                    </ul>
                </div>
                <div id="primary">
                    <?php $this->load->view($content) ?>
                </div>
            </div>
            <div id="footer">
                <p style="text-align: right;">Última modificación: 05/12/2011</p>
            </div>
        </div>
    </body>
</html>
