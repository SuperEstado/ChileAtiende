<?php
class FlujoHasHechoVida extends Doctrine_Record {
    function  setTableDefinition() {
        $this->hasColumn('flujo_id','integer',4,array (
            'primary' => true,
            'autoincrement' => false
        ));
        
        $this->hasColumn('hecho_vida_id','integer',4,array (
            'primary' => true,
            'autoincrement' => false
        ));
    }
}
?>
