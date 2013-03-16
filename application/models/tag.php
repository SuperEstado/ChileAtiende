<?php
class Tag extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->hasColumn('id');
        $this->hasColumn('nombre');

    }

    public function setUp()
    {
        parent::setUp();
        
        $this->hasMany('Ficha as Fichas', array(
             'local' => 'tag_id',
             'foreign' => 'ficha_id',
             'refClass' => 'FichaHasTag'
        ));


    }

    public function  toString() {
        return $this->nombre;
    }

}