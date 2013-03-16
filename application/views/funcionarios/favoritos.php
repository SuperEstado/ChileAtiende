<?php
    if(isset($favoritos) && is_array($favoritos) && count($favoritos)){

        foreach($favoritos as $ficha){
            $this->load->view('funcionarios/ficha_resultado_template',array('ficha'=>$ficha));
        }

    }else{
        echo "<div class='resultado_sin_favoritos'>Usted no tiene favoritos</div>";
    }

?>