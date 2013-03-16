<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, content="text/html; charset=UTF-8", minimum-scale=1, maximum-scale=1">
              <title>Portal de Servicios del Estado -
                  <?= $title ?>
        </title>
        <link rel="stylesheet" href="<?= base_url(); ?>assets/css/themes/chileatiende.css" type="text/css" />
        <?php
        if (isset($ficha->id)) {
            ?>
            <link rel="canonical" href="<?php echo site_url('fichas/ver/' . $ficha->maestro_id) ?>" >
            <?php
        }
        ?>
        <script src="<?= base_url(); ?>assets/js/mobile/jquery-1.5.min.js" type="text/javascript"></script>
        <script type="text/javascript">

            $(document).bind("mobileinit", function(){
                $.mobile.page.prototype.options.backBtnText = "Atrás";
                $.mobile.loadingMessage = 'Cargando...';
            });
        </script>
        <script src="<?= base_url(); ?>assets/js/mobile/jquery.mobile-1.0a3.min.js" type="text/javascript"></script>

    </head>

    <body>
        <div data-role="page" id="home" data-theme="<?= $theme_page ?>">
            <div data-role="header" data-theme="<?= $theme_header ?>">
                <h1><img src="<?= base_url(); ?>assets/images/mobile/logo.png" width="116" height="37" alt="ChileAtiende"></h1>
            </div>
            <div data-role="content">
                <div data-role="navbar" class="ui-navbar">
                    <ul>
                        <li><a href="<?= site_url("movil/"); ?>" data-theme="d">Buscador</a></li>
                        <li><a href="<?= site_url("movil/etapas") ?>" data-theme="c">Hechos de Vida</a></li>
                    </ul>
                </div>
                <?php $this->load->view($content); ?>
            </div>
            <div data-role="footer">
                <a rel="external" href="<?= site_url() ?>?mobile=0">Ir a la versión de escritorio</a>
            </div>
        </div>
    </body>
    <!-- Metricas -->
    <script type="text/javascript">

        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-28124406-1']);
        _gaq.push(['_trackPageview']);
        
        _gaq.push(['desk_version._setAccount', 'UA-28124406-2']);
        _gaq.push(['desk_version._setDomainName', '.chileatiende.cl']);
        _gaq.push(['desk_version._trackPageview']);

        (function() {
            var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
        })();

    </script>
    <!-- Fin Metricas -->
</html>