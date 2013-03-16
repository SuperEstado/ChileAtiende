<?php

class ModuloAtencion extends Doctrine_Record {
    function setTableDefinition() {
        $this->hasColumn('id');
        $this->hasColumn('sector_codigo');
        $this->hasColumn('oficina_id');
        $this->hasColumn('servicio_codigo');
        $this->hasColumn('nro_maquina');
        $this->hasColumn('descripcion');
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
        
        $this->hasOne('Oficina', array(
            'local' => 'oficina_id',
            'foreign' => 'id'
        ));
    }
}
