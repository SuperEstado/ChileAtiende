<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function make_description($comparacion, $ficha_nueva) {
    $descripcion = "";
    $json_comentarios = $ficha_nueva->comentarios;
    $comentarios = null;
    if($json_comentarios != null)
        $comentarios = json_decode($json_comentarios,true);

    foreach ($comparacion as $key => $val) {
        $descripcion.='<p>Modificación en <strong>' . ucwords($key) . '</strong> de '.( ($ficha_nueva->flujo)?'flujo':'ficha').' <strong>#' . $ficha_nueva->id . '</strong>:</p>';
        
        $descripcion.='<ul>';
        foreach ($val->left as $comp)
            $descripcion.='<li>' . $comp . '</li>';
        $descripcion.='</ul>';
        if (is_array($comentarios) && isset($comentarios[$key]) && $comentarios[$key]!="") {
            $descripcion .= "<p class='comment_toggle'><strong>Leer Comentarios (+)</strong></p>";
            $descripcion .= "<p class='comment'><strong>Ocultar Comentarios (-)</strong><br/>" . $comentarios[$key] . "</p>";
        }
        $descripcion.='<br />';
    }

    return $descripcion;
}

?>
