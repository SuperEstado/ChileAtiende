<?php
class ChileclicTema extends Doctrine_Record {
    function  setTableDefinition() {
        $this->hasColumn('id');
        $this->hasColumn('nombre');
        $this->hasColumn('chileclic_tipo_id');
    }

    function  setUp() {
        parent::setUp();

        $this->hasMany('ChileclicSubtema as ChileclicSubtemas', array(
            'local' => 'id',
            'foreign' => 'chileclic_tema_id',
            'orderBy' => 'nombre'
        ));

        $this->hasOne('ChileclicTipo', array(
            'local' => 'chileclic_tipo_id',
            'foreign' => 'id'
        ));

    }

}
?>