<?php
$css_tema = "tema-10";
if ($ficha->Temas) {
    $css_tema = "tema-" . $ficha->Temas[0]->id;
}
?>
<div id="content" class="clearfix">
    <div id="maincontent" class="left clearfix">
        <div class="wrap_header_ficha clearfix <? echo $css_tema ?>">
            <h2 class="title"><?= $ficha->titulo ?></h2>
            <p class="responsible">Institución responsable: <strong> <?= $ficha->Servicio->nombre ?></strong></p>
            <p class="meta">Última actualización: <?= strftime('%d/%m/%Y', mysql_to_unix($ficha->updated_at)) ?></p>

            <dl id="options">
                <?php
                if (!empty($ficha->guia_online) || !empty($ficha->guia_oficina) || !empty($ficha->guia_telefonico) || !empty($ficha->guia_correo)) {
                    ?>
                    <dd><a href="<?= current_url() ?>#howto" class="red-text">Cómo realizar este trámite</a></dd>
                    <?php
                }
                ?>
                <dd class="ratingFicha"></dd>
            </dl>
            <ul class="access_share_menu">
                <li><a class="overlay facebook">Facebook</a></li>
                <li><a class="overlay twitter">Twitter</a></li>
                <li><a class="overlay consultar">Consultar</a></li>
                <li><a class="imprimir">Imprimir</a></li>
                <li><a class="overlay escuchar">Escuchar</a></li>
                <li><a class="text-size-max">Aumentar</a><a class="text-size-min">Disminuir</a></li>              
            </ul>
            
        </div>

        <hr class="shadow" />

        <h3 class="first_topic"><span class="title-bullet <? echo $css_tema ?>"></span>Descripción</h3>
        <?= $ficha->objetivo ?>

        <?php
        if (!empty($ficha->beneficiarios)) {
            ?>
            <hr />
            <h3><span class="title-bullet <? echo $css_tema ?>"></span>Beneficiarios</h3>
            <?= $ficha->beneficiarios ?>
            <?php
        }

        if (!empty($ficha->doc_requeridos)) {
            ?>
            <hr />
            <h3><span class="title-bullet <? echo $css_tema ?>"></span>Documentos Requeridos</h3>
            <?= $ficha->doc_requeridos ?>
            <?php
        }

        if (!empty($ficha->guia_online) || !empty($ficha->guia_oficina) || !empty($ficha->guia_telefonico) || !empty($ficha->guia_correo)) {
            ?>
            <hr /><a name="howto"></a>
            <h3><span class="title-bullet <? echo $css_tema ?>"></span>Paso a Paso: Cómo realizar el trámite</h3>
            <div id="howto_tramite">

                <!-- the tabs -->
                <ul class="nav">
                    <?php
                    echo!empty($ficha->guia_online) ? '<li><a href="#online">En Línea</a></li>' : '';
                    echo!empty($ficha->guia_oficina) ? '<li><a href="#oficina">Oficina</a></li>' : '';
                    echo!empty($ficha->guia_telefonico) ? '<li><a href="#telefono">Telefónico</a></li>' : '';
                    echo!empty($ficha->guia_correo) ? '<li><a href="#correo">Correo</a></li>' : '';
                    ?>
                </ul>

                <!-- tab "panes" -->
                <div class="panes">
                    <?php
                    echo!empty($ficha->guia_online) ? '<div id="online">' . $ficha->guia_online . '</div>' : '';
                    echo!empty($ficha->guia_oficina) ? '<div id="oficina">' . $ficha->guia_oficina . '</div>' : '';
                    echo!empty($ficha->guia_telefonico) ? '<div id="telefono">' . $ficha->guia_telefonico . '</div>' : '';
                    echo!empty($ficha->guia_correo) ? '<div id="correo">' . $ficha->guia_correo . '</div>' : '';
                    ?>
                </div>
            </div>
            <?php
        }
        ?>

        <hr class="hidden" />
        <ul id="resumen_tramite" class="clearfix">
            <?php echo!empty($ficha->plazo) ? '<li class="first"><h4>Tiempo de Realización</h4><p>' . $ficha->plazo . '</p></li>' : '' ?>
            <?php echo!empty($ficha->vigencia) ? '<li class="first"><h4>Vigencia del Trámite</h4><p>' . $ficha->vigencia . '</p></li>' : '' ?>
            <?php echo!empty($ficha->costo) ? '<li class="first"><h4>Costo del Trámite</h4><p>' . $ficha->costo . '</p></li>' : '' ?>
            <?php echo!empty($ficha->marco_legal) ? '<li class="marco_legal second"><h4>Marco Legal</h4><p>' . $ficha->marco_legal . '</p></li>' : '' ?>
        </ul>
        <img class="qr" src="https://chart.googleapis.com/chart?chs=220x220&cht=qr&chid=<?= md5(uniqid(rand(), true)) ?>&chl=Tr&aacute;mite:%20<?= $ficha->titulo ?>%0D%0A%0D%0ADescripci&oacute;n:%20<?= substr(strip_tags($ficha->objetivo), 0, 800) ?>%0D%0A%0D%0AURL:%20<?= site_url('fichas/ver/' . $ficha->id . '/') ?>" alt="<?= $ficha->titulo ?>" /> 
        
        
    </div>
</div>