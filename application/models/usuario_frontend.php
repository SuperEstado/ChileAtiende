<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class UsuarioFrontend extends Doctrine_Record {
    function  setTableDefinition() {
        $this->hasColumn('id');
        $this->hasColumn('email');
        $this->hasColumn('nombres');
        $this->hasColumn('apellidos');
        $this->hasColumn('sexo');
        $this->hasColumn('edad');
        $this->hasColumn('sector_codigo');
        $this->hasColumn('sistema_salud_id');
        $this->hasColumn('sistema_previsional_id');
        $this->hasColumn('password');
    }

    function  setUp() {
        parent::setUp();
        $this->actAs('Timestampable');

        $this->hasMany('Evaluacion as Evaluaciones', array(
            'local' => 'id',
            'foreign' => 'usuario_frontend_id'
        ));

        $this->hasOne('SistemaPrevisional', array(
            'local' => 'sistema_previsional_id',
            'foreign' => 'id'
        ));

        $this->hasOne('SistemaSalud', array(
            'local' => 'sistema_salud_id',
            'foreign' => 'id'
        ));

        $this->hasOne('Sector', array(
            'local' => 'sector_codigo',
            'foreign' => 'codigo'
        ));

    }
}
?>
