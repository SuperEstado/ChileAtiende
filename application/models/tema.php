<?php
class Tema extends Doctrine_Record {
    function  setTableDefinition() {
        $this->hasColumn('id');
        $this->hasColumn('nombre');
    }

    function  setUp() {
        parent::setUp();

        $this->hasMany('Ficha as Fichas', array(
            'local' => 'tema_id',
            'foreign' => 'ficha_id',
            'refClass' => 'FichaHasTema'
        ));

    }

    public function toString() {
        return $this->nombre;
    }
}
?>