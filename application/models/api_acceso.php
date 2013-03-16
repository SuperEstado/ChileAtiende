<?php

class ApiAcceso extends Doctrine_Record {
    function  setTableDefinition() {
        $this->hasColumn('id');
        $this->hasColumn('token');
        $this->hasColumn('email');
        $this->hasColumn('nombre');
        $this->hasColumn('apellido');
        $this->hasColumn('empresa');
    }

    function  setUp() {
        $this->actAs('Timestampable');

        parent::setUp();

    }
}
