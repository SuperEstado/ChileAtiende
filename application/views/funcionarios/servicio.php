<?php

    $sel_servicio = $this->input->get_post('servicio');

    echo "<form method='post'>";
    echo "<select name='servicio' data-placeholder='Seleccione un servicio...' class='chzn-select' style='width: 290px;'>";
    echo "<option value=''></option>";
    foreach ($servicios as $servicio) {
        if($servicio->codigo == $sel_servicio)
            echo "<option selected value='$servicio->codigo'>" . $servicio->nombre . " (".$servicio->numero_fichas.")  </option>";
        else
            echo "<option value='$servicio->codigo'>" . $servicio->nombre . " (".$servicio->numero_fichas.")  </option>";
    }
    echo "</select>";
    echo "<input type ='submit' value='Buscar' name='buscar'>";
    echo "</form>";
    
    if ($sel_servicio) {
        if (isset($fichas)) {

            foreach ($fichas as $ficha) {
                $this->load->view('funcionarios/ficha_resultado_template', array('ficha' => $ficha));
            }
        } else {
            echo "<div class='resultado_sin_resultados'>No hay fichas asociadas a este servicio</div>";
        }
    }
?>
<script type="text/javascript">
    $(".chzn-select").chosen();
</script>

