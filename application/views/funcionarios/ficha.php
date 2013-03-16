<div class="encabezado_ficha">
    <?php
    if (isset($mail_stat)) {
        if ($mail_stat) {
            echo "<div class='ok'>Correo enviado exitosamente.</div>";
        } else {
            echo "<div class='error'>Hubo un problema enviando el correo.</div>";
        }
    }
    ?>

    <!--Aca se revisa si la ficha tiene convenio con redchile-->
    <?= ($ficha->convenio) ? "<div class='convenio'>Convenio ChileAtiende</div>" : ""; ?>
    <?php
    if (is_array($cookie_favoritos) && in_array($ficha->maestro_id, $cookie_favoritos))
        echo "<div id='{$ficha->maestro_id}' class='star'>Quitar Favorito</div>\n";
    else
        echo "<div id='{$ficha->maestro_id}' class='star off'> Agregar como Favorito </div>\n";
    ?>
    <h2 class="title"><?= $ficha->titulo ?></h2>
    <p class="responsible">Institución: <strong> <a href="<?= site_url('funcionarios/servicios/?servicio=' . $ficha->Servicio->codigo) ?>"><?= $ficha->Servicio->nombre ?></a></strong></p>
    <?php if($ficha->publicado_at): ?><p class="meta">Última actualización: <?= strftime('%d/%m/%Y', mysql_to_unix($ficha->publicado_at)) ?></p><?php endif; ?>
</div>

<?php if (!empty($ficha->objetivo)) {
 ?>
        <div class="descripcion">
            <h3 class="first_topic">Descripción</h3>
<?= $ficha->objetivo ?>
    </div>
<?php } ?>

<?php if (!empty($ficha->beneficiarios)) { ?>
        <div class="beneficiarios">
            <h3>Beneficiarios</h3>
<?= $ficha->beneficiarios ?>
    </div>
<?php } ?>

<?php if (!empty($ficha->doc_requeridos)) { ?>
        <div class="documentos">
            <h3>Documentos requeridos</h3>
<?= $ficha->doc_requeridos ?>
    </div>
<?php } ?>

<?php if (!empty($ficha->guia_online) || !empty($ficha->guia_oficina) || !empty($ficha->guia_telefonico) || !empty($ficha->guia_correo)) { ?>
        <div class="block guias">
            <h3>Cómo realizar el trámite</h3>
    <?php
        echo!empty($ficha->guia_online) ? '<div id="online"> <h4>Via Online</h4>' . $ficha->guia_online . '</div>' : '';
        echo!empty($ficha->guia_oficina) ? '<div id="oficina"> <h4>Via Oficina</h4>' . $ficha->guia_oficina . '</div>' : '';
        echo!empty($ficha->guia_telefonico) ? '<div id="telefono"> <h4>Via Telefonica:</h4>' . $ficha->guia_telefonico . '</div>' : '';
        echo!empty($ficha->guia_correo) ? '<div id="correo"> <h4>Via Correo</h4>' . $ficha->guia_correo . '</div>' : '';
    ?>
    </div>
<?php } ?>

<?php if (!empty($ficha->plazo)) { ?>
        <div id="tiempo" class="clearfix">
    <?php
        echo!empty($ficha->plazo) ? '<h3>Tiempo de realización</h3><p>' . $ficha->plazo . '</p>' : '';
    ?>
    </div>
<?php } ?>

<?php if (!empty($ficha->vigencia)) { ?>
        <div id="vigencia" class="clearfix">
    <?php
        echo!empty($ficha->vigencia) ? '<h3>Vigencia del trámite</h3><p>' . $ficha->vigencia . '</p>' : '';
    ?>
    </div>
<?php } ?>

<?php if (!empty($ficha->costo)) { ?>
        <div id="costo" class="clearfix">
    <?php
        echo!empty($ficha->costo) ? '<h3>Costo del trámite</h3><p>' . $ficha->costo . '</p>' : '';
    ?>
    </div>
<?php } ?>

<?php if (!empty($ficha->cc_observaciones)) { ?>
        <div id="info_relacionada" class="clearfix">
    <?php
        echo!empty($ficha->cc_observaciones) ? '<h3>Información relacionada</h3><p>' . $ficha->cc_observaciones . '</p>' : '';
    ?>
    </div>
<?php } ?>

<?php if (!empty($ficha->marco_legal)) { ?>
        <div id="marco_legal" class="clearfix">
    <?php
        echo!empty($ficha->marco_legal) ? '<h3>Marco legal</h3><p>' . $ficha->marco_legal . '</p>' : '';
    ?>
    </div>
<?php } ?>



<div class="iframe"></div>

<div class="modal" id="mod">
    <p>Enviar cartilla por correo</p>
    <form method="post">
        <input type="text" value="" name="mail" placeholder="Correo Electronico..." /><br/>
        <textarea name="comentarios" placeholder="Comentarios..."></textarea><br/>
        <button type="submit"> Enviar </button>
    </form>
    <br />

</div>