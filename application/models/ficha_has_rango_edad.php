<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class FichaHasRangoEdad extends Doctrine_Record {
    function  setTableDefinition() {
        $this->hasColumn('ficha_id','integer',10,array (
            'primary' => true,
            'autoincrement' => false
        ));

        $this->hasColumn('rango_edad_id','integer',10,array (
            'primary' => true,
            'autoincrement' => false
        ));
    }
}
?>
