<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Noticia extends Doctrine_Record {
    function  setTableDefinition() {
        $this->hasColumn('id');
        $this->hasColumn('titulo');
        $this->hasColumn('alias');
        $this->hasColumn('resumen');
        $this->hasColumn('contenido');
        $this->hasColumn('foto');
        $this->hasColumn('publicado');
        $this->hasColumn('publicado_at');
        $this->hasColumn('foto_descripcion');
    }

    function  setUp() {
        parent::setUp();
        $this->actAs('Timestampable');
    }
}
?>
