<?php

class HitTable extends Doctrine_Table {

    function insertaVista($idFicha) {
        
        $aData = array($idFicha, date('Y-m-d'));
        $query = Doctrine_Query::create()->from('Hit');
        $query->where("ficha_id=? AND fecha=?", $aData);
        
        //echo $query->getSqlQuery(); 
        ///print_r(  $query->execute()->toArray() );
        //print_r(  $aData );
        
        //exit();
        
        $fichaHit = $query->execute();
        $fichaHit = $fichaHit[0];
        if ($fichaHit->fecha == date('Y-m-d')) {
            $fichaHit->count = $fichaHit->count + 1;
            $fichaHit->save();
        } else {
            $fichaHit = new Hit();
            $fichaHit->count = 1;
            $fichaHit->fecha = date('Y-m-d');
            $fichaHit->ficha_id = $idFicha;
            $fichaHit->save();
        }
    }

}