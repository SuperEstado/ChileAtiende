<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class UsuarioBackendSesion {
    private static $user;

    function login($email, $password) {
        $u = Doctrine::getTable('UsuarioBackend')->findOneByEmail($email);

        $usuarioEntrada = new UsuarioBackend();
        $usuarioEntrada->email = $email;
        $usuarioEntrada->password = $password;

        if( $u && $u->password == $usuarioEntrada->password ) {
            $CI = & get_instance();
            $CI->session->set_userdata('usuario_id', $u->id);
            
            if($u->interministerial)
                $CI->session->set_userdata('entidad', '0');
            else
                $CI->session->set_userdata('entidad', $u->Servicios[0]->Entidad->codigo);

            if($u->interministerial || $u->ministerial)
                $CI->session->set_userdata('servicio', '0');
            else
                $CI->session->set_userdata('servicio', $u->Servicios[0]->codigo);
     
            self::$user = $u;
            return true;
        }

        return false;
    }

    function usuario() {

        $CI = & get_instance();

        if( !isset(self::$user) ) {
            $usuarioId = $CI->session->userdata('usuario_id');

            if( !$usuarioId ){
                return false;
            }

            $u = Doctrine::getTable('UsuarioBackend')->findOneById($usuarioId);
            if( !$u ){
                return false;
            }

            self::$user = $u;

        }

        return self::$user;
    }

    function checkLogin() {
        if( !self::usuario() )
            redirect ('backend/autenticacion/login');
    }

    function logout() {
        $CI = & get_instance();
        $CI->session->unset_userdata('usuario_id');
        self::$user = NULL;
    }

    public static function setEntidad($entidad) {
        $CI = & get_instance();
        $CI->session->set_userdata('entidad', $entidad);
    }

    public static function getEntidad() {
        $CI = & get_instance();
        return $CI->session->userdata('entidad');
    }

    public static function setServicio($servicio) {
        $CI = & get_instance();
        $CI->session->set_userdata('servicio', $servicio);
    }

    public static function getServicio() {
        $CI = & get_instance();
        return $CI->session->userdata('servicio');
    }
    //prueba de titulo
    /*public static function setTitulo($titulo) {
        $CI = & get_instance();
        $CI->session->set_userdata('titulo', $titulo);
    }

    public static function getTitulo() {
        $CI = & get_instance();
        return $CI->session->userdata('titulo');
    }*/
}
?>
