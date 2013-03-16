<?php
class EtapaVida extends Doctrine_Record {
    function  setTableDefinition() {
        $this->hasColumn('id');
        $this->hasColumn('orden');
        $this->hasColumn('nombre');
        $this->hasColumn('descripcion');
    }

    function  setUp() {
        parent::setUp();
        $this->actAs('Timestampable');

        $this->hasMany('HechoVida as HechosVida', array(
            'local' => 'etapa_vida_id',
            'foreign' => 'hecho_vida_id',
            'refClass' => 'EtapaVidaHasHechoVida'
        ));
    }
}

?>
