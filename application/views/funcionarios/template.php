<!DOCTYPE html>
<html lang="es-cl">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="google" value="notranslate" />
        <meta name="viewport" content="width=device-width" />
        <title><?= $title ?> | Servicios del Estado - Portal Funcionarios</title>
        <base href="<?= base_url() ?>" />
        <link href="assets/css/reset.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/chosen.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/funcionarios.css" rel="stylesheet" type="text/css" />
        <link href="assets/images/favicon.ico" type="image/x-icon" rel="icon">
        <script type="text/javascript" src="assets/js/jquery.min.js"></script>
        <script type="text/javascript" src="assets/js/jquery-tools/jquery-tools-1.2.5.js"></script>
        <script type="text/javascript" src="assets/js/chosen/chosen.jquery.js"></script>
        <script type="text/javascript" src="assets/js/funcionarios.js"></script>
        <script type="text/javascript">
            var site_url="<?= site_url() ?>";
            var base_url="<?= base_url() ?>";
            <?php
            if(isset($window_position) && $window_position) {
            ?>
            window.moveTo(screen.width-340,0);
            <?php
            }
            ?>
            $(".chzn-select").chosen();
        </script>
    </head>

    <body>
        <?php
        //Arreglar esto para que se haga en un controlador
        if ($this->input->get('logout'))
            $this->session->unset_userdata('oficina');
        if ($this->input->post('Entrar')) {
            $this->session->set_userdata('oficina', $this->input->post('oficina'));
        }
        $s_oficina = $this->session->userdata('oficina');


        if ($s_oficina == "") {
            echo "<div class='login'>";
            echo "<form method='post'>";
            echo "<h2>Seleccione su centro de atención</h2>";
            echo "<p>A fin de optimizar las opciones que le entrega este sistema, le solicitamos iniciar sesión seleccionando su centro de atencion.</p>";
            $oficinas = Doctrine::getTable('Oficina')->ips();
            echo "<select name='oficina' data-placeholder='Seleccione su centro...' class='chzn-select'>";
            echo "<option value=''></option>";
            $sector_actual = "";
            foreach ($oficinas as $oficina) {
                $codigo = substr($oficina->sector_codigo, 0, 2);
                if ($sector_actual != $codigo) {
                    if ($sector_actual != "")
                        echo "</optgroup>";
                    $sector = Doctrine::getTable('Sector')->findOneBy('codigo', $codigo);
                    echo "<optgroup label='$sector->nombre' >";
                    $sector_actual = $codigo;
                }
                echo "<option value='$oficina->id'>" . $oficina->nombre . "</option>";
            }
            echo "</optgroup>";
            echo "</select>";
            echo "<input type ='submit' value='Entrar' name='Entrar'>";
            echo "</form>";
            echo "</div>";
            ?>
            <script type="text/javascript">
                $(".chzn-select").chosen();
            </script>
            <?php
        }else {
            ?>
            <!--HEADER-->
            <div id="top">
                <h1><a href="<?=site_url('funcionarios')?>">Servicios del Estado</a></h1>
                <a href="<?=site_url()?>" class="web_publico" target="_blank">Website Público</a>
            </div>
            <!-- Menú jQuery -->
            <nav>
                <ul class="primary-nav">
                    <li <?= (($on == 'buscar') ? " class='on' " : ""); ?>><a class="tab_buscar" href="<?= site_url('funcionarios') ?>" >Búsqueda</a></li>
                    <li <?= (($on == 'listar') ? " class='on' " : ""); ?>><a class="tab_listar" href="<?= site_url('funcionarios/destacados') ?>" >Listar Servicios</a></li>
                </ul>
                <nav class="secondary-nav">
                    <?= $this->load->view('funcionarios/menu');?>
                </nav>
            </nav>
            <!--CONTENIDO-->
            <section id="content">

                <?php
                $this->load->view($content);
                ?>
            </section>
            <section id="direct-access">
            </section>
            <?php

            if(isset($vista_ficha)){ ?>
                <div class="imprimir">
                    <ul>
                        <li><?= anchor('#','Pública',array('class'=>"printbutton",'id'=>$ficha->maestro_id)); ?></li>
                        <li><?="<a href='javascript:print()' > Cartilla</a>";?></li>
                        <li class="mail"><?= anchor("",'Enviar',array('class'=>'modalInput','rel'=>'#mod')) ?></li>
                    </ul>
                </div>
                    <?php
                    $files = $ficha->getFiles();
                    if(!$files){ // Oculto hasta que hayan fichas con archivos asociados
                    ?>
                <div class="archivos">
                    <ul>
                    Documentos Asociados
                    <?php
                        foreach($files as $file){
                            echo "<li> ".anchor($file->url,$file->nombre)." </li>";
                        }
                    ?>
                    </ul>
                </div>
                    <?php } ?>
            <?php } ?>


            <div id="noticias">
              <footer>
                <!--FOOTER-->
                <h3>Noticias y Anuncios</h3>
                <?php
                $noticias = Doctrine::getTable('Noticia')->ultimasNoticias(array('limit' => '5'));
                if ($noticias) {
                    echo "<div>\n";
                    echo "<a class='next' />Siguiente</a>\n";
                    echo "<div class='scrollable'>\n";
                    echo "<ul class='items'>\n";

                    foreach ($noticias as $noticia) {
                        echo "<li><a target='_blank' href='".site_url('noticias/ver/'.$noticia->alias)."'>".word_limiter($noticia->titulo,12)."</a></li>\n";
                    }
                    echo "</ul>\n";
                    echo "</div>\n";
                    echo "<a class='prev'>Anterior</a>\n";
                    echo "</div>";
                }
                ?>
                </footer>
            </div>
<?php
            }
            ?>
    </body>  