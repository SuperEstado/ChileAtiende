<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title><?= $title ?> | Red de Servicios del Estado</title>
        <base href="<?= base_url() ?>" />
        <link rel="icon" type="image/x-icon" href="assets/images/favicon.ico" />
        <link rel="stylesheet" type="text/css" href="assets/css/reset.css" />
        <link rel="stylesheet" type="text/css" href="assets/css/frontend.css" media="screen" /> 
        <link rel="stylesheet" type="text/css" href="assets/css/css.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="assets/css/compare.css" />
        <script type="text/javascript" src="assets/js/jquery-1.4.4.js" ></script>
        <script type="text/javascript" src="assets/js/jquery-tools/jquery-tools-1.2.5.js" ></script>
        <script type="text/javascript" src="assets/js/comentarios.backend.js" ></script>
        <script type="text/javascript">
            var site_url="<?= site_url() ?>";
            var base_url="<?= base_url() ?>";
            
            // perform JavaScript after the document is scriptable.
            $(function() {	
                // setup ul.tabs to work as tabs for each div directly under div.panes	
                $("ul.nav").tabs("div.panes > div");
            });
            
        </script>
        <!-- Marcadores condicionales para acciones específicas de IE -->
        <!--[if (gt IE 6)&(lte IE 8)]>
            <script type="text/javascript" src="assets/js/selectivizr-min.js"></script>
        <![endif]-->
        <!--[if lte IE 8]>
            <link rel="stylesheet" type="text/css" href="css/ie8.css" />
        <![endif]-->
        <!--[if lte IE 7]>
            <link rel="stylesheet" type="text/css" href="css/ie7.css" />
        <![endif]-->
        <!--[if lt IE 7]>
            <script src="assets/js/DD_belatedPNG.js"></script>
            <script>
                DD_belatedPNG.fix('*');
            </script>
            <link rel="stylesheet" type="text/css" href="css/ie6.css" />
        <![endif]-->
    </head>

    <body>
        <div id="wrap">


            <!-- Inicio Contenido -->		
            <div id="main">


                <?php
                $this->load->view($content);
                ?>


            </div><!-- Div-Main -->

            <!-- Tooltips -->
            <div id="tooltip"></div>


        </div>
    </body>
</html>