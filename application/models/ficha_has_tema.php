<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class FichaHasTema extends Doctrine_Record {
    function  setTableDefinition() {
        $this->hasColumn('ficha_id','integer',4,array (
            'primary' => true,
            'autoincrement' => false
        ));
        
        $this->hasColumn('tema_id','integer',4,array (
            'primary' => true,
            'autoincrement' => false
        ));
    }
}
?>
