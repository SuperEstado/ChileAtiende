<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Evaluacion extends Doctrine_Record {
    function  setTableDefinition() {
        $this->hasColumn('id');
        $this->hasColumn('rating');
        $this->hasColumn('ficha_id');
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
