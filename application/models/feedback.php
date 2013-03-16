<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Feedback extends Doctrine_Record {
    function  setTableDefinition() {
        $this->hasColumn('id');
        $this->hasColumn('nombre');
        $this->hasColumn('a_paterno');
        $this->hasColumn('a_materno');
        $this->hasColumn('email');
        $this->hasColumn('asunto');
        $this->hasColumn('comentario');
        $this->hasColumn('enviado');
        $this->hasColumn('created_at');
        $this->hasColumn('origen');
    }

    function  setUp() {
        parent::setUp();
    }
}
?>
