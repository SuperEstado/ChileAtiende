<?php

class FichaHasChileclicSubtema extends Doctrine_Record {
    function  setTableDefinition() {
        $this->hasColumn('ficha_id','integer',4,array (
            'primary' => true,
            'autoincrement' => false
        ));
        $this->hasColumn('chileclic_subtema_id','integer',4,array (
            'primary' => true,
            'autoincrement' => false
        ));
    }

    function  setUp() {
        parent::setUp();

    }
}
