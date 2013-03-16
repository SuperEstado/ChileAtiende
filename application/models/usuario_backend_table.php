<?php

class UsuarioBackendTable extends Doctrine_Table {
    
    function todosUsuarios($options=array()) {
        
        $query = Doctrine_Query::create();
        $query->from('UsuarioBackend ub');
        
        //despliega los usuarios activos
        if(isset($options['activos'])) {
            $query->where('activo = ?', $options['activos']);
        }
        
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
    
    function tipoUsuarios($tipo='') {
        $query = Doctrine_Query::create();
        $query->from('UsuarioBackend ub, ub.Roles r');
        $query->where('r.id LIKE ?', $tipo);
        $query->andwhere('ub.activo = 1');
        $resultado = $query->execute();

        return $resultado;
    }
}