<div id="maincontent" class="empresas">
    <div class="breadcrumbs" style="margin: 0 0 20px 0"><a href="<?= site_url('/') ?>">Portada</a> / <a href="<?= site_url('/empresas') ?>">Empresa y Organizaciones</a> / <?= $subtema->nombre ?></div>
    <h2 class="empresas"><?= $subtema->nombre ?></h2>
    <ul class="searchresults">

        <?php foreach ($fichas as $f): ?>
            <li>
                <h2><a href="<?= site_url('fichas/ver/' . $f->Maestro->id) ?>"><?= $f->titulo ?></a></h2>
                <p><?= word_limiter(strip_tags($f->objetivo), 50) ?></p>

                <p class="tipotramite">
                    <?= ($f->guia_online || $f->guia_oficina || $f->guia_telefonico || $f->guia_correo ? '<strong>Tipo de trámite:</strong>' : '') ?> <?=
                        ($f->guia_online ? '<span class="tipo_tramite_online" title="En Línea">En línea</span> En línea' : '') .
                        ($f->guia_oficina ? '<span class="tipo_tramite_oficina" title="En oficina">En oficina</span> En oficina' : '') .
                        ($f->guia_telefonico ? '<span class="tipo_tramite_telefonico" title="Por teléfono">Por teléfon]</span> Por teléfono' : '') .
                        ($f->guia_correo ? '<span class="tipo_tramite_correo" title="Por correo">Por correo</span> Por correo' : '')
                    ?>
                </p>
                
                <p class="adicional"><a href="<?= site_url("servicios/ver/" . $f->Servicio->codigo); ?>"><?= $f->Servicio->nombre ?><?= ($f->Servicio->sigla) ? ' ('.$f->Servicio->sigla.')' : '' ?></a></p>
            </li>
        <?php endforeach; ?>

    </ul>
</div>
