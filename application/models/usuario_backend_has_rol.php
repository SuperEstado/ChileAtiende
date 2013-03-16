<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class UsuarioBackendHasRol extends Doctrine_Record {
    function  setTableDefinition() {
        $this->hasColumn('usuario_backend_id','integer',4,array (
            'primary' => true,
            'autoincrement' => false
        ));

        $this->hasColumn('rol_id','varchar',16,array (
            'primary' => true,
            'autoincrement' => false
        ));
    }
}
?>
