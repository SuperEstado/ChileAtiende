<?php

    if(isset($fichas)){
        
        foreach($fichas as $ficha){
            $this->load->view('funcionarios/ficha_resultado_template',array('ficha'=>$ficha));
        }
        ?>
        <div class="paginacion">
            <form method="post" action="<?= site_url('funcionarios/buscar') ?>">
                <input class="movimiento_pagina" type="hidden" name="terminos_de_busqueda" value="<?= (isset($terminos_de_busqueda)) ? $terminos_de_busqueda : ""; ?>" />
                <?php if (isset($show_prev) && $show_prev) {?>
                <input type="submit" class="prev" name="prev" value="&lt;">
                <?php } ?>
                    <div class="paginacion_container">
                        <label for="page">Página <input type="text" id ="page" class="pagina" name="page" value="<?= ($page) ?>" /> de <?= $total_paginas ?></label>
                    </div>
                <?php if (isset($show_next) && $show_next) { ?>
                <input class="movimiento_pagina" type="submit" class="next" name="next" value="&gt;">
                <?php } ?>
            </form>
        </div>
        <?php

    }else{
        if($this->input->post('terminos_de_busqueda')){
            echo "<div class='resultado_sin_resultados'>Sin resultados</div>";
        }
    }

?>