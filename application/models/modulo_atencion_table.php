<?php
class ModuloAtencionTable extends Doctrine_Table {
    public function ModulosOrdenados() {
        $query = Doctrine_Query::create();
        $query->from('ModuloAtencion m');
        $query->OrderBy('sector_codigo ASC');
        
        $resultado = $query->execute();

        return $resultado;
    }
}
