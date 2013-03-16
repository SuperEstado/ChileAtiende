<?php
class HechoVidaTable extends Doctrine_Table {
    
    
    function todosHechos($options=array()) {
        
        $query = Doctrine_Query::create()
                ->from('HechoVida h')
                ->orderBy('h.nombre');
        
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
    
    //Retorna las
    function findLinked($etapa_vida){
        $query = Doctrine_Query::create();
        $query->select("h.id, h.nombre");
        $query->from('HechoVida h');
        $query->innerJoin('h.Fichas f');
        $query->leftJoin('h.EtapasVida e');
        $query->andWhere('f.maestro = 0 and f.publicado = 1');
        $query->andWhere('e.id = '.$etapa_vida);
        return $query->execute();
    }
    
    //Retorna un hecho de la vida asociado a un nombre y una etapa
    
    function getEtapaName($etapa_vida,$nombre){
        $query = Doctrine_Query::create();
        $query->select("h.id, h.nombre");
        $query->from('HechoVida h');
        $query->leftJoin('h.EtapasVida e');
        $query->andWhere('e.id = ?',$etapa_vida);
        $query->andWhere('h.nombre LIKE ?',$nombre);
        return $query->execute();
    }
    
    //permite obtener nro de hechos de vida asociados a una etapa
    function obtieneHechos($id) {
        $query = Doctrine_Query::create();
        $query->select('COUNT(*) AS cnt');
        $query->from('HechoVida hv, hv.EtapasVida ev');
        $query->where('ev.id = ?', $id);
        //debug($query->getSqlQuery(),"red");
        $resultado = $query->fetchOne();
        
        return $resultado;
    }

}

?>
