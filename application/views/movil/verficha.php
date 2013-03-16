<div class="encabezado_ficha">
    <!--Aca se revisa si la ficha tiene convenio con redchile-->
    <?= ($ficha->convenio) ? "<div class='convenio'>Convenio ChileAtiende</div>" : ""; ?>
    <h2 class="title"><?= $ficha->titulo ?></h2>
    <p class="responsible">Institución: <strong> <a href="<?= site_url('movil/entidades/ver/' . $ficha->Servicio->codigo) ?>"><?= $ficha->Servicio->nombre ?></a></strong></p>
    <?php if($ficha->publicado_at): ?><p class="meta">Última actualización: <?= strftime('%d/%m/%Y', mysql_to_unix($ficha->publicado_at)) ?></p><?php endif; ?>
</div>

<?php if (!empty($ficha->objetivo)) {
 ?>
        <div class="descripcion">
            <h3 class="first_topic">Descripción</h3>
<?= prepare_content_ficha($ficha->objetivo, true) ?>
    </div>
<?php } ?>

<?php if (!empty($ficha->beneficiarios)) { ?>
        <div class="beneficiarios">
            <h3>Beneficiarios</h3>
<?= prepare_content_ficha($ficha->beneficiarios, true) ?>
    </div>
<?php } ?>

<?php if (!empty($ficha->doc_requeridos)) { ?>
        <div class="documentos">
            <h3>Documentos requeridos</h3>
<?= prepare_content_ficha($ficha->doc_requeridos, true) ?>
    </div>
<?php } ?>

<?php if (!empty($ficha->guia_online) || !empty($ficha->guia_oficina) || !empty($ficha->guia_telefonico) || !empty($ficha->guia_correo)) { ?>
        <div class="block guias">
            <h3>Cómo realizar el trámite</h3>
    <?php
        echo!empty($ficha->guia_online) ? '<div id="online"> <h4>Via Online</h4>' . prepare_content_ficha($ficha->guia_online, true) . '</div>' : '';
        echo!empty($ficha->guia_oficina) ? '<div id="oficina"> <h4>Via Oficina</h4>' . prepare_content_ficha($ficha->guia_oficina, true) . '</div>' : '';
        echo!empty($ficha->guia_telefonico) ? '<div id="telefono"> <h4>Via Telefonica:</h4>' . prepare_content_ficha($ficha->guia_telefonico, true) . '</div>' : '';
        echo!empty($ficha->guia_correo) ? '<div id="correo"> <h4>Via Correo</h4>' . prepare_content_ficha($ficha->guia_correo, true) . '</div>' : '';
    ?>
    </div>
<?php } ?>

<?php if (!empty($ficha->plazo)) { ?>
        <div id="tiempo" class="clearfix">
    <?php
        echo!empty($ficha->plazo) ? '<h3>Tiempo de realización</h3><p>' . prepare_content_ficha($ficha->plazo, true) . '</p>' : '';
    ?>
    </div>
<?php } ?>

<?php if (!empty($ficha->vigencia)) { ?>
        <div id="vigencia" class="clearfix">
    <?php
        echo!empty($ficha->vigencia) ? '<h3>Vigencia del trámite</h3><p>' . prepare_content_ficha($ficha->vigencia, true) . '</p>' : '';
    ?>
    </div>
<?php } ?>

<?php if (!empty($ficha->costo)) { ?>
        <div id="costo" class="clearfix">
    <?php
        echo!empty($ficha->costo) ? '<h3>Costo del trámite</h3><p>' . prepare_content_ficha($ficha->costo, true) . '</p>' : '';
    ?>
    </div>
<?php } ?>

<?php if (!empty($ficha->cc_observaciones)) { ?>
        <div id="info_relacionada" class="clearfix">
    <?php
        echo!empty($ficha->cc_observaciones) ? '<h3>Información relacionada</h3><p>' . prepare_content_ficha($ficha->cc_observaciones, true) . '</p>' : '';
    ?>
    </div>
<?php } ?>

<?php if (!empty($ficha->marco_legal)) { ?>
        <div id="marco_legal" class="clearfix">
    <?php
        echo!empty($ficha->marco_legal) ? '<h3>Marco legal</h3><p>' . prepare_content_ficha($ficha->marco_legal, true) . '</p>' : '';
    ?>
    </div>
<?php } ?>


        <div data-role="page" id="ficha" data-theme="d">
            <div data-role="header" data-theme="a">
                <h1><img src="jquery-mobile/images/logo.png" width="116" height="37" alt="ChileAtiende"></h1>
            </div>
            <div data-role="content">
                <div data-role="navbar" class="ui-navbar">
                    <ul>
                        <li><a href="#home" data-theme="c">Buscador</a></li>
                        <li><a href="#etapas" data-theme="c">Etapas</a></li>
                    </ul>
                </div>
            </div>
        </div>