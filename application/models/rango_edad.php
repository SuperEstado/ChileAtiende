<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class RangoEdad extends Doctrine_Record {
    function  setTableDefinition() {
        $this->hasColumn('id');
        $this->hasColumn('edad_minima');
        $this->hasColumn('edad_maxima');
    }

    function  setUp() {
        parent::setUp();
        
        $this->hasMany('Ficha as Fichas', array(
            'local' => 'rango_edad_id',
            'foreign' => 'ficha_id',
            'refClass' => 'FichaHasRangoEdad'
        ));

    }
}
?>
