<?php

/* FIX FILTROS PARA CASOS "NULL":  Array(0=>"") */
if (is_array($filtro_temas) && count($filtro_temas) == 1 && !$filtro_temas[0]) {
    $filtro_temas = array();
}

if (is_array($filtro_instituciones) && count($filtro_instituciones) == 1 && !$filtro_instituciones[0]) {
    $filtro_instituciones = array();
}

?>

<div id="content" class="clearfix">
    <div class="breadcrumbs" style="margin: 0 0 20px 17px;"><a href="<?= site_url('/') ?>">Portada</a> / Resultados de Búsqueda</div>
    <div id="maincontent" class="<?= ($total_paginas > 0) ? '' : 'full' ?> right clearfix">

        <div class="alerta <?= (!$total_fichas) ? "alert_sin_contenido" : ""; ?>">
            <!--<h2 class="title">Resultados de Búsqueda</h2>-->
            <div class="configuracion_busqueda">
                <ul>
                    <?php
                    $hay_resultados = isset($fichas) && count($fichas) > 0;

                    if (isset($opciones) && isset($opciones['filtros'])) {

                        $op = $opciones['filtros'];

                        $filtros = array();

                        if (isset($op['string']) && $op['string'] != "") {
                            $filtros[] = "contienen el(los) término(s) <b><i>'" . $op['string'] . "'</i></b>";
                        }
                        
                        if (isset($op['etapa'])) {
                            $filtros[] = "pertenecen a la etapa de vida <b><i>'" . $etapa->nombre . "'</i></b>";
                        }

                        if (isset($op['hecho'])) {
                            $filtros[] = "pertenecen al hecho de vida <b><i>'" . $hecho->nombre . "'</i></b>";
                        }

                        if (isset($op['edad']) && $op['edad'] != "") {
                            $filtros[] = "estén enfocadas a personas de aproximadamente <b>" . $op['edad'] . "</b> años";
                        }
                        if (isset($op['genero']) && $op['genero'] != "" && $op['genero'] > 1) {
                            $tipo_genero = Doctrine::getTable('genero')->findOneBy('id', $op['genero']);
                            $filtros[] = "estén orientados a público <b>" . $tipo_genero->nombre . "</b>";
                        }
                        if (isset($op['temas']) && count($op['temas']) > 0) {
                            if (isset($f_temas) && is_array($f_temas) && count($f_temas) > 0)
                                $filtros[] = "contengan el(los) tema(s): <b>" . enumerar_en_espanol($f_temas, 'y') . "</b>";
                        }
                        if (isset($op['servicios']) && count($op['servicios']) > 0) {

                            foreach ($instituciones as $institucion) {
                                if (in_array($institucion->codigo, $op['servicios']))
                                    $f_servicios[] = $institucion->nombre;
                            }
                            if (isset($f_servicios) && is_array($f_servicios) && count($f_servicios)) {
                                $filtros[] = "contengan la(s) institución(es) <b>" . enumerar_en_espanol($f_servicios, 'o') . "</b>";
                            }
                        }


                        if ($hay_resultados) {
                            echo "<li>Se ha encontrado <b>$total_fichas</b> resultado(s) que " . enumerar_en_espanol($filtros, 'y') . ".</li>";
                        } else {
                            echo "<li>No se han encontrado resultados.</li>";
                        }
                    }
                    ?>
                </ul>
            </div>
        </div>

        <ul class="searchresults">
