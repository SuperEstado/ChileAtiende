<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="es">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title><?= $title ?> - ChileAtiende - Personas a tu servicio</title>
        <base href="<?= base_url() ?>" />
        <meta name="google-site-verification" content="bSIsZkQNkvxkUOTsDSCmt6K3wIrAEsAc0MxGjBfUKCs" />
        <meta http-equiv="Content-Language" content="es-CL" />
        <?php
        if (isset($descripcion)) {
            ?>
            <meta name="description" content="<?= $descripcion ?>" />
            <meta name="keywords" content="<?= $keywords ?>" />
            <meta name="author" content="<?= $autor ?>" />
            <?php
        } else { //cuando se encuentra en la ficha
            ?>
            <meta name="description" content="<?php echo ( (isset($ficha->objetivo) ) ? mb_substr(strip_tags($ficha->objetivo),0,300) : '' ); ?>" />
            <meta name="keywords" content="<?php echo ( (isset($ficha->keywords) && ($ficha->keywords) ) ? $ficha->keywords.' ' : '' ); echo Doctrine::getTable('Configuracion')->find('keywords') ? Doctrine::getTable('Configuracion')->find('keywords')->valor : ''; ?>" />
            <meta name="author" content="<?php echo ( ( isset($ficha->Servicio->nombre) ) ? $ficha->Servicio->nombre : '') ; ?>" />
            <?php
        }
        ?>
        <link rel="alternate" type="application/rss+xml" title="Noticias de ChileAtiende" href="<?php echo site_url('noticias/rss'); ?>" />
        <link rel="alternate" type="application/rss+xml" title="Destacamos en ChileAtiende" href="<?php echo site_url('rss/destacadas'); ?>" />
        <link rel="alternate" type="application/rss+xml" title="Más vistos esta semana en ChileAtiende" href="<?php echo site_url('rss/masvistas'); ?>" />
        <link rel="icon" type="image/x-icon" href="<?= site_url('assets/images/favicon.ico') ?>" />
        <link rel="stylesheet" type="text/css" href="<?= site_url('assets/css/reset.css') ?>" />
        <link rel="stylesheet" type="text/css" href="<?= site_url('assets/css/frontend.css') ?>" media="screen" />
        <link rel="stylesheet" type="text/css" href="<?= site_url('assets/css/css.css') ?>" media="screen" />
        <link rel="stylesheet" type="text/css" href="<?= site_url('assets/css/jquery.hoverscroll.css') ?>" media="screen" />
        <link rel="stylesheet" href="<?= site_url('assets/css/print.css" type="text/css') ?>" media="print" />
        <link type="text/plain" rel="author" href="<?= site_url('assets/humans.txt') ?>" />
        <script type="text/javascript" src="<?= site_url('assets/js/modernizr-latest.js') ?>"></script>
        <script type="text/javascript" src="<?= site_url('assets/js/jquery-1.7.1.min.js') ?>"></script>
        <script type="text/javascript" src="<?= site_url('assets/js/jquery-ui.min.js') ?>"></script>
        <script type="text/javascript" src="<?= site_url('assets/js/jquery.iconmenu.js') ?>"></script>
        <script type="text/javascript" src="<?= site_url('assets/js/jquery.hoverscroll.js') ?>"></script>
        <script type="text/javascript" src="<?= site_url('assets/js/jquery.placeholder/jquery.placeholder-1.0.1.js') ?>" ></script>
        <script type="text/javascript" src="<?= site_url('assets/js/jquery-tools/jquery-tools-1.2.5.js') ?>" ></script>
        <script type="text/javascript" src="<?= site_url('assets/js/jquery.cookie/jquery.cookie.js') ?>"></script>
        <script type="text/javascript" src="<?= site_url('assets/js/jquery.raty/js/jquery.raty.min.js') ?>"></script>
        <script type="text/javascript" src="<?= site_url('assets/js/jquery.waitforimages.js') ?>"></script>

        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
        <script type="text/javascript">
            var site_url="<?= site_url() ?>";
            var base_url="<?= base_url() ?>";
        </script>
        <!-- Marcadores condicionales para acciones específicas de IE -->
        <!--[if (gt IE 6)&(lte IE 8)]>
                <script type="text/javascript" src="<?= site_url('assets/js/selectivizr-min.js') ?>"></script>
        <![endif]-->
        <!--[if lte IE 8]>
                <link rel="stylesheet" type="text/css" href="<?= site_url('css/ie8.css') ?>" />
        <![endif]-->
        <!--[if lte IE 7]>
                <link rel="stylesheet" type="text/css" href="<?= site_url('css/ie7.css') ?>" />
        <![endif]-->
        <!--[if lt IE 7]>
                <script src="<?= site_url('assets/js/DD_belatedPNG.js') ?>"></script>
                <script>
                        DD_belatedPNG.fix('*');
                </script>
                <link rel="stylesheet" type="text/css" href="<?= site_url('css/ie6.css') ?>" />
        <![endif]-->
        <script type="text/javascript" src="<?= site_url('assets/js/script.js') ?>" ></script>
        <script type="text/javascript" src="<?= site_url('assets/js/frontend.js') ?>" ></script>

    </head>

    <body class="oneColFixCtr">
        <div id="header">
            <div class="header_content">
                <?php
                $home_url = (isset($perfil) && $perfil == "empresas") ? site_url('/empresas/') : site_url('/');
                ?>
                <div class="logo">
                    <h1><a href="<?= site_url('/') ?>" onclick="_gaq.push(['_trackEvent', 'Acciones', 'Home','Header']);">Portal Servicios Estado</a></h1>
                </div>
                <img class="logoPrint" alt="Logo ChileAtiende Imprimible" src="assets/images/logo_chile_atiende.png" />
                <div class="perfil">
                    Selecciona tu perfíl
                    <a href="#" class="<?= isset($perfil) && $perfil == 'empresas' ? 'personas' : 'personasOn' ?>" accesskey="p" title="Personas (alt+p)">Personas</a><a href="<?= site_url('empresas') ?>" class="<?= isset($perfil) && $perfil == 'empresas' ? 'organizacionesOn' : 'organizaciones' ?>" accesskey="o" title="Empresas y Organizaciones (alt+o)">Empresas y Organizaciones</a>
                </div>
                <div class="funciones">
                    <a href="<?= site_url("/"); ?>#" class="overlay correo" rel="#formacontacto"><img src="<?= site_url('assets/images/header/correo.png') ?>" alt="Contacto" />Contacto</a> <a href="http://info.chileatiende.cl/preguntas-frecuentes/" class="ayuda"><img src="<?= site_url('assets/images/header/ayuda.png') ?>" alt="Ayuda" /> Ayuda</a>
                </div>

             <?php
                $nroFichas = Doctrine::getTable('Ficha')->totalPublicados();
                $nroFichas = ( substr($nroFichas, -1) > 0 ) ? $nroFichas - substr($nroFichas, -1) : $nroFichas;
                ?>
                <div class="texto">Más de <strong><?= number_format($nroFichas, 0, ',', '.') ?></strong> servicios y beneficios a tu disposición</div>
                <div id="menu">
                    <ul>

                        <li <?= (!$this->uri->segment(2)) ? 'class="on"' : '' ?>><a href="<?= $home_url; ?>" class="inicio" onclick="_gaq.push(['_trackEvent', 'Acciones', 'Home', 'Nav']);" title="Página de inicio (alt+i)" accesskey="i">Inicio</a></li>
                        <?php if (!isset($perfil) || $perfil != "empresas"): ?>
                            <li <?= ( ($this->uri->segment(2) == 'etapas') || ($this->input->get('hecho')) ) ? 'class="on"' : '' ?>><a href="<?= site_url('portada/etapas') ?>" class="etapas" onclick="_gaq.push(['_trackEvent', 'Acciones', 'Etapas', 'Nav']);" title="Hechos de vida (alt+h)" accesskey="h">Hechos</a></li>
                            <li <?= ( ($this->uri->segment(2) == 'temas') || ($this->input->get('temas')) ) ? 'class="on"' : '' ?>><a href="<?= site_url('portada/temas') ?>" class="temas" onclick="_gaq.push(['_trackEvent', 'Acciones', 'Temas', 'Nav']);" title="Temas de interés (alt+t)" accesskey="t">Temas</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
                <div class="buscador" id="buscador">
                    <form action="<?= site_url('buscar/fichas') ?>" method="get" id="main_search">
                        <label for="main_search_input"><input accesskey="b" id="main_search_input" name="buscar" type="text" <?php echo (isset($hidden_string)) ? "value='" . $hidden_string . "'" : "" ?> /></label>
                        <input type="submit" accesskey="s" class="searchbtn" value="Buscar" />
                    </form>
                </div>
                <div class="clear"></div>
            </div>
        </div>
        <div id="container">
            <!--CONTENIDO-->
            <div id="main">
                <?php
                $this->load->view($content);
                ?>
            </div>

            <!--FOOTER-->
            <div class="clear"></div>
            <div id="footer">
                <div class="acceso_directo">
                    <h3>Accesos Directos</h3>
                    <ul>
                        <li><a rel="#overlayVersionBeta" href="<?= site_url('/') ?>#" class="overlay alphainfo" title="Acerca del Alpha" onclick="_gaq.push(['_trackEvent', 'Acciones', 'Acerca del Alpha', 'Barra Alpha']);">Acerca del Beta</a></li>
                        <li><a href="<?= site_url('/noticias') ?>" title="Noticias">Noticias</a></li>
                        <li><a href="<?= site_url('servicios/directorio/') ?>" title="Instituciones Asociadas">Instituciones Asociadas</a></li>
                        <li><a href="<?= site_url('/sitemap') ?>" title="Mapa del Sitio">Mapa del Sitio</a></li>
                        <li><a href="http://info.chileatiende.cl/preguntas-frecuentes/" title="Preguntas Frecuentes" rel="help" onclick="_gaq.push(['_trackEvent', 'Acciones', 'Ayuda', 'Footer']);">Preguntas Frecuentes</a></li>
                        <li><a href="<?= site_url('/') ?>#" class="overlay correo" rel="#formacontacto" title="Contáctenos" onclick="_gaq.push(['_trackEvent', 'Acciones', 'Contacto', 'Footer']);">Contacto</a></li>
                        <li><a href="<?= site_url('contenido/politicadeprivacidad') ?>">Política de Privacidad</a></li>
                        <li><a href="<?= site_url('contenido/terminosycondiciones') ?>">Términos y Condiciones de uso</a></li>
                    </ul>
                </div>
                <div class="visualizadores">
                    <h3>Acceso Visualizadores y Complementos</h3>
                    <ul>
                        <li><a href="<?= site_url('contenido/visualizadores') ?>">Visualizadores</a></li>
                    </ul>
                    <h3>Desarrolladores</h3>
                    <ul>
                        <li><a target="_blank" href="<?= site_url('/desarrolladores/') ?>">API ChileAtiende</a></li>
                        <li><a href="<?= site_url('/widget/') ?>">ChileAtiende en tu sitio</a></li>
                    </ul>

                    <h3>Móvil</h3>
                    <ul>
                        <li><a href="<?= site_url('/movil/') ?>?mobile=1">Ir a la versión móvil</a></li>
                    </ul>

                </div>

                <div class="logo"><img src="<?= site_url('assets/images/logo-footer.png') ?>" alt="Portal Servicios Estado" /><br />
                    <br />
                    <a href="http://www.modernizacion.cl" target="_blank">Unidad de Modernización y Gobierno Electrónico</a><br />
                    Ministerio Secretaría General de la Presidencia<br />
                    Gobierno de Chile                
                </div>

                <div class="contacto"><a href="http://creativecommons.org/licenses/by/3.0/cl/" title="Creative Commons">CC BY 3.0</a> | <a href="http://validator.w3.org/check?uri=<?= site_url() ?>" title="Validación W3C">W3C</a></div>
                <div class="moduloatencion">&nbsp;</div>
            </div>
            <div id="detalle">
                <div class="color"></div>
            </div>
            <!-- end #container -->
        </div>
        <?php
        $this->load->view("modal/ingreso");
        $this->load->view("modal/no_disponible");
        $this->load->view("modal/beta");
        // $this->load->view("modal/opciones");
        $this->load->view("modal/formacontacto");
        $this->load->view("modal/amigo");

        if (isset($display_mod_atencion)) {
            $this->load->view("modal/modulo_atencion");
        }
        ?>
        <!-- Tags de métricas -->

        <script type="text/javascript">
            $(document).ready(function(){
                $('#main_search_input').attr('placeholder','Ingresa el término');
            });
        </script>

        <script type="text/javascript">
            window.____aParams = {"gobabierto":"1","domain":"http://www.chileatiende.cl","icons":"1"};
            (function() {
                var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
                po.src = 'https://apis.modernizacion.cl/barra/js/barraEstado.js';
                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
            })();
        </script>


        <script type="text/javascript">

            var _gaq = _gaq || [];
            _gaq.push(['_setAccount', 'UA-28124406-2']);
            _gaq.push(['_setDomainName', '.chileatiende.cl']);
            _gaq.push(['_trackPageview']);
            
            //marca barra
            //_gaq.push(['barra._setAccount', 'UA-23675324-7']);
            //_gaq.push(['barra._trackPageview']);
            
            if($.cookie('overlayModuloAtencion')){
                var idModulo = $.cookie('overlayModuloAtencion');
                _gaq.push(['_setCustomVar', 1, 'ModuloAutoatencion', idModulo, 1]);
            }
            
            (function() {
                var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
                ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
            })();

        </script>

    </body>
</html>
