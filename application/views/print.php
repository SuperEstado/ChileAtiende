<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title><?= $title ?></title>
        <base href="<?= base_url() ?>" />
        <link rel="stylesheet" type="text/css" href="assets/css/reset.css" />
        <link rel="stylesheet" type="text/css" href="assets/css/print.css" />
    </head>

    <body>
        <div id="wrapper">
            <div id="header">
                <div><a class="logo" href="<?= site_url() ?>">Gobierno de Chile</a></div>
                <h1><a class="redchile" href="<?= site_url() ?>">Red Chile</a></h1>
            </div>
            
            <div id="main">
                <?php
                $this->load->view($content);
                ?>
            </div>

            <div id="footer">
                <div class="column">
                    <div class="footerRedchile">
                        <p><strong></strong></p>
                        <p><strong>Subsecretaría General de la Presidencia</strong></p>
                        <p>Gobierno de Chile</p>
                    </div>
                </div>
                <div class="column">
                    <p><strong>Descargas</strong></p>
                    <ul>
                        <li><a href="#">Visualizador de PDF (Adobe Acrobat)</a></li>
                        <li><a href="#">Visualizador Flash 10</a></li>
                        <li><a href="#">Navegador Gratuito Mozilla Firefox 4.0</a></li>
                    </ul>
                </div>
                <div class="column">
                    <p><strong>Politicas de Privacidad</strong></p>
                    <ul>
                        <li><a>Descargar documento</a></li>
                    </ul>
                </div>
            </div>
        </div>

    </body>

</html>