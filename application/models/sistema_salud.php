<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class SistemaSalud extends Doctrine_Record {
    function  setTableDefinition() {
        $this->hasColumn('id');
        $this->hasColumn('nombre');
    }

    function  setUp() {
        parent::setUp();
        $this->actAs('Timestampable');

        $this->hasMany('UsuarioFrontend as UsuariosFrontend', array(
            'local' => 'id',
            'foreign' => 'sistema_salud_id'
        ));
    }
}
?>
