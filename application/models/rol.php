<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Rol extends Doctrine_Record {
    function  setTableDefinition() {
        $this->hasColumn('id');
        $this->hasColumn('nombre');
        $this->hasColumn('descripcion');
    }

    function  setUp() {
        parent::setUp();
        $this->actAs('Timestampable');

        $this->hasMany('UsuarioBackend as UsuariosBackend', array(
            'local' => 'rol_id',
            'foreign' => 'usuario_backend_id',
            'refClass' => 'UsuarioBackendHasRol'
        ));

    }
}
?>
