<?php

class Tags extends CI_Controller {

    function __construct() {
        parent::__construct();

        if($this->config->item('ssl'))force_ssl();

        UsuarioBackendSesion::checkLogin();
    }

    function ajax_get_tags() {
        if(!UsuarioBackendSesion::usuario()->tieneRol('editor')){
            echo 'No tiene permisos';
            exit;
        }

        $term = $this->input->get('term');

        $tags = Doctrine_Query::create()
                        ->from('Tag t')
                        ->where('t.nombre LIKE ?', $term . '%')
                        ->execute();

        $resultado = array();
        foreach ($tags as $t)
            $resultado[] = $t->nombre;

        header('Content-Type: application/json');
        echo json_encode($resultado);
    }

}