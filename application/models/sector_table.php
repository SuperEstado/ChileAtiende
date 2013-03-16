<?php
class SectorTable extends Doctrine_Table{

    function porComuna() {
        $query= Doctrine_Query::create()
                ->from('Sector s')
                ->where('tipo LIKE ?','comuna')
                ->orderBy('lat DESC');

        return $query->execute();
    }

}

?>
