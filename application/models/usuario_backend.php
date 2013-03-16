<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class UsuarioBackend extends Doctrine_Record {

    function setTableDefinition() {
        $this->hasColumn('id');
        $this->hasColumn('email');
        $this->hasColumn('nombres');
        $this->hasColumn('apellidos');
        $this->hasColumn('ministerial');
        $this->hasColumn('interministerial');
        $this->hasColumn('password');
        $this->hasColumn('activo');
    }

    function setUp() {
        parent::setUp();
        $this->actAs('Timestampable');

        $this->hasMany('Rol as Roles', array(
            'local' => 'usuario_backend_id',
            'foreign' => 'rol_id',
            'refClass' => 'UsuarioBackendHasRol'
        ));

        $this->hasMany('Historial as Historiales', array(
            'local' => 'id',
            'foreign' => 'usuario_backend_id'
        ));

        $this->hasMany('Servicio as Servicios', array(
            'local' => 'usuario_backend_id',
            'foreign' => 'servicio_codigo',
            'refClass' => 'UsuarioBackendHasServicio'
        ));
    }

    function setPassword($password) {
        $hashPassword = sha1($password);
        $this->_set('password', $hashPassword);
    }

    function tieneRol($roles) {

        //Cambio para validar varios roles de una vez
        if (!is_array($roles)) {
            $roles = array($roles);
        }
        foreach ($this->Roles as $r) {
            foreach ($roles as $rol) {
                if ($r->id == $rol) {
                    return true;
                }
            }
        }


        return false;
    }
    
    function tieneServicio($servicios) {

        //Cambio para validar varios roles de una vez
        if (!is_array($servicios)) {
            $servicios = array($servicios);
        }
        foreach ($this->Servicios as $s) {
            foreach ($servicios as $servicio) {
                if ($s->codigo == $servicio) {
                    return true;
                }
            }
        }


        return false;
    }

    function setRolesFromArray($roles) {

        foreach ($this->Roles as $key => $c)
            unset($this->Roles[$key]);

        if ($roles)
            foreach ($roles as $rol)
                $this->Roles[] = Doctrine::getTable('Rol')->find($rol);
    }
    
    function setServiciosFromArray($servicios) {

        foreach ($this->Servicios as $key => $c)
            unset($this->Servicios[$key]);

        if ($servicios)
            foreach ($servicios as $s)
                $this->Servicios[] = Doctrine::getTable('Servicio')->find($s);
    }

    //Retorna las entidades accesibles por el usuario
    function getEntidadesAccesibles() {        
        $entidades = Doctrine_Collection::create('Entidad');
        if ($this->interministerial)
            $entidades = Doctrine::getTable('Entidad')->findAll();
        else/* if($this->ministerial) */ {
            foreach($this->Servicios as $s)
                $entidades[] = $s->Entidad;
        }

        return $entidades;
    }

    //Retorna los servicios accesible por el usuario
    //El campo entidad es opcional y permite que te muestre los servicios accesibles dentro de una entidad dada.
    function getServiciosAccesibles($entidad=0) {
        foreach($this->Servicios as $s)
            $array_servicios[]=$s->codigo;
        
        $servicios = Doctrine_Collection::create('Servicio');
        
        if ($this->interministerial) {
            if (!$entidad)
                $servicios = Doctrine::getTable('Servicio')->findAll();
            else
                $servicios=Doctrine::getTable('Entidad')->find($entidad)->Servicios;
        }

        else if ($this->ministerial){
            if(!$entidad){
                $servicios=Doctrine_Query::create()
                    ->from('Servicio s, s.Entidad e, e.Servicios serv')
                    ->whereIn('serv.codigo',$array_servicios)
                    ->execute();
            }else{
                $servicios=Doctrine_Query::create()
                    ->from('Servicio s, s.Entidad e, e.Servicios serv')
                    ->whereIn('serv.codigo',$array_servicios)
                    ->andWhere('e.codigo = ?',$entidad)
                    ->execute();
            }
        }
        else{
            if(!$entidad){
                $servicios = $this->Servicios;    
            }
            else{
                $servicios=Doctrine_Query::create()
                    ->from('Servicio s, s.Entidad e')
                    ->whereIn('s.codigo',$array_servicios)
                    ->andWhere('e.codigo = ?',$entidad)
                    ->execute();
            }
                
        }

        return $servicios;
    }

    function canAccessFicha($ficha_id) {
        $ficha = Doctrine::getTable('Ficha')->find($ficha_id);
        if ($ficha)
            return ($this->user->canAccessServicio($ficha->Servicio->codigo));
        else
            return FALSE;
    }

    function canAccessServicio($servicio_codigo) {
        $servicio = Doctrine::getTable('Servicio')->find($servicio_codigo);

        if ($this->interministerial)
            return TRUE;
        else if ($this->ministerial) {
            foreach($this->Servicios as $s)
                if ($s->Entidad->codigo == $servicio->Entidad->codigo)
                    return TRUE;
        }
        else {
            foreach($this->Servicios as $s)
                if ($s->codigo == $servicio_codigo)
                    return TRUE;
        }


        return FALSE;
    }

    function canAccessEntidad($entidad_codigo) {
        $entidad = Doctrine::getTable('Entidad')->find($entidad_codigo);

        if ($this->interministerial)
            return TRUE;
        else if ($this->ministerial) {
            if ($this->Servicio->Entidad->codigo == $entidad->codigo)
                return TRUE;
        }


        return FALSE;
    }

    function canAccessGobierno() {
        if ($this->interministerial)
            return TRUE;

        return FALSE;
    }

}

?>
