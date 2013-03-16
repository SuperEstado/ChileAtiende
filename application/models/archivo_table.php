<?php

class ArchivoTable extends Doctrine_Table {

    function  ficha($ficha_id){
        $query = Doctrine_Query::create();
        $query->from('Archivo a');
        $query->andWhere('a.ficha_id = ?',$ficha_id);
        return $query->execute();
    }
}
?>
