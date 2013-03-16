<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Entidad extends Doctrine_Record {
    function  setTableDefinition() {
        $this->hasColumn('codigo', 'string', 8, array (
            'primary' => true,
            'autoincrement' => false
        ));
        $this->hasColumn('nombre');
        $this->hasColumn('mision');
        $this->hasColumn('sigla');
    }

    function  setUp() {
        parent::setUp();
        $this->hasMany('Servicio as Servicios', array(
            'local' => 'codigo',
            'foreign' => 'entidad_codigo'
        ));
        /*
        $this->hasMany('Ficha as Favoritos', array(
            'local' => 'entidad_codigo',
            'foreign' => 'ficha_id',
            'refClass' => 'EntidadHasFicha'
        ));*/
    }
}
?>
