<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Entidades extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    function ver($codigo) {

        $options['filtros']['servicios'] = array($codigo);
        $data['fichas'] = Doctrine::getTable('Ficha')->findPublicados($options);

        $data['theme_page'] = "d";
        $data['theme_header'] = "a";

        $entidad = Doctrine::getTable('Servicio')->findOneByCodigo($codigo);

        if ($entidad->nombre) {

            $data['title'] = '' . $entidad->nombre;
            $data['content'] = 'movil/verentidad';
            $data['vista_ficha'] = true;
            $data['entidad'] = $entidad;
            
        } else {
            redirect('movil/ficha/error/');
        }

        $this->load->view('movil/template', $data);
    }

}
