<?php /* ?><?php $this->load->view("recomendacion/navegador_tematico.php"); ?><?php */ ?>

<div id="content" class="clearfix">
    <div id="maincontent" class="left clearfix">
        <div id="breadcrumbs"><a href="<?= site_url('/') ?>">Portada</a> / <a href="<?= site_url('/servicios/directorio/') ?>">Listado de Instituciones</a> / <?= $servicio->nombre ?></div>
        <?php $sigla = ($servicio->sigla) ? "(" . $servicio->sigla . ")" : ""; ?>
        <h2 class="title"><?= $servicio->nombre . " " . $sigla; ?></h2>

        <?php
        $this->load->view("fichas/access_share_menu.php");
        ?>
        <hr class="shadow" />

        <?php if (!empty($servicio->mision)) { ?>
            <h3 class="first_topic">Misión Institucional</h3>
            <p><?= $servicio->mision ?></p>
            <?php
        }
        ?>

        <?php ($servicio->url) ?><p><a href="<?= $servicio->url ?>" target="_blank"><?= $servicio->url ?></a></p>
        <hr class="hidden" />
        <h3>Esta institución depende de</h3>
        <ul class="entidad clearfix">
            <li><a href="<?= site_url('entidades/ver/' . $entidad->codigo ) ?>"><?= $entidad->nombre ?></a></li>
        </ul>
        <hr class="hidden" />
        <h3>Servicios o beneficios de la Institución (<?= $total ?>)</h3>

        <ul class="searchresults">
            <?php
            foreach ($fichas as $ficha) {
                $ficha_temas = array();
                ?>
                <li>
                    <h2><a href="<?= site_url('fichas/ver/' . $ficha->maestro_id ) ?>"><?= $ficha->titulo ?></a></h2>
                    <p><?= character_limiter(strip_tags($ficha->objetivo), 140); ?> <a href="<?= site_url('fichas/ver/' . $ficha->maestro_id ) ?>">Ver más</a></p>
                    <p class="tipotramite">
                        <?= ($ficha->guia_online || $ficha->guia_oficina || $ficha->guia_telefonico || $ficha->guia_correo ? '<strong>Tipo de trámite:</strong>' : '') ?> <?=
                    ($ficha->guia_online ? '<span class="tipo_tramite_online" title="En línea">[En línea]</span> En línea ' : '') .
                            ($ficha->guia_oficina ? '<span class="tipo_tramite_oficina" title="En oficina">[En oficina]</span> En oficina ' : '') .
                            ($ficha->guia_telefonico ? '<span class="tipo_tramite_telefonico" title="Por teléfono">[Por teléfono]</span> Por teléfono ' : '') .
                            ($ficha->guia_correo ? '<span class="tipo_tramite_correo" title="Por correo">[Por correo]</span> Por correo ' : '')
                        ?>
                    </p>
                    <?php
                    if (count($ficha->Temas)) {
                        echo "<span class='topic-cat'>Presente en temas:&nbsp;</span><span>";
                        foreach ($ficha->Temas as $tema) {
                            $ficha_temas[] = $tema->nombre;
                        }
                        echo enumerar_en_espanol($ficha_temas);
                        echo "</span>";
                    }
                    ?>
                </li>
                <?php
            }
            ?>

        </ul>
        <div class="paginacion">
            <?php
            if ($total > $per_page) {
                $finpag = floor($total / $per_page) * 10;
                $finpag = ($finpag == $total) ? $finpag - 10 : $finpag;
                $siguiente = ( ( ($offset + $per_page) > $total ) ? $offset : $offset + $per_page );
                $anterior = ( ( ($offset + $per_page) < $total ) ? ( ($offset <= 0) ? 0 : ($offset - $per_page) ) : ( ($offset <= 0) ? 0 : ($offset - $per_page) ) );
                ?>
                <?= $offset + 1 ?>-<?= ( ($offset + $per_page) > $total ) ? $total : $offset + $per_page ?> de <?= $total ?> | <a href="<?= $base_url . '/0' ?>">&lt; Inicio</a> | <a href="<?= $base_url . '/' . $anterior ?>">&lt;&lt; Anterior</a> | <a href="<?= $base_url . '/' . $siguiente ?>">Siguiente &gt;&gt;</a> | <a href="<?= $base_url . '/' . $finpag ?>">Fin &gt;</a>
                <?php
            }
            ?>
        </div>

    </div>

    <?php $this->load->view('widgets/relatedbar'); ?>

</div><!-- Content -->
