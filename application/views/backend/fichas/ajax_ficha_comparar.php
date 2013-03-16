<h2>Comparador</h2>

<?php
    if($left->id > $right->id){
        $nueva = $left;
        $vieja = $right;
    }else{
        $nueva = $right;
        $vieja = $right;
    }
    /*
    echo "<div class='change_set'>";
    $comparacion = $nueva->compareWith($vieja);

    if ($comparacion) {
        echo "<h3 id='toggle_change_set'>Ver lista de cambios</h3>";
        $descripcion = '';
        echo "<div id='change_set_container' style='display: none'>";
        
        echo make_description($comparacion,$nueva);
        echo "</div>";
    }else{
        echo "<h3>No se detectan cambios entre las versiones</h3>";
    }
    echo "</div>";
    */
?>

<table class="comparar" >
    <tr>
        <th>Version <?= $left->id ?></th>
        <th>Version <?= $right->id ?></th>
    </tr>
    <tr>
        
<?php
    $fichas = Array($left,$right);
    $i = 1;
    foreach($fichas as $left):
       
?>
        
        <td>
            <div class="wrap_header_ficha clearfix">
                <h2 class="title"><?= ($i == 1)? htmlDiff ($fichas[1]->titulo, $fichas[0]->titulo):$left->titulo; ?></h2>
                <p class="responsible">Institución responsable: <strong> <?= $left->Servicio->nombre ?></strong></p>
                <p class="meta">Última actualización: <?= strftime('%d/%m/%Y', mysql_to_unix($left->updated_at)) ?></p>

                <dl id="options">
                    <?php
                    if (!empty($left->guia_online) || !empty($left->guia_oficina) || !empty($left->guia_telefonico) || !empty($left->guia_correo)) {
                        ?>
                        <dd class="red-text">Cómo realizar este trámite</dd>
                        <?php
                    }
                    ?>
                    <dd class="ratingFicha"></dd>
                </dl>
                <ul class="access_share_menu">

                </ul>

            </div>

            <!--<hr class="shadow" />-->

            <h3 class="first_topic"><span class="title-bullet"></span>Descripción</h3>
            <?php echo ($i == 1)? htmlDiff ($fichas[1]->objetivo, $fichas[0]->objetivo):$left->objetivo;?>

            <?php
            if (!empty($left->beneficiarios)) {
                ?>
                <hr />
                <h3><span class="title-bullet"></span>Beneficiarios</h3>
                <?php 
                    echo ($i == 1)? htmlDiff ($fichas[1]->beneficiarios, $fichas[0]->beneficiarios):$left->beneficiarios;
                ?>
                <?php
            }

            if (!empty($left->doc_requeridos)) {
                ?>
                <hr />
                <h3><span class="title-bullet"></span>Documentos Requeridos</h3>
                <?php 
                    echo ($i == 1)? htmlDiff ($fichas[1]->doc_requeridos, $fichas[0]->doc_requeridos):$left->doc_requeridos;
                ?>
                <?php
            }

            if (!empty($left->guia_online) || !empty($left->guia_oficina) || !empty($left->guia_telefonico) || !empty($left->guia_correo)) {
                ?>
                <hr /><a name="howto"></a>
                <h3><span class="title-bullet"></span>Paso a Paso: Cómo realizar el trámite</h3>
                <div id="howto_tramite">

                    <!-- the tabs -->
                    <ul class="nav">
                        <?php
                        echo!empty($left->guia_online) ? '<li><a href="#online">En Línea</a></li>' : '';
                        echo!empty($left->guia_oficina) ? '<li><a href="#oficina">Oficina</a></li>' : '';
                        echo!empty($left->guia_telefonico) ? '<li><a href="#telefono">Telefónico</a></li>' : '';
                        echo!empty($left->guia_correo) ? '<li><a href="#correo">Correo</a></li>' : '';
                        ?>
                    </ul>

                    <!-- tab "panes" -->
                    <div class="panes">
                        <?php
                        echo!empty($left->guia_online) ? '<div id="online">' .( ($i == 1)? htmlDiff ($fichas[1]->guia_online, $fichas[0]->guia_online):$left->guia_online ). '</div>' : '';
                        echo!empty($left->guia_oficina) ? '<div id="oficina">' .( ($i == 1)? htmlDiff ($fichas[1]->guia_oficina, $fichas[0]->guia_oficina):$left->guia_oficina ). '</div>' : '';
                        echo!empty($left->guia_telefonico) ? '<div id="telefono">' .( ($i == 1)? htmlDiff ($fichas[1]->guia_telefonico, $fichas[0]->guia_telefonico):$left->guia_telefonico ). '</div>' : '';
                        echo!empty($left->guia_correo) ? '<div id="correo">' .( ($i == 1)? htmlDiff ($fichas[1]->guia_correo, $fichas[0]->guia_correo):$left->guia_correo ). '</div>' : '';
                        ?>
                    </div>
                </div>
                <?php
            }
            ?>

            <hr class="hidden" />
            <ul id="resumen_tramite" class="clearfix">
                <?php echo (!empty($left->plazo)) ? '<li class="first"><h4>Tiempo de Realización</h4><p>' .( ($i == 1)? htmlDiff ($fichas[1]->plazo, $fichas[0]->plazo):$left->plazo ). '</p></li>' : '' ?>
                <?php echo (!empty($left->vigencia)) ? '<li class="first"><h4>Vigencia del Trámite</h4><p>' .( ($i == 1)? htmlDiff ($fichas[1]->vigencia, $fichas[0]->vigencia):$left->vigencia ). '</p></li>' : '' ?>
                <?php echo (!empty($left->costo)) ? '<li class="first"><h4>Costo del Trámite</h4><p>' .( ($i == 1)? htmlDiff ($fichas[1]->costo, $fichas[0]->costo):$left->costo ). '</p></li>' : '' ?>
                <?php echo (!empty($left->marco_legal)) ? '<li class="marco_legal second"><h4>Marco Legal</h4><p>' .( ($i == 1)? htmlDiff ($fichas[1]->marco_legal, $fichas[0]->marco_legal):$left->marco_legal ). '</p></li>' : '' ?>
            </ul>
            <img class="qr" src="https://chart.googleapis.com/chart?chs=220x220&cht=qr&chid=<?= md5(uniqid(rand(), true)) ?>&chl=Tr&aacute;mite:%20<?= $left->titulo ?>%0D%0A%0D%0ADescripci&oacute;n:%20<?= substr(strip_tags($left->objetivo), 0, 800) ?>%0D%0A%0D%0AURL:%20<?= site_url('fichas/ver/' . $left->id . '/') ?>" alt="<?= $left->titulo ?>" /> 



        </td>
<?php
    $i++;
    endforeach; 
?>

    </tr>
</table>