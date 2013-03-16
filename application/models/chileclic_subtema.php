<?php
class ChileclicSubtema extends Doctrine_Record {
    function  setTableDefinition() {
        $this->hasColumn('id');
        $this->hasColumn('nombre');
        $this->hasColumn('chileclic_tema_id');
    }

    function  setUp() {
        parent::setUp();

        $this->hasMany('Ficha as Fichas', array(
            'local' => 'chileclic_subtema_id',
            'foreign' => 'ficha_id',
            'refClass' => 'FichaHasChileclicSubtema'
        ));

        $this->hasOne('ChileclicTema', array(
            'local' => 'chileclic_tema_id',
            'foreign' => 'id'
        ));

    }

}
?>