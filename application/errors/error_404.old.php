<!--
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>404 Pagina no encontrada</title>
    <style>
        body{
            background: yellow;
            font-family: "Comic Sans MS";
            text-align: center;
        }

        h1{
            text-decoration: blink;
}

        form{
            background: turquoise;
        }
    </style>
</head>
<body>

    <embed src="http://www.alpha-programming.co.uk/audio/midi/midis/tv/animaniacs/animaniacs.mid" autostart="true" loop="true"
width="2" height="0" />
	<div id="content">
                <h1>Error 404</h1>
		<h2>Página no encontrada</h2>

<?php for ($i = 0; $i < 10; $i++): ?>
                    <img src="http://wiiumariobundle.com/wp-content/uploads/2011/08/animated_donkey_kong.gif" />
<?php endfor; ?>

                    <form id="main_search" method="post" action="http://redchile.modernizacion.cl/buscar/fichas">
                        <fieldset>
                            <label for="main_search_input"><strong>Buscador</strong> del Estado</label>
                            <input type="text" onblur="if (this.value == '') this.value = 'Ingrese el término'" onfocus="if (this.value == 'Ingrese el término') this.value = ''" value="Ingrese el término" name="buscar" id="main_search_input">
                             <select name="search_base" id="msdrpdd20">
                                <option selected="selected">Todos los Sitios</option>
                                <option value="redchile"></option>
                                <option value="estado">Sitios del Estado</option>
                                <option value="emprendimiento">Emprendimiento</option>
                                <option value="transparencia">Transparencia</option>
                                <option value="municipios">Municipios</option>

                             </select>
                            <input type="submit" value="Búsqueda Rápida" class="submit">
                        </fieldset>
                    </form>

<?php for ($i = 0; $i < 5; $i++): ?>
                        <img src="http://hipstersammich.com/under_construction_animated.gif" />
<?php endfor; ?>
        	</div>
        </body>
        </html>
        -->


        <html>
            <head>
                <base href="<?= base_url() ?>"/>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>404 Pagina no encontrada</title>
        <link rel="stylesheet" type="text/css" href="assets/css/reset.css" />
        <style type="text/css">
            body{
                font-family: arial;
                font-size: 12px;
            }
            #error404{
                background: url(assets/images/404.png);
                width: 810px;
                height: 485px;
                margin: 0 auto;
                position: relative;
            }

            #error404 .main{
                position: absolute;
                left: 240px;
                top: 60px;
                width: 500px;
                color: #fff;
                text-align: center;
            }

            #error404 .footer{
                position: absolute;
                top: 410px;
                left: 60px;
                color: #fff;
            }
            #error404 .footer h1{
                font-size: 16px;
                line-height: 1.2em;
            }

            h2{
                font-size: 49px;
                font-weight: bold;
                text-shadow: #000 2px 2px 2px;
            }
            h3{
                font-size: 30px;
            }
            hr{
                margin: 20px 0;
            }
            p{
                font-size: 18px;
                line-height: 1.2em;
                margin-bottom: 10px;
            }

            form input[type=text]{
                width: 360px;
                padding: 4px;
                font-size: 16px;
                border: 1px solid #818181;
                border-radius: 5px;
                margin-bottom: 10px;
            }
            form input[type=submit]{
                display: inline-block;
                background: url(assets/images/404buscar.png);
                width: 175px;
                height: 45px;
                text-indent: -9999px;
                cursor: pointer;
            }
        </style>
    </head>

    <body>
        <div id="error404">
            <div class="main">
                 <h2>Error 404</h2>
                <h3>Página no disponible</h3>
                <hr />
                <p>Si desea encontrar información<br />te invitamos a utilizar nuestro buscador</p>

                <form method="post" action="<?= site_url('buscar/fichas')?>">
                    <input type="text" placeholder="Ingrese el termino de búsqueda" name="buscar"><br />
                    <input type="submit" value="Búsqueda Rápida" class="submit">
                </form>
            </div>
            <div class="footer">
                <h1>Red de Servicios del Estado<br />Gobierno de Chile</h1>
            </div>


            </div>
    </body>
</html>