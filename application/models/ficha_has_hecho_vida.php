<?php
class FichaHasHechoVida extends Doctrine_Record {
    function  setTableDefinition() {
        $this->hasColumn('ficha_id','integer',4,array (
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
