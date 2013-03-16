<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Revision extends Doctrine_Record {
    function  setTableDefinition() {
        $this->hasColumn('id');
        $this->hasColumn('aprobada');
        $this->hasColumn('justificacion');
        $this->hasColumn('ficha_id');
        $this->hasColumn('publicado');
        $this->hasColumn('publicado_at');
    }

    function  setUp() {
        parent::setUp();
        $this->actAs('Timestampable');

        
        $this->hasOne('Ficha', array(
            'local' => 'ficha_id',
            'foreign' => 'id'
        ));
        
    }
}
?>
