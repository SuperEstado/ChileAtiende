<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Hit extends Doctrine_Record {
    function  setTableDefinition() {
        $this->hasColumn('id');
        $this->hasColumn('count');
        $this->hasColumn('fecha');
        $this->hasColumn('ficha_id');
    }

    function  setUp() {
        $this->hasOne('Ficha', array(
            'local' => 'ficha_id',
            'foreign' => 'id'
        ));
    }
}
?>
