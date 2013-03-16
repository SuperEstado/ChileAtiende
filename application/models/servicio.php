<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Servicio extends Doctrine_Record {
    function  setTableDefinition() {
        $this->hasColumn('codigo', 'string', 8, array (
            'primary' => true,
            'autoincrement' => false
        ));
        $this->hasColumn('nombre');
        $this->hasColumn('sigla');
        $this->hasColumn('url');
        $this->hasColumn('responsable');
        $this->hasColumn('entidad_codigo');
        $this->hasColumn('mision');
    }

    function  setUp() {
        parent::setUp();
        $this->hasMany('Ficha as Fichas', array(
            'local' => 'codigo',
            'foreign' => 'servicio_codigo'
        ));

        $this->hasOne('Entidad', array(
            'local' => 'entidad_codigo',
            'foreign' => 'codigo'
        ));

        $this->hasMany('Oficina as Oficinas', array(
            'local' => 'codigo',
            'foreign' => 'servicio_codigo'
        ));
        
        $this->hasMany('ModuloAtencion as Modulos', array(
            'local' => 'codigo',
            'foreign' => 'servicio_codigo'
        ));
        
        $this->hasMany('UsuarioBackend as UsuariosBackend', array(
            'local' => 'servicio_codigo',
            'foreign' => 'usuario_backend_id',
            'refClass' => 'UsuarioBackendHasServicio'
        ));
    }

    //Retorna la ficha convertida en array, solamente con los campos visibles al publico a traves de la API.
    public function toPublicArray(){

        $publicArray=array(
            'id'=>$this->codigo,
            'sigla'=>$this->sigla,
            'nombre'=>$this->nombre,
            'url'=>$this->url,
            'mision'=>$this->mision,
        );

        return $publicArray;
    }
}
?>
