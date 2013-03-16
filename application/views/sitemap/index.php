<div id="content" class="clearfix">
    <div id="maincontent" class="right clearfix">
        <div class="breadcrumbs"><a href="<?= site_url('/') ?>">Portada</a> / Mapa del Sitio</div>
        <h2 class="title">Mapa del Sitio</h2>

        <?php
        //$this->load->view("fichas/access_share_menu.php");
        ?>


        <h3>Acceda al contenido</h3>
        <ul class="mapa">
            <li class="etapas"><a href="<?= site_url('/portada/etapas') ?>">Hechos de Vida</a></li>
            <li><a href="<?= site_url('/portada/temas') ?>">Seleccione su Tema</a></li>
            <!-- <li><a id="busqueda" href="<?= site_url('') ?>#">Buscador</a></li> -->
        </ul>

        <h3>Instituciones</h3>

        <ul id="root" class="menu">
            <?php foreach ($servicios as $servicio) { ?>
                <li>
                    <a rel='<?= $servicio->codigo ?>' href="#" class='cat_close category'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
                    <a href="<?= site_url('servicios/ver/' . $servicio->codigo ) ?>"><?= $servicio->nombre ?></a>
                    
                    <ul id='<?= $servicio->codigo ?>'>
                        <li>
                            <a href="<?= site_url('servicios/ver/' . $servicio->codigo) ?>">Ver servicios y beneficios asociados a esta institución.</a>
                        </li>
                    </ul>
                </li>
                
            <?php } ?>
        </ul>
        <h3>Redes Sociales</h3>
        <ul class="mapa">
            <li><a href="http://facebook.com/chileatiende">Facebook</a></li>
            <li><a href="http://twitter.com/chileatiende">Twitter</a></li>
        </ul>  
        <h3>Funciones Comunes</h3>      
        <ul class="mapa">
            <li><a href="<?= site_url('sitemap') ?>">Mapa del Sitio</a></li>
            <li><a href="http://info.chileatiende.cl/preguntas-frecuentes/">Ayuda y Preguntas Frecuentes</a></li>
            <li><a href="<?= site_url('/') ?>#" class="overlay correo" rel="#formacontacto" title="Contáctenos">Contáctenos</a></li>
            <!--li><a rel="#no_disponible" href="#" class="overlay login" title="Accede a una mejor navegación">Ingresa o Regístrate</a></li-->
        </ul>

    </div><!-- Content --> 
</div>