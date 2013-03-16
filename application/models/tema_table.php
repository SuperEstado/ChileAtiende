<?php

class TemaTable extends Doctrine_Table {

    /**
     * Funcion que implementa la busqueda de temas de fichas asociadas a la busqueda
     */
    function findTemasBusqueda($set_de_fichas) {

        $query = Doctrine_Query::create();
        $query->select("t.id, t.nombre, COUNT(t.id) AS numero_fichas");
        $query->from('Tema t, t.Fichas f');
        
        if ($set_de_fichas) {
            $query->where("f.id IN (" . $set_de_fichas . ")");
        } else {
            $query->where("f.id IN (0)");
        }

        $query->groupBy("t.id");
        $query->orderBy("t.nombre ASC");
        return $query->execute();
    }

}