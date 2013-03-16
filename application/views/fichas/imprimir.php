<div id="print">
    <h2><?= $ficha->titulo ?></h2>
    <p>Institución responsable: <strong> <a href="<?= site_url('servicios/ver/' . $ficha->Servicio->codigo . '/' . url_title($ficha->Servicio->nombre)) ?>"><?= $ficha->Servicio->nombre ?></a></strong></p>

    <h3 class="first_topic">Descripción</h3>
    <p><?= $ficha->objetivo ?></p>

    <?php
    if (!empty($ficha->beneficiarios)) {
        ?>
        <h3>Beneficiarios</h3>
        <p><?= $ficha->beneficiarios ?></p>
        <?php
    }
    ?>

    <h3>Documentos Requeridos</h3>

    <h3>Paso a Paso: Cómo realizar el trámite</h3>
    
    <?php
    echo!empty($ficha->guia_online) ? '<h4>En Línea</h4>' : '';
    echo!empty($ficha->guia_online) ? '<br />' . $ficha->guia_online . '<br />' : '';

    echo!empty($ficha->guia_oficina) ? '<h4>Oficina</h4>' : '';
    echo!empty($ficha->guia_oficina) ? '<br />' . $ficha->guia_oficina . '<br />' : '';

    echo!empty($ficha->guia_telefonico) ? '<h4>Telefónico</h4>' : '';
    echo!empty($ficha->guia_telefonico) ? '<br />' . $ficha->guia_telefonico . '<br />' : '';

    echo!empty($ficha->guia_correo) ? '<h4>Carta</h4>' : '';
    echo!empty($ficha->guia_correo) ? '<br />' . $ficha->guia_correo . '<br />' : '';
    ?>


    <h4>Tiempo de Realización</h4><p><?= $ficha->plazo ?></p>
    <h4>Vigencia del Trámite</h4><p><?= $ficha->vigencia ?></p>
    <h4>Costo del Trámite</h4><p><?= $ficha->costo ?></p>
    <h4>Marco Legal</h4><p><?= $ficha->marco_legal ?></p>

</div>