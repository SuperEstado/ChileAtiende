<?php
class HechoVida extends Doctrine_Record {
    function  setTableDefinition() {
        $this->hasColumn('id');
        $this->hasColumn('nombre');
        $this->hasColumn('descripcion');
    }

    function  setUp() {
        parent::setUp();
        $this->actAs('Timestampable');

        $this->hasMany('Ficha as Fichas', array(
            'local' => 'hecho_vida_id',
            'foreign' => 'ficha_id',
            'refClass' => 'FichaHasHechoVida'
        ));

        $this->hasMany('EtapaVida as EtapasVida', array(
            'local' => 'hecho_vida_id',
            'foreign' => 'etapa_vida_id',
            'refClass' => 'EtapaVidaHasHechoVida'
        ));
/*
        $this->hasMany('FlujoVida as FlujosVida', array(
            'local' => 'hecho_vida_id',
            'foreign' => 'flujo_id',
            'refClass' => 'FlujoHasHechoVida'
        ));
 *
 */
        $this->hasMany('Flujo as Flujos', array(
            'local' => 'hecho_vida_id',
            'foreign' => 'flujo_id',
            'refClass' => 'FlujoHasHechoVida'
        ));

    }

    function hasEtapa($etapa_id) {
        foreach ($this->EtapasVida as $etapa) {
            if ($etapa_id == $etapa->id)
                return TRUE;
        }
        return FALSE;
    }

    public function  toString() {
        return $this->nombre;

    }

    function setEtapasFromArray($etapas) {

        foreach ($this->EtapasVida as $key => $c)
            unset($this->EtapasVida[$key]);

        if ($etapas)
            foreach ($etapas as $etapa)
                $this->EtapasVida[] = Doctrine::getTable('EtapaVida')->find($etapa);
    }
}

?>
