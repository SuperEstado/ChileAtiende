<?php
class NoticiaTable extends Doctrine_Table{

    function todasNoticias($options=array()) {
        
        $query = Doctrine_Query::create();
        $query->from('Noticia n');
        
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
    
    function publicados($options=array()) {
        $query= Doctrine_Query::create()
                ->from('Noticia n')
                ->where('n.publicado = 1');

        if(isset($options['limit']))
            $query->limit($options['limit']);
        if(isset($options['offset']))
            $query->offset($options['offset']);
        if(isset($options['order_by'])) {
            $query->orderBy($options['order_by']);
        }

        $resultado=NULL;
        if(isset($options['justCount']))
            $resultado=$query->count();
        else
            $resultado=$query->execute();

        return $resultado;
    }

    function ultimasNoticias($options=array()) {
        $query= Doctrine_Query::create()
                ->from('Noticia n')
                ->where('n.publicado = 1')
                ->orderBy('n.created_at desc');

        if(isset($options['limit']))
            $query->limit($options['limit']);
        if(isset($options['offset']))
            $query->offset($options['offset']);

        $resultado=NULL;
        if(isset($options['justCount']))
            $resultado=$query->count();
        else
            $resultado=$query->execute();

        return $resultado;
    }
}

?>
