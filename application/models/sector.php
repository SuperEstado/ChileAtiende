<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Sector extends Doctrine_Record {
    function  setTableDefinition() {
        $this->hasColumn('codigo', 'string', 8, array (
            'primary' => true,
            'autoincrement' => false
        ));
        $this->hasColumn('tipo');
        $this->hasColumn('nombre');
        $this->hasColumn('lat');
        $this->hasColumn('lng');
        $this->hasColumn('url');
        $this->hasColumn('sector_padre_codigo');
    }

    function  setUp() {
        parent::setUp();
        $this->actAs('Timestampable');

        $this->hasMany('UsuarioFrontend as UsuariosFrontend', array(
            'local' => 'codigo',
            'foreign' => 'sector_codigo'
        ));

        $this->hasOne('Sector as SectorPadre', array(
            'local' => 'sector_padre_codigo',
            'foreign' => 'codigo'
        ));

        $this->hasMany('Sector as SectorHijos', array(
            'local' => 'codigo',
            'foreign' => 'sector_padre_codigo'
        ));

        $this->hasMany('Oficina as Oficinas', array(
            'local' => 'codigo',
            'foreign' => 'sector_codigo'
        ));
        
        $this->hasMany('Modulo as Modulos', array(
            'local' => 'codigo',
            'foreign' => 'sector_codigo'
        ));

    }
}
?>
