<?php

    if((isset($mas_vistos) || isset($destacados) ) && (count($mas_vistos)+count($destacados))>0 ){

        if(isset($destacados) && count($destacados) > 0){

            echo "<h3 class='title'>Destacados</h3>";
            foreach($destacados as $ficha){
                $this->load->view('funcionarios/ficha_resultado_template',array('ficha'=>$ficha));
            }

        }
        if(isset($mas_vistos) && count($mas_vistos) > 0){
            echo "<h3 class='title'>Más Vistos</h3>";
            foreach($mas_vistos as $ficha){
                $this->load->view('funcionarios/ficha_resultado_template',array('ficha'=>$ficha));
            }
        }
    }else{
        if($this->input->post('terminos_de_busqueda')){
            echo "<div class='resultado_sin_resultados'>Sin resultados</div>";
        }
    }

?>