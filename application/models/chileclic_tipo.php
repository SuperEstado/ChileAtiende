<?php
class ChileclicTipo extends Doctrine_Record {
    function  setTableDefinition() {
        $this->hasColumn('id');
        $this->hasColumn('nombre');
    }

    function  setUp() {
        parent::setUp();

        $this->hasMany('ChileclicTema as ChileclicTemas', array(
            'local' => 'id',
            'foreign' => 'chileclic_tipo_id'
        ));

    }

}
?>