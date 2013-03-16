<?php
if (empty($fichas[0]->Temas[0]->nombre)) {
    ?>
    <p class="alert_sin_contenido">No hay contenido asociado para esta etapa</p>
    <?php
} else {
    ?>
    <ul class="clearfix">
        <?php
        foreach ($fichas as $ficha) {
            $temas = $ficha->Temas;
            ?>
            <li>
                <span class="topic-cat tema-<? echo $ficha->Temas[0]->id ?>"><?php echo $ficha->Temas[0]->nombre; ?>
                    <span class="micro">
                        <?php
                        /*
                          $aux = 1;
                          foreach($ficha->Temas as $tema){
                          if($aux > 1 ){
                          echo " ".$tema->nombre;
                          }
                          $aux++;
                          }
                         * 
                         */
                        ?>
                    </span>
                </span>
                <h2><a href="<?= site_url('fichas/ver/' . $ficha->maestro_id . '/' . url_title($ficha->alias)); ?>"><?= character_limiter($ficha->titulo, 140); ?></a></h2>
                <p><?= character_limiter(strip_tags($ficha->objetivo), 140); ?></p>
                <a href="<?= site_url('fichas/ver/' . $ficha->maestro_id . '/' . url_title($ficha->alias)); ?>" class="more">Más Información</a>
            </li>
            <?
        }
        ?>
    </ul>

    <div class="paginacion">
        <form action="#">
        <?php if ($show_prev) { ?><a href="#" class="prev">&lt;</a><?php } ?>
            <div class="paginacion_container">
                <label for="pag">Página <input type="text" id ="pag" name="pag" value="<?= $page ?>" /> de <?= $total_paginas ?></label>
            </div>
        <?php if ($show_next) { ?><a href="#" class="next">&gt;</a><?php } ?>
        </form>
    </div>
    <?php
}
?>