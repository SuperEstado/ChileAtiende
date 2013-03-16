<?php
class FlujoTable extends Doctrine_Table {
    function getFlujos($options=array()) {
        $query = Doctrine_Query::create();
        $query->from('Flujo f');
        
        $query->orderBy('f.titulo ASC');

        if (isset($options['limit']))
            $query->limit($options['limit']);
        if (isset($options['offset']))
            $query->offset($options['offset']);

        $resultado = NULL;
        if (isset($options['justCount']))
            $resultado = $query->count();
        else
            $resultado = $query->execute();

        return $resultado;
    }    
}