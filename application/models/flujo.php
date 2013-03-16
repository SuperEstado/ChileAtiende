<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Flujo extends Doctrine_Record {

    function setTableDefinition() {
        $this->hasColumn('id');
        $this->hasColumn('titulo');
        $this->hasColumn('alias');
        $this->hasColumn('descripcion');
    }

    function setUp() {
        parent::setUp();

        $this->actAs('Timestampable');

        $this->hasMany('HechoVida as HechosVida', array(
            'local' => 'flujo_id',
            'foreign' => 'hecho_vida_id',
            'refClass' => 'FlujoHasHechoVida'
        ));
    }

}

?>
