<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class FichaHasTag extends Doctrine_Record {
    function  setTableDefinition() {
        $this->hasColumn('ficha_id','integer',4,array (
            'primary' => true,
            'autoincrement' => false
        ));
        $this->hasColumn('tag_id','integer',4,array (
            'primary' => true,
            'autoincrement' => false
        ));
    }
}
?>
