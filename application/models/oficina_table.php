<?php
class OficinaTable extends Doctrine_Table{

    function ips() {
        $query= Doctrine_Query::create()
                ->from('Oficina o')
                ->where('servicio_codigo = ?','AL005');

        return $query->execute();
    }

    /*
     * Obtiene todas las oficinas
     */
    function allOficinas($options=array()) {
        $query = Doctrine_Query::create()
                ->from('Oficina o');

        if (isset($options['limit']))
            $query->limit($options['limit']);

        if (isset($options['offset']))
            $query->offset($options['offset']);

        if(isset($options['order_by'])) {
            $query->orderBy($options['order_by']);
        }

        if(isset($options['justCount']))
            $resultado = $query->count();
        else
            $resultado = $query->execute();

        return $resultado;
    }

}

?>
