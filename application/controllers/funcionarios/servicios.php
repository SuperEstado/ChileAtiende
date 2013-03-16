<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Servicios extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper("form_helper");
        $this->fichas_por_pagina = 4;
    }

    function index() {

        //Configuracion base
        $data['content'] = 'funcionarios/servicio';
        $data['title'] = 'Buscar Fichas por Servicio';
        $data['on'] = 'listar';
        $data['listar_on'] = "servicio";
        $data['cookie_favoritos'] = json_decode($this->input->cookie('favoritos'));
        $data['servicios'] = Doctrine::getTable('Servicio')->findConPublicaciones();

        //Se realiza una busqueda
        //Seteo la configuracion de busqueda para el modelo de doctrine
        if($this->input->get_post('servicio')){
            $servicio = $this->input->get_post('servicio');
            $data['fichas'] = Doctrine::getTable('Ficha')->findFichaOnServicio($servicio);
        }

        $this->load->view('funcionarios/template', $data);
    }

}

?>
