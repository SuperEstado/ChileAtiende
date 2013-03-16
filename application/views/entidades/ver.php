<div id="content" class="clearfix">
    <div id="maincontent" class="left clearfix">
        <?php $sigla = ($entidad->sigla)?"(".$entidad->sigla.")":""; ?>
        <h2 class="title"><?= $entidad->nombre." ".$sigla; ?></h2>

        <?php
            $this->load->view("fichas/access_share_menu.php");
        ?>
        <hr class="shadow" />

        <?php
        if(!empty($entidad->mision)) {
        ?>
        <h3 class="first_topic">Misión Institucional</h3>
        <p><?= $entidad->mision ?></p>
        <hr class="hidden" />
        <?php
        }
        ?>

        <h3>Reparticiones</h3>
                        <!-- wrapper for navigator elements -->
                <div class="navi"></div>
        <ul class="reparticiones clearfix" id="browsable">
            <div id="items_scrollable">

            <?php
            $i=0;
            foreach($servicios as $servicio) {
                $i++;
                if($i==1){ echo "<span>";}
            ?>
            <li><a href="<?= site_url( 'servicios/ver/'.$servicio->codigo ) ?>"><?= $servicio->nombre ?></a></li>
            <?php if($i==10){ echo "</span>"; $i=0;}
            }
            ?>
            </div>
        </ul>

        <hr class="hidden" />
        <h3>Temas de la Institución</h3>
        <ul class="searchresults">
            <?php
            foreach ($fichas as $ficha) {
                ?>
                <li>
                    <h2><a href="<?= site_url('fichas/ver/' . $ficha->maestro_id) ?>"><?= $ficha->titulo ?></a></h2>
                    <p><?= character_limiter(strip_tags($ficha->objetivo), 140); ?> <a href="<?= site_url('fichas/ver/' . $ficha->maestro_id ) ?>">Ver más</a></p>
                    <p class="tipotramite">
                        <?= ($ficha->guia_online || $ficha->guia_oficina || $ficha->guia_telefonico || $ficha->guia_correo ? '<strong>Tipo de trámite:</strong>' : '') ?> <?=
            ($ficha->guia_online ? '<span class="tipo_tramite_online" title="En Línea">[En Línea]</span> En Línea ' : '') .
                    ($ficha->guia_oficina ? '<span class="tipo_tramite_oficina" title="En oficina">[En oficina]</span> En oficina ' : '') .
                    ($ficha->guia_telefonico ? '<span class="tipo_tramite_telefonico" title="Por teléfono">[Por teléfono]</span> Por teléfono ' : '') .
                    ($ficha->guia_correo ? '<span class="tipo_tramite_correo" title="Por correo">[Por correo]</span> Por correo ' : '')
                    ?>
                    </p>
                    <?php
                    $ficha_temas = array();
                        if(count($ficha->Temas)){
                            $ficha_temas = Array();
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
        <!--
        <div class="paginacion">
            <?php
            //$this->pagination->create_links()
            $finpag = floor( $total/$per_page) *10;
            ?>
            <?=$offset+1?>-<?= ( ($offset+$per_page)> $total ) ? $total : $offset+$per_page ?> de <?=$total?> | <a href="<?=$base_url.'&offset=0'?>">&LT; Inicio</a> | <a href="<?=$base_url.'&offset='.( ( ($offset+$per_page)< $total ) ? $offset-$per_page : ( ($offset==0) ? 0 : $offset-$per_page ) ) ?>">&Lt; Anterior</a> | <a href="<?=$base_url.'&offset='.( ( ($offset+$per_page)> $total ) ? $offset : $offset+$per_page ) ?>">Siguiente &Gt;</a> | <a href="<?=$base_url.'&offset='.$finpag ?>">Fin &GT;</a>
        </div>
        -->
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