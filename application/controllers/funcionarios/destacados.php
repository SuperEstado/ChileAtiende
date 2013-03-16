<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Destacados extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper("form_helper");
        $this->fichas_por_pagina = 4;
    }

    function index($window_position=FALSE) {

        //Configuracion base
        $data['content'] = 'funcionarios/destacados';
        $data['title'] = 'Trámites Destacados';
        $data['on'] = 'listar';
        $data['listar_on'] = "destacados";
        $data['cookie_favoritos'] = json_decode($this->input->cookie('favoritos'));

        //Se realiza una busqueda
        //Seteo la configuracion de busqueda para el modelo de doctrine
        $options_destacados['orderBy'] = 'destacado DESC';
        $options_mas_vistos['limit'] = $options_destacados['limit'] = 5;

        //Obtengo total de resultados y asigno variables de la paginacion
        $data['mas_vistos'] = Doctrine::getTable('Ficha')->MasVistas( array('limit'=>5) );
        $data['destacados'] = Doctrine::getTable('Ficha')->findPublicados($options_destacados);
        $data['window_position'] = TRUE;
        
        //habilitamos o deshabilitamos la posicion de la ventana emergente
        if(isset($window_position) && $window_position) {
            $data['window_position'] = FALSE;
        }

        $this->load->view('funcionarios/template', $data);
    }
    
    function crm() {
        echo $this->index(TRUE);
    }

}

?>
