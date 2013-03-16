<?php
class RangoEdadTable extends Doctrine_Table{

    function min_max($min,$max) {
        $query= Doctrine_Query::create()
                ->from('RangoEdad r')
                ->where('r.edad_minima = ?',$min)
                ->andwhere('r.edad_maxima = ?',$max)
                ->limit(1);

        return $query->execute();
    }

    /*Obtengo los ids de los rangos que contienen la edad buscada*/
    function rangosFromAge($age){
        $query= Doctrine_Query::create()
                ->from('RangoEdad r')
                ->where('r.edad_minima <= ?',$age)
                ->andwhere('r.edad_maxima >= ?',$age);
        //debug($query->getSqlQuery(),"green");
        $result = array();
        $q_res = $query->execute()->toArray();
        if($q_res && count($q_res))
        foreach($q_res  as $data){
            $result[] = $data['id'];
        }

        return $result;
    }

}

?>
