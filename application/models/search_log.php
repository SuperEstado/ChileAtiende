<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class SearchLog extends Doctrine_Record {
    
    function  setTableDefinition() {
        $this->hasColumn('id');
        $this->hasColumn('search_query');
        $this->hasColumn('search_query_parsed');
    }

    function  setUp() {
        parent::setUp();
        $this->actAs('Timestampable');
    }
}
?>