<?php
if ($hay_resultados) {
    foreach ($fichas as $ficha):
        ?>

            <li <?= ($ficha->flujo) ? "class='flujo'" : "" ?> >
                <h2 style="font-size: 1.3em;"><a href="<?php echo "fichas/ver/" . $ficha->maestro_id; ?>" ><? echo (is_array($needles) && count($needles) > 0) ? highlight_phrases($ficha->titulo, $needles) : $ficha->titulo; ?></a></h2>

                <p>
                    <?php
                    
                    /*
                     * OBJETIVO DEL TRAMITE!
                     */
                    /*Busco en orden los campos para hacer highlight de las keywords, si no se encuentra en un campo se revisa el siguiente*/
                    //Si no encuentro en ninguno, tomo las primeras 50 palabras de la descripcion
                    $campos_texto = array('objetivo','beneficiarios','costo','vigencia','plazo','guia_online','guia_oficina','guia_telefonico','guia_correo','marco_legal','doc_requeridos');
                    
                    /* search_smart_truncate($ficha->objetivo,100, $needles) */
                    if (is_array($needles) && count($needles) > 0){
                        
                        foreach($campos_texto as $campo){
                            
                            $this->texthighlight->setText(strip_tags($ficha->$campo));
                            $this->texthighlight->setNeedles($needles);
                            $this->texthighlight->setRadius(6);
                            $this->texthighlight->createSegments();
                            $this->texthighlight->mergeSegments();
                            
                            $res =  implode(" ",$this->texthighlight->stringSegments());

                            $this->texthighlight->reset();
                            if($res) break;
                            
                        }
                        
                        if($res) echo $res;
                        else echo word_limiter(strip_tags($ficha->objetivo), 50);
                        
                        
                    }else{
                        echo word_limiter(strip_tags($ficha->objetivo), 50);
                    }
                    //break;
                    ?>
                    <a href="<?php echo "fichas/ver/" . $ficha->maestro_id; ?>" >Ver más</a>
                </p>
                <p class="tipotramite">
                    <?= ($ficha->guia_online || $ficha->guia_oficina || $ficha->guia_telefonico || $ficha->guia_correo ? '<strong>Tipo de trámite:</strong>' : '') ?> <?=
            ($ficha->guia_online ? '<span class="tipo_tramite_online" title="En Línea">En línea</span> En línea' : '') .
                    ($ficha->guia_oficina ? '<span class="tipo_tramite_oficina" title="En oficina">En oficina</span> En oficina' : '') .
                    ($ficha->guia_telefonico ? '<span class="tipo_tramite_telefonico" title="Por teléfono">Por teléfon]</span> Por teléfono' : '') .
                    ($ficha->guia_correo ? '<span class="tipo_tramite_correo" title="Por correo">Por correo</span> Por correo' : '')
                    ?>
                </p>
                <p class="adicional"><a href="<?= site_url("servicios/ver/" . $ficha->Servicio->codigo); ?>"><?= $ficha->Servicio->nombre ?><?= ($ficha->Servicio->sigla) ? ' ('.$ficha->Servicio->sigla.')' : '' ?></a>
                    <?php
                    $ficha->refreshRelated('Temas');
                    if (count($ficha->Temas)) {
                        echo "<br/>";
                        echo "<span class='topic-cat'>Presente en temas:&nbsp;</span><span>";

                        $ficha_temas = array();
                        foreach ($ficha->Temas as $tema) {
                            if(in_array($tema->id,$hidden_filter_temas)){
                                $ficha_temas[] = "<span class='on'>".$tema->nombre."</span>";
                            }else{
                                $ficha_temas[] = $tema->nombre;
                            }
                        }
                        echo enumerar_en_espanol($ficha_temas);

                        echo "</span>";
                    }
                    ?>
                </p>     
            </li>

            <?php 
                endforeach;
            }
            ?>
        </ul>
            <?php
            $this->load->view("busqueda/navegador_tematico");
            if (isset($total_paginas) && $total_paginas > 1) {
                ?>
            <div class="paginacion">
                <form method="get" action="buscar/fichas/">
                    <?= (isset($hidden_string)) ? '<input type="hidden" name="buscar" value="'.$hidden_string.'" />' : ""; ?>
                    <?= (isset($hidden_hecho)) ? '<input type="hidden" name="hecho" value="'.$hidden_hecho. '" />' : ""; ?>
                    <?= (isset($genero)) ? '<input type="hidden" name="genero" value="'.$genero.'"/>' : ""; ?>
                    <?= (isset($edad)) ? '<input type="hidden" name="edad" value="'.$edad.'" />' : ""; ?>
                    <?= (isset($filtro_temas)) ? '<input type="hidden" name="temas" value="'.implode(",", $filtro_temas).'" />' : ""; ?>
                    <?= (isset($filtro_instituciones) && count($filtro_instituciones)) ? '<input type="hidden" name="instituciones" value="'.implode(",", $filtro_instituciones).'" />' : ""; ?>
    <?php if (isset($show_prev) && $show_prev) { ?><input type="submit" class="prev" name="prev" value="&lt;"><?php } ?>
                    <div class="paginacion_container">
                        <label for="page">Página <input type="text" id ="page" name="page" value="<?= ($page) ?>" /> de <?= $total_paginas ?></label>
                    </div>
                    <?php if (isset($show_next) && $show_next) { ?><input type="submit" class="next" name="next" value="&gt;" /><?php } ?>
                </form>
            </div>
    <?php
}
?>
    </div>
<?php
if ($total_paginas > 0) {
    $this->load->view('busqueda/filtros');
}
?>
</div><!-- Content -->
<script type="text/javascript">
    $(document).ready(function(){
        if ($("div#maincontent").height() > $("div#sidebar").height()) {
            $("div#sidebar").height($("div#maincontent").height())
        }else{
            $("div#maincontent").height($("div#sidebar").height())
        }
    });
</script>