<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Comentario extends Doctrine_Record {
    function  setTableDefinition() {
        $this->hasColumn('id');
        $this->hasColumn('comentario');
        $this->hasColumn('ficha_id');
        $this->hasColumn('usuario_frontend_id');
    }

    function  setUp() {
        parent::setUp();
        $this->actAs('Timestampable');

        
        $this->hasOne('Ficha', array(
            'local' => 'ficha_id',
            'foreign' => 'id'
        ));

        $this->hasOne('UsuarioFrontend', array(
            'local' => 'usuario_frontend_id',
            'foreign' => 'id'
        ));
        
    }
}
?>
