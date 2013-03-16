<?php

class Configuracion extends Doctrine_Record {

    function setTableDefinition() {
        $this->hasColumn('parametro','varchar',255,array (
            'primary' => true,
            'autoincrement' => false
        ));
        $this->hasColumn('valor');
    }
}