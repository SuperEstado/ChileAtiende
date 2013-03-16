<?php

class ServicioTable extends Doctrine_Table {

    function findServicios($entidad=NULL, $servicio=NULL, $options=array()) {
        $query = Doctrine_Query::create();
        $query->from('Servicio s');
                
        if ($entidad)
            $query->andWhere('s.entidad_codigo = ?', $entidad);
        if ($servicio)
            $query->andWhere('s.codigo = ?', $servicio);
        
        if (isset($options['limit']))
            $query->limit($options['limit']);
        if (isset($options['offset']))
            $query->offset($options['offset']);
        if (isset($options['order_by'])) {
            $query->orderBy($options['order_by']);
        } else {
            $query->orderBy('s.codigo ASC');
        }

        $resultado = NULL;
        if (isset($options['justCount']))
            $resultado = $query->count();
        else
            $resultado = $query->execute();

        return $resultado;
    }

    public function findConPublicaciones($options = array()) {
        $query = Doctrine_Query::create();
        $query->select("s.*,f.*, COUNT(s.codigo) AS numero_fichas");
        $query->from('Servicio s ,s.Fichas f');
        
        //si está definido el servicio, buscará todas las fichas que esten o no publicadas
        //así se previene de borrar un servicio que tiene fichas asociadas
        if (isset($options['servicio']))
            $query->where('f.servicio_codigo LIKE ?', $options['servicio']);
        else
            $query->where('f.publicado = 1 and f.maestro=0');
        
        $query->orderBy('s.nombre asc');
        $query->groupBy("s.codigo");

        if (isset($options['limit']))
            $query->limit($options['limit']);
        if (isset($options['offset']))
            $query->offset($options['offset']);

        $resultado = NULL;
        if (isset($options['justCount'])) {
            $resultado = $query->count();
        } else {
            //debug($query->getSqlQuery(),"red");
            $resultado = $query->execute();
        }
        return $resultado;
    }

    /**
     * Funcion que entrega lista de instituciones de fichas asociadas a la busqueda
     */
    function findServiciosBusqueda($set_de_fichas) {

        $query = Doctrine_Query::create();
        $query->select("s.codigo, s.nombre,COUNT(s.codigo) AS numero_fichas");
        $query->from('Servicio s, s.Fichas f');
        
        if ($set_de_fichas) {
            $query->where("f.id IN (" . $set_de_fichas . ")");
        } else {
            $query->where("f.id IN (0)");
        }

        $query->groupBy("s.codigo");
        $query->orderBy("s.nombre ASC");

        
        return $query->execute();
    }

    function findServiciosConFichas($entidad=NULL, $options=array()) {
        $query = Doctrine_Query::create();

        $query->select('s.*');
        $query->from('Servicio s, s.Fichas f, s.Entidad e');
        $query->where('f.maestro = 0 AND f.publicado = 1');
        if($entidad)
            $query->andWhere('e.codigo LIKE ? ', $entidad);
        $query->groupBy('s.nombre');

        $servicios = $query->execute();

        return $servicios;
    }

}

?>
