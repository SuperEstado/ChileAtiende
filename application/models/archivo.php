<?php

class Archivo extends Doctrine_Record {
    function  setTableDefinition() {
        $this->hasColumn('id');
        $this->hasColumn('ficha_id');
        $this->hasColumn('nombre');
        $this->hasColumn('url');
        $this->hasColumn('tipo');
    }

    function  setUp() {
        parent::setUp();

        $this->hasOne('Ficha', array(
            'local' => 'ficha_id',
            'foreign' => 'id'
        ));

    }
}
?>
