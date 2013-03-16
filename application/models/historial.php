<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Historial extends Doctrine_Record {
    function  setTableDefinition() {
        $this->hasColumn('id');
        $this->hasColumn('ficha_id');
        $this->hasColumn('ficha_version_id');
        $this->hasColumn('usuario_backend_id');
        $this->hasColumn('descripcion');
    }

    function  setUp() {
        parent::setUp();
        $this->actAs('Timestampable');

        $this->hasOne('UsuarioBackend', array(
            'local' => 'usuario_backend_id',
            'foreign' => 'id'
        ));

        $this->hasOne('Ficha', array(
            'local' => 'ficha_id',
            'foreign' => 'id'
        ));

        $this->hasOne('Ficha as FichaVersion', array(
            'local' => 'ficha_version_id',
            'foreign' => 'id'
        ));

    }
}
?>
