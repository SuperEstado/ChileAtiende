<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Oficina extends Doctrine_Record {
    function  setTableDefinition() {
        $this->hasColumn('id');
        $this->hasColumn('nombre');
        $this->hasColumn('direccion');
        $this->hasColumn('horario');
        $this->hasColumn('telefonos');
        $this->hasColumn('fax');
        $this->hasColumn('sector_codigo');
        $this->hasColumn('servicio_codigo');
        $this->hasColumn('lat');
        $this->hasColumn('lng');
        $this->hasColumn('director');
    }

    function  setUp() {
        parent::setUp();
        $this->actAs('Timestampable');

        $this->hasOne('Sector', array(
            'local' => 'sector_codigo',
            'foreign' => 'codigo'
        ));

        $this->hasOne('Servicio', array(
            'local' => 'servicio_codigo',
            'foreign' => 'codigo'
        ));
        
        $this->hasMany('Modulo as Modulos', array(
            'local' => 'id',
            'foreign' => 'id_oficina'
        ));
    }
}
?>
