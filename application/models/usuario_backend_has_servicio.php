<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class UsuarioBackendHasServicio extends Doctrine_Record {
    function  setTableDefinition() {
        $this->hasColumn('usuario_backend_id','integer',4,array (
            'primary' => true,
            'autoincrement' => false
        ));

        $this->hasColumn('servicio_codigo','varchar',8,array (
            'primary' => true,
            'autoincrement' => false
        ));
    }
}
?>
