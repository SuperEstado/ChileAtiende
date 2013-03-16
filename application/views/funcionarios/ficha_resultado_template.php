<?php
    $class = "";
    if($ficha->convenio){
        $class = "convenio_redchile";
    }
    $ver= "tver";
    if($on == 'listar') $ver = "lver";

echo "<section class='result clearfix'>\n";
echo "\n<h2>" . anchor("funcionarios/fichas/$ver/" . $ficha->maestro_id,$ficha->titulo, "class='resultado_more_info'") . "</h2>\n\n";
/*Pongo la estrella de favoritos*/
if(is_array($cookie_favoritos) && in_array($ficha->maestro_id,$cookie_favoritos))
    echo "<div id='{$ficha->maestro_id}' class='star'>Quitar Favorito</div>\n";
else
    echo "<div id='{$ficha->maestro_id}' class='star off'> Agregar como Favorito </div>\n";
echo "<div class='$class'></div>";
echo "<p class='abstract clearfix'>" . word_limiter(strip_tags($ficha->objetivo), 30) . "\n" . anchor("funcionarios/fichas/tver/" . $ficha->maestro_id, "Ver Cartilla de Servicio", "class='resultado_ver_cartilla'")."</p>\n";
echo "</section>\n";
?>
