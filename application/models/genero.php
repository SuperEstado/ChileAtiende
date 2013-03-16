<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Genero extends Doctrine_Record {
    function  setTableDefinition() {
        
        $this->hasColumn('id');
        $this->hasColumn('nombre');
    }

    function  setUp() {
        parent::setUp();
        $this->hasMany('Ficha as Fichas', array(
            'local' => 'id',
            'foreign' => 'genero_id'
        ));
    }
}
?>
